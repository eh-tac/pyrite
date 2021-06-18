import { Briefing } from "../briefing";
import { Byteable } from "../../../byteable";
import { FileHeader } from "../file-header";
import { FlightGroup } from "../flight-group";
import { GlobalGoal } from "../global-goal";
import { IMission, PyriteBase } from "../../../pyrite-base";
import { Message } from "../message";
import { Team } from "../team";
import { getString, writeObject, writeString } from "../../../hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class MissionBase extends PyriteBase implements Byteable {
  public MissionLength: number;
  public FileHeader: FileHeader;
  public FlightGroups: FlightGroup[];
  public Messages: Message[];
  public GlobalGoals: GlobalGoal[];
  public Teams: Team[];
  public Briefing: Briefing[];
  public FGGoalStrings: string[];
  public GlobalGoalStrings: string[];
  public MissionDescription: string;
  
  constructor(hex: ArrayBuffer, tie?: IMission) {
    super(hex, tie);
    this.beforeConstruct();
    let offset = 0;

    this.FileHeader = new FileHeader(hex.slice(0x000), this.TIE);
    this.FlightGroups = [];
    offset = 0x0A4;
    for (let i = 0; i < this.FileHeader.NumFGs; i++) {
      const t = new FlightGroup(hex.slice(offset), this.TIE);
      this.FlightGroups.push(t);
      offset += t.getLength();
    }
    this.Messages = [];
    offset = offset;
    for (let i = 0; i < this.FileHeader.NumMessages; i++) {
      const t = new Message(hex.slice(offset), this.TIE);
      this.Messages.push(t);
      offset += t.getLength();
    }
    this.GlobalGoals = [];
    offset = offset;
    for (let i = 0; i < 10; i++) {
      const t = new GlobalGoal(hex.slice(offset), this.TIE);
      this.GlobalGoals.push(t);
      offset += t.getLength();
    }
    this.Teams = [];
    offset = offset;
    for (let i = 0; i < 10; i++) {
      const t = new Team(hex.slice(offset), this.TIE);
      this.Teams.push(t);
      offset += t.getLength();
    }
    this.Briefing = [];
    offset = offset;
    for (let i = 0; i < 8; i++) {
      const t = new Briefing(hex.slice(offset), this.TIE);
      this.Briefing.push(t);
      offset += t.getLength();
    }
    this.FGGoalStrings = [];
    offset = offset;
    for (let i = 0; i < this.FGGoalStringCount(); i++) {
      const t = getString(hex, offset, 64);
      this.FGGoalStrings.push(t);
      offset += t.length + 1;
    }
    this.GlobalGoalStrings = [];
    offset = offset;
    for (let i = 0; i < 360; i++) {
      const t = getString(hex, offset, 64);
      this.GlobalGoalStrings.push(t);
      offset += t.length + 1;
    }
    this.MissionDescription = getString(hex, offset, 1024);
    this.MissionLength = offset;
  }
  
  public toJSON(): object {
    return {
      FileHeader: this.FileHeader,
      FlightGroups: this.FlightGroups,
      Messages: this.Messages,
      GlobalGoals: this.GlobalGoals,
      Teams: this.Teams,
      Briefing: this.Briefing,
      FGGoalStrings: this.FGGoalStrings,
      GlobalGoalStrings: this.GlobalGoalStrings,
      MissionDescription: this.MissionDescription
    };
  }
  
  public toHexString(): string {
    let hex: string = '';
    let offset = 0;

    writeObject(hex, this.FileHeader, 0x000);
    offset = 0x0A4;
    for (let i = 0; i < this.FileHeader.NumFGs; i++) {
      const t = this.FlightGroups[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    offset = offset;
    for (let i = 0; i < this.FileHeader.NumMessages; i++) {
      const t = this.Messages[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    offset = offset;
    for (let i = 0; i < 10; i++) {
      const t = this.GlobalGoals[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    offset = offset;
    for (let i = 0; i < 10; i++) {
      const t = this.Teams[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    offset = offset;
    for (let i = 0; i < 8; i++) {
      const t = this.Briefing[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    offset = offset;
    for (let i = 0; i < this.FGGoalStringCount(); i++) {
      const t = this.FGGoalStrings[i];
      writeString(hex, t, offset);
      offset += t.length + 1;
    }
    offset = offset;
    for (let i = 0; i < 360; i++) {
      const t = this.GlobalGoalStrings[i];
      writeString(hex, t, offset);
      offset += t.length + 1;
    }
    writeString(hex, this.MissionDescription, offset);

    return hex;
  }
  
  protected abstract FGGoalStringCount();
  public getLength(): number {
    return this.MissionLength;
  }
}