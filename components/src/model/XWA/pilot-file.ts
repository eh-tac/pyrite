import { BattleSummary } from "../pilot";
import { MissionData } from "../XWA";
import { PilotFileBase } from "./base/pilot-file-base";
import { Constants } from "./constants";

export interface TriStat {
  Label: string;
  TourOfDuty: string | number;
  Azzameen: string | number;
  Simulator: string | number;
}

const BaseMissionCounts: number[] = [9, 7, 6, 7, 6, 7, 7, 4];
const TFTCRCounts: Record<number, number> = {
  3: 4,
  9: 6,
  15: 5,
  20: 5,
  25: 5,
  30: 4,
  34: 4,
  38: 3,
  41: 5
};

export class PilotFile extends PilotFileBase {
  public beforeConstruct(): void {}

  public toString(): string {
    return "";
  }

  public get BonusScore(): number {
    return this.BonusTen / 10;
  }

  public get LaserLabel(): string {
    return this.shootInfo(this.LasersHit, this.LasersFired);
  }

  public get LaserPercent(): string {
    return this.percent(this.LasersHit, this.LasersFired);
  }

  public get WarheadLabel(): string {
    return this.shootInfo(this.WarheadsHit, this.WarheadsFired);
  }

  public get WarheadPercent(): string {
    return this.percent(this.WarheadsHit, this.WarheadsFired);
  }

  public get BattleSummary(): BattleSummary[] {
    const battles: BattleSummary[] = [];
    let mIdx = 0;

    function processMissions(missions: MissionData[], expectedCount: number = 0) {
      const won = missions.filter(m => m.WinCount && m.AttemptCount).length;
      const completed = won === expectedCount;
      let status = "None";
      if (completed && won === expectedCount) {
        status = "Completed";
      } else if (won && expectedCount) {
        status = "Incomplete";
      } else if (won && !expectedCount) {
        status = "Custom battle";
      }
      battles.push({ completed, status, missions });
      mIdx += expectedCount;
    }

    if (this.hasMissionData(0)) {
      // base XWA starts from 0
      for (const mCount of BaseMissionCounts) {
        const missions = this.MissionData.slice(mIdx, mIdx + mCount);
        processMissions(missions, mCount);
      }
    } else if (!this.hasMissionData(2) && this.hasMissionData(3)) {
      // TFTCR starts from 3
      Object.entries(TFTCRCounts).forEach(([a, mCount]: [string, number]) => {
        mIdx = parseInt(a, 10);
        const missions = this.MissionData.slice(mIdx, mIdx + mCount);
        processMissions(missions, mCount);
      });
    } else if (!this.hasMissionData(52) && this.hasMissionData(53)) {
      // EH custom missions start at 53 (battle 8)
      for (let i = 0; i < 8; i++) {
        // add empty content for battles 0-7
        battles.push({ completed: false, status: "None", missions: [] });
      }
      mIdx = 53;
      // could be any number of custom missions added, but lets assume its not more than 53
      const missions = this.MissionData.slice(mIdx, mIdx * 2);
      processMissions(missions);
    }

    return battles;
  }

  public get BattleVictories(): TriStat[] {
    const victories: TriStat[] = [];
    for (let i = 1; i < this.TourOfDutyKills.length; i++) {
      if (this.hasTypeKills(i)) {
        victories.push({
          Label: Constants.CRAFTTYPE[i],
          TourOfDuty: `${this.TourOfDutyKills[i]} (${this.TourOfDutyPartials[i]})`,
          Azzameen: `${this.AzzameenKills[i]} (${this.AzzameenPartials[i]})`,
          Simulator: `${this.SimulatorKills[i]} (${this.SimulatorPartials[i]})`
        });
      }
    }
    return victories;
  }

  private shootInfo(hit: number, fired: number): string {
    return `${hit.toLocaleString()} / ${fired.toLocaleString()}`;
  }

  private percent(hit: number, fired: number): string {
    const per = fired ? Math.floor((hit / fired) * 100) : 0;
    return `${per} %`;
  }

  private hasTypeKills(type: number): boolean {
    const k: number =
      this.TourOfDutyKills[type] ||
      this.TourOfDutyPartials[type] ||
      this.AzzameenKills[type] ||
      this.AzzameenPartials[type] ||
      this.SimulatorKills[type] ||
      this.SimulatorPartials[type];
    return k > 0;
  }

  private hasMissionData(idx: number) {
    return !!this.MissionData[idx].AttemptCount;
  }
}
