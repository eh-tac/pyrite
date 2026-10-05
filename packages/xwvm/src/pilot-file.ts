/* eslint-disable unicorn/no-computed-property-existence-check */
import type { BattleSummary as BaseBattleSummary, MissionScore } from '@pyrite/core';
import { JSDOM } from 'jsdom';

export interface XWVMMissionScore extends MissionScore {
  name: string;
  battle: string;
  mission: number;
  tourStep?: number;
  hash?: string;
}

export interface XWVMBattleSummary extends BaseBattleSummary<XWVMMissionScore> {
  battle: string;
}

interface ParsedTag {
  name: string;
  closing: boolean;
  selfClosing: boolean;
  attributes: Record<string, string>;
}

export class PilotFile {
  public Name = '';
  public Valid = false;
  public Errors: string[] = [];
  public BattleSummary: XWVMBattleSummary[] = [];
  public MissionScores: XWVMMissionScore[] = [];

  public constructor(file: ArrayBuffer | string) {
    this.loadXml(typeof file === 'string' ? file : new TextDecoder('utf-8').decode(file));
  }

  public get TotalScore(): number {
    return this.MissionScores.reduce(
      (total: number, mission: XWVMMissionScore) => total + mission.score,
      0
    );
  }

  public get CompletedMissionScores(): number[] {
    return this.MissionScores.map((mission: XWVMMissionScore) => mission.score);
  }

  public get CompletedOnlyMissionScores(): number[] {
    return this.MissionScores.filter((mission: XWVMMissionScore) => mission.completed).map(
      (mission: XWVMMissionScore) => mission.score
    );
  }

  public listCompleteBattles(): string[] {
    return this.BattleSummary.filter((battle: XWVMBattleSummary) => battle.completed).map(
      (battle: XWVMBattleSummary) => battle.battle
    );
  }

  public getBattle(code: string): XWVMBattleSummary | undefined {
    return this.BattleSummary.find((battle: XWVMBattleSummary) => battle.battle === code);
  }

  private loadXml(xml: string): void {
    if (!this.isWellFormedXml(xml)) {
      return;
    }

    const root = this.readFirstTag(xml);
    if (!root || root.name !== 'PilotRecord') {
      this.Valid = false;
      this.Errors.push('Expected PilotRecord XML root element.');
      return;
    }

    this.Valid = true;
    this.Name = root.attributes.Name || '';

    const battles: Record<string, XWVMBattleSummary> = {};
    for (const operation of this.readOperationTags(xml)) {
      const mission = this.missionFromOperation(operation.attributes);
      if (!mission) {
        continue;
      }

      if (!battles[mission.battle]) {
        battles[mission.battle] = {
          hasData: true,
          battle: mission.battle,
          completed: true,
          status: 'Completed',
          missions: []
        };
      }

      if (!mission.completed) {
        battles[mission.battle].completed = false;
        battles[mission.battle].status = 'Incomplete';
      }

      battles[mission.battle].missions.push(mission);
      this.MissionScores.push(mission);
    }

    this.BattleSummary = Object.values(battles).map((battle: XWVMBattleSummary) => ({
      ...battle,
      missions: battle.missions.toSorted(
        (a: XWVMMissionScore, b: XWVMMissionScore) => a.mission - b.mission
      )
    }));
  }

  private missionFromOperation(attributes: Record<string, string>): XWVMMissionScore | undefined {
    const name = attributes.Name || '';
    const match = /^(XWVM.+)M(\d+)$/.exec(name);
    if (!match) {
      return undefined;
    }

    return {
      name,
      hasData: true,
      battle: match[1],
      mission: Number(match[2]),
      score: Number(attributes.Score || '0'),
      completed: (attributes.Complete || '').toLowerCase() === 'true',
      tourStep: attributes.TourStep === undefined ? undefined : Number(attributes.TourStep),
      hash: attributes.Hash || ''
    };
  }

  private isWellFormedXml(xml: string): boolean {
    if (JSDOM !== undefined) {
      const doc = new JSDOM(xml, { contentType: 'application/xml' }).window.document;
      const parserError = doc.querySelectorAll(':scope parsererror');
      if (parserError.length > 0) {
        this.Valid = false;
        this.Errors.push(parserError[0].textContent || 'Invalid XML.');
        return false;
      }
      return true;
    }

    return this.isWellFormedXmlFallback(xml);
  }

  private isWellFormedXmlFallback(xml: string): boolean {
    const stack: string[] = [];
    const tagPattern = /<[^>]+>|[^<]+/g;
    let match: RegExpExecArray | null;

    while ((match = tagPattern.exec(xml)) !== null) {
      const token = match[0];
      if (!token.startsWith('<')) {
        continue;
      }

      const tag = this.parseTag(token);
      if (!tag) {
        this.Valid = false;
        this.Errors.push(`Invalid XML tag: ${token}`);
        return false;
      }

      if (tag.closing) {
        const open = stack.pop();
        if (open !== tag.name) {
          this.Valid = false;
          this.Errors.push(`Mismatched XML tag: expected ${open || 'none'}, got ${tag.name}.`);
          return false;
        }
      } else if (!tag.selfClosing) {
        stack.push(tag.name);
      }
    }

    if (stack.length > 0) {
      this.Valid = false;
      this.Errors.push(`Unclosed XML tag: ${stack.at(-1)}.`);
      return false;
    }

    return true;
  }

  private readFirstTag(xml: string): ParsedTag | undefined {
    const tagPattern = /<[^>]+>/g;
    let match: RegExpExecArray | null;
    while ((match = tagPattern.exec(xml)) !== null) {
      const tag = this.parseTag(match[0]);
      if (tag && tag.name && !tag.closing) {
        return tag;
      }
    }
    return undefined;
  }

  private readOperationTags(xml: string): ParsedTag[] {
    const operations: ParsedTag[] = [];
    const tagPattern = /<PilotOperationRecord\b[^>]*>/g;
    let match: RegExpExecArray | null;
    while ((match = tagPattern.exec(xml)) !== null) {
      const tag = this.parseTag(match[0]);
      if (tag && tag.attributes.Name) {
        operations.push(tag);
      }
    }
    return operations;
  }

  private parseTag(token: string): ParsedTag | undefined {
    if (/^<\?/.test(token) || token.startsWith('<!--') || token.startsWith('<!')) {
      return {
        name: '',
        closing: false,
        selfClosing: true,
        attributes: {}
      };
    }

    const isClosing = /^<\//.test(token);
    const isSelfClosing = /\/>$/.test(token);
    const nameMatch = /^<\/?\s*([A-Za-z_][\w:.-]*)/.exec(token);
    if (!nameMatch) {
      return undefined;
    }

    const attributes: Record<string, string> = {};
    const attrPattern = /([A-Za-z_][\w:.-]*)\s*=\s*"([^"]*)"/g;
    let attrMatch: RegExpExecArray | null;
    while ((attrMatch = attrPattern.exec(token)) !== null) {
      attributes[attrMatch[1]] = attrMatch[2];
    }

    return {
      name: nameMatch[1],
      closing: isClosing,
      selfClosing: isSelfClosing,
      attributes
    };
  }
}
