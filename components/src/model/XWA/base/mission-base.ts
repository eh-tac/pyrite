import { Briefing } from "../briefing";
import { Byteable } from "../../../byteable";
import { FileHeader } from "../file-header";
import { FlightGroup } from "../flight-group";
import { GlobalGoal } from "../global-goal";
import { IMission, PyriteBase } from "../../../pyrite-base";
import { Message } from "../message";
import { Team } from "../team";
import { XWAString } from "../xwa-string";
import { getByte, getString, writeByte, writeObject, writeString } from "../../../hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

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
  public Unknown: number[];
  public DescriptionNotes: string[];
  public FGGoalStrings: XWAString[];
  public GlobalGoalStrings: XWAString[];
  public OrderStrings: XWAString[];
  public Descriptions: string[];
  
  constructor(hex: ArrayBuffer, tie?: IMission) {
    super(hex, tie);
    this.beforeConstruct();
    let offset = 0;

    this.FileHeader = new FileHeader(hex.slice(0x0000), this.TIE);
    this.FlightGroups = [];
    offset = 0x23F0;
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
    this.Briefings = [];
    offset = offset;
    for (let i = 0; i < 2; i++) {
      const t = new Briefing(hex.slice(offset), this.TIE);
      this.Briefings.push(t);
      offset += t.getLength();
    }
    this.EditorNotes = getString(hex, offset, 6268);
    this.BriefingStringNotes = [];
    offset = offset;
    for (let i = 0; i < 128; i++) {
      const t = getString(hex, offset, 100);
      this.BriefingStringNotes.push(t);
      offset += t.length + 1;
    }
    this.MessageNotes = [];
    offset = offset;
    for (let i = 0; i < 64; i++) {
      const t = getString(hex, offset, 100);
      this.MessageNotes.push(t);
      offset += t.length + 1;
    }
    this.EomNotes = [];
    offset = offset;
    for (let i = 0; i < 30; i++) {
      const t = getString(hex, offset, 100);
      this.EomNotes.push(t);
      offset += t.length + 1;
    }
    this.Unknown = [];
    offset = offset;
    for (let i = 0; i < 480; i++) {
      const t = getByte(hex, offset);
      this.Unknown.push(t);
      offset += 1;
    }
    this.DescriptionNotes = [];
    offset = offset;
    for (let i = 0; i < 3; i++) {
      const t = getString(hex, offset, 100);
      this.DescriptionNotes.push(t);
      offset += t.length + 1;
    }
    this.FGGoalStrings = [];
    offset = offset;
    for (let i = 0; i < this.FGGoalStringCount(); i++) {
      const t = new XWAString(hex.slice(offset), this.TIE);
      this.FGGoalStrings.push(t);
      offset += t.getLength();
    }
    this.GlobalGoalStrings = [];
    offset = offset;
    for (let i = 0; i < 360; i++) {
      const t = new XWAString(hex.slice(offset), this.TIE);
      this.GlobalGoalStrings.push(t);
      offset += t.getLength();
    }
    this.OrderStrings = [];
    offset = offset;
    for (let i = 0; i < 3072; i++) {
      const t = new XWAString(hex.slice(offset), this.TIE);
      this.OrderStrings.push(t);
      offset += t.getLength();
    }
    this.Descriptions = [];
    offset = offset;
    for (let i = 0; i < 3; i++) {
      const t = getString(hex, offset, 4096);
      this.Descriptions.push(t);
      offset += t.length + 1;
    }
    this.MissionLength = offset;
  }
  
  public toJSON(): object {
    return {
      FileHeader: this.FileHeader,
      FlightGroups: this.FlightGroups,
      Messages: this.Messages,
      GlobalGoals: this.GlobalGoals,
      Teams: this.Teams,
      Briefings: this.Briefings,
      EditorNotes: this.EditorNotes,
      BriefingStringNotes: this.BriefingStringNotes,
      MessageNotes: this.MessageNotes,
      EomNotes: this.EomNotes,
      Unknown: this.Unknown,
      DescriptionNotes: this.DescriptionNotes,
      FGGoalStrings: this.FGGoalStrings,
      GlobalGoalStrings: this.GlobalGoalStrings,
      OrderStrings: this.OrderStrings,
      Descriptions: this.Descriptions
    };
  }
  
  public toHexString(): string {
    let hex: string = '';
    let offset = 0;

    writeObject(hex, this.FileHeader, 0x0000);
    offset = 0x23F0;
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
    for (let i = 0; i < 2; i++) {
      const t = this.Briefings[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    writeString(hex, this.EditorNotes, offset);
    offset = offset;
    for (let i = 0; i < 128; i++) {
      const t = this.BriefingStringNotes[i];
      writeString(hex, t, offset);
      offset += t.length + 1;
    }
    offset = offset;
    for (let i = 0; i < 64; i++) {
      const t = this.MessageNotes[i];
      writeString(hex, t, offset);
      offset += t.length + 1;
    }
    offset = offset;
    for (let i = 0; i < 30; i++) {
      const t = this.EomNotes[i];
      writeString(hex, t, offset);
      offset += t.length + 1;
    }
    offset = offset;
    for (let i = 0; i < 480; i++) {
      const t = this.Unknown[i];
      writeByte(hex, t, offset);
      offset += 1;
    }
    offset = offset;
    for (let i = 0; i < 3; i++) {
      const t = this.DescriptionNotes[i];
      writeString(hex, t, offset);
      offset += t.length + 1;
    }
    offset = offset;
    for (let i = 0; i < this.FGGoalStringCount(); i++) {
      const t = this.FGGoalStrings[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    offset = offset;
    for (let i = 0; i < 360; i++) {
      const t = this.GlobalGoalStrings[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    offset = offset;
    for (let i = 0; i < 3072; i++) {
      const t = this.OrderStrings[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    offset = offset;
    for (let i = 0; i < 3; i++) {
      const t = this.Descriptions[i];
      writeString(hex, t, offset);
      offset += t.length + 1;
    }

    return hex;
  }
  
  protected abstract FGGoalStringCount();
  public getLength(): number {
    return this.MissionLength;
  }
}