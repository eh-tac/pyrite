import { Briefing } from '../briefing';
import { Byteable, IMission, PyriteBase } from '@pyrite/core';
import { FileHeader } from '../file-header';
import { FlightGroup } from '../flight-group';
import { GlobalGoal } from '../global-goal';
import { Message } from '../message';
import { Team } from '../team';
import { XWAString } from '../xwa-string';
import { getString, writeObject, writeString } from '@pyrite/core';
export abstract class MissionBase extends PyriteBase implements Byteable {
  public MissionLength: number;
  public FileHeader: FileHeader;
  public FlightGroups: FlightGroup[];
  public Messages: Message[];
  public GlobalGoals: GlobalGoal[];
  public Teams: Team[];
  public Briefings: Briefing[];
  public EditorNotes: string;
  public BriefingStringNotes: string[];
  public MessageNotes: string[];
  public EomNotes: string[];
  public DescriptionNotes: string[];
  public FGGoalStrings: XWAString[];
  public GlobalGoalStrings: XWAString[];
  public OrderStrings: XWAString[];
  public Descriptions: string[];

  constructor(hex: ArrayBuffer, TIE?: IMission) {
    super(hex, TIE!);
    this.beforeConstruct();
    let offset = 0;

    this.FileHeader = new FileHeader(hex.slice(0x0000), this.TIE);
    this.FlightGroups = [];
    offset = 0x23f0;
    for (let i = 0; i < this.FileHeader.NumFGs; i++) {
      const t = new FlightGroup(hex.slice(offset), this.TIE);
      this.FlightGroups.push(t);
      offset += t.getLength();
    }
    this.Messages = [];
    for (let i = 0; i < this.FileHeader.NumMessages; i++) {
      const t = new Message(hex.slice(offset), this.TIE);
      this.Messages.push(t);
      offset += t.getLength();
    }
    this.GlobalGoals = [];
    for (let i = 0; i < 10; i++) {
      const t = new GlobalGoal(hex.slice(offset), this.TIE);
      this.GlobalGoals.push(t);
      offset += t.getLength();
    }
    this.Teams = [];
    for (let i = 0; i < 10; i++) {
      const t = new Team(hex.slice(offset), this.TIE);
      this.Teams.push(t);
      offset += t.getLength();
    }
    this.Briefings = [];
    for (let i = 0; i < 2; i++) {
      const t = new Briefing(hex.slice(offset), this.TIE);
      this.Briefings.push(t);
      offset += t.getLength();
    }
    this.EditorNotes = getString(hex, offset, 6268);
    offset += 6268;
    this.BriefingStringNotes = [];
    for (let i = 0; i < 128; i++) {
      const t = getString(hex, offset, 100);
      this.BriefingStringNotes.push(t);
      offset += 100;
    }
    this.MessageNotes = [];
    for (let i = 0; i < 64; i++) {
      const t = getString(hex, offset, 100);
      this.MessageNotes.push(t);
      offset += 100;
    }
    this.EomNotes = [];
    for (let i = 0; i < 70; i++) {
      const t = getString(hex, offset, 100);
      this.EomNotes.push(t);
      offset += 100;
    }
    this.DescriptionNotes = [];
    for (let i = 0; i < 3; i++) {
      const t = getString(hex, offset, 100);
      this.DescriptionNotes.push(t);
      offset += 100;
    }
    this.FGGoalStrings = [];
    for (let i = 0; i < this.FGGoalStringCount(); i++) {
      const t = new XWAString(hex.slice(offset), this.TIE);
      this.FGGoalStrings.push(t);
      offset += t.getLength();
    }
    this.GlobalGoalStrings = [];
    for (let i = 0; i < 840; i++) {
      const t = new XWAString(hex.slice(offset), this.TIE);
      this.GlobalGoalStrings.push(t);
      offset += t.getLength();
    }
    this.OrderStrings = [];
    for (let i = 0; i < 3072; i++) {
      const t = new XWAString(hex.slice(offset), this.TIE);
      this.OrderStrings.push(t);
      offset += t.getLength();
    }
    this.Descriptions = [];
    for (let i = 0; i < 3; i++) {
      const t = getString(hex, offset, 4096);
      this.Descriptions.push(t);
      offset += 4096;
    }
    this.MissionLength = offset;
  }

  public toJSON(): Record<string, unknown> | string {
    return {
      FileHeader: this.FileHeader.toJSON(),
      FlightGroups: this.FlightGroups.map((t) => t.toJSON()),
      Messages: this.Messages.map((t) => t.toJSON()),
      GlobalGoals: this.GlobalGoals.map((t) => t.toJSON()),
      Teams: this.Teams.map((t) => t.toJSON()),
      Briefings: this.Briefings.map((t) => t.toJSON()),
      EditorNotes: this.EditorNotes,
      BriefingStringNotes: this.BriefingStringNotes,
      MessageNotes: this.MessageNotes,
      EomNotes: this.EomNotes,
      DescriptionNotes: this.DescriptionNotes,
      FGGoalStrings: this.FGGoalStrings.map((t) => t.toJSON()),
      GlobalGoalStrings: this.GlobalGoalStrings.map((t) => t.toJSON()),
      OrderStrings: this.OrderStrings.map((t) => t.toJSON()),
      Descriptions: this.Descriptions
    };
  }

  public toHexBuffer(): ArrayBuffer {
    const hex: ArrayBuffer = new ArrayBuffer(this.getLength());
    let offset = 0;

    writeObject(hex, this.FileHeader, 0x0000);
    offset = 0x23f0;
    for (let i = 0; i < this.FlightGroups.length; i++) {
      const t = this.FlightGroups[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    for (let i = 0; i < this.Messages.length; i++) {
      const t = this.Messages[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    for (let i = 0; i < this.GlobalGoals.length; i++) {
      const t = this.GlobalGoals[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    for (let i = 0; i < this.Teams.length; i++) {
      const t = this.Teams[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    for (let i = 0; i < this.Briefings.length; i++) {
      const t = this.Briefings[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    writeString(hex, this.EditorNotes, offset, 6268);
    offset += 6268;
    for (let i = 0; i < this.BriefingStringNotes.length; i++) {
      const t = this.BriefingStringNotes[i];
      writeString(hex, t, offset, 100);
      offset += 100;
    }
    for (let i = 0; i < this.MessageNotes.length; i++) {
      const t = this.MessageNotes[i];
      writeString(hex, t, offset, 100);
      offset += 100;
    }
    for (let i = 0; i < this.EomNotes.length; i++) {
      const t = this.EomNotes[i];
      writeString(hex, t, offset, 100);
      offset += 100;
    }
    for (let i = 0; i < this.DescriptionNotes.length; i++) {
      const t = this.DescriptionNotes[i];
      writeString(hex, t, offset, 100);
      offset += 100;
    }
    for (let i = 0; i < this.FGGoalStrings.length; i++) {
      const t = this.FGGoalStrings[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    for (let i = 0; i < this.GlobalGoalStrings.length; i++) {
      const t = this.GlobalGoalStrings[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    for (let i = 0; i < this.OrderStrings.length; i++) {
      const t = this.OrderStrings[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    for (let i = 0; i < this.Descriptions.length; i++) {
      const t = this.Descriptions[i];
      writeString(hex, t, offset, 4096);
      offset += 4096;
    }

    return hex;
  }

  protected abstract FGGoalStringCount(): number;
  public getLength(): number {
    return this.MissionLength;
  }
}
