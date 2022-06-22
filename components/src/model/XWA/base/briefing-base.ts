import { Byteable } from "../../../byteable";
import { Event } from "../event";
import { IMission, PyriteBase } from "../../../pyrite-base";
import { LengthString } from "../length-string";
import { Tag } from "../tag";
import { getBool, getInt, getShort, writeBool, writeInt, writeObject, writeShort } from "../../../hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class BriefingBase extends PyriteBase implements Byteable {
  public BriefingLength: number;
  public RunningTime: number;
  public Unknown1: number;
  public StartLength: number;
  public EventsLength: number;
  public Events: Event;
  public ShowToTeams: boolean[];
  public Tags: Tag[];
  public Strings: LengthString[];
  
  constructor(hex: ArrayBuffer, tie?: IMission) {
    super(hex, tie);
    this.beforeConstruct();
    let offset = 0;

    this.RunningTime = getShort(hex, 0x0000);
    this.Unknown1 = getShort(hex, 0x0002);
    this.StartLength = getShort(hex, 0x0004);
    this.EventsLength = getInt(hex, 0x0006);
    this.Events = new Event(hex.slice(0x000A), this.TIE);
    offset = 0x000A + this.Events.getLength();
    this.ShowToTeams = [];
    offset = 0x440A;
    for (let i = 0; i < 10; i++) {
      const t = getBool(hex, offset);
      this.ShowToTeams.push(t);
      offset += 1;
    }
    this.Tags = [];
    offset = 0x4414;
    for (let i = 0; i < 128; i++) {
      const t = new Tag(hex.slice(offset), this.TIE);
      this.Tags.push(t);
      offset += t.getLength();
    }
    this.Strings = [];
    offset = offset;
    for (let i = 0; i < 128; i++) {
      const t = new LengthString(hex.slice(offset), this.TIE);
      this.Strings.push(t);
      offset += t.getLength();
    }
    this.BriefingLength = offset;
  }
  
  public toJSON(): object {
    return {
      RunningTime: this.RunningTime,
      Unknown1: this.Unknown1,
      StartLength: this.StartLength,
      EventsLength: this.EventsLength,
      Events: this.Events,
      ShowToTeams: this.ShowToTeams,
      Tags: this.Tags,
      Strings: this.Strings
    };
  }
  
  public toHexString(): string {
    let hex: string = '';
    let offset = 0;

    writeShort(hex, this.RunningTime, 0x0000);
    writeShort(hex, this.Unknown1, 0x0002);
    writeShort(hex, this.StartLength, 0x0004);
    writeInt(hex, this.EventsLength, 0x0006);
    writeObject(hex, this.Events, 0x000A);
    offset = 0x440A;
    for (let i = 0; i < 10; i++) {
      const t = this.ShowToTeams[i];
      writeBool(hex, t, offset);
      offset += 1;
    }
    offset = 0x4414;
    for (let i = 0; i < 128; i++) {
      const t = this.Tags[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    offset = offset;
    for (let i = 0; i < 128; i++) {
      const t = this.Strings[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }

    return hex;
  }
  
  
  public getLength(): number {
    return this.BriefingLength;
  }
}