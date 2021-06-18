import { Byteable } from "../../../byteable";
import { Event } from "../event";
import { IMission, PyriteBase } from "../../../pyrite-base";
import { Tag } from "../tag";
import { XvTString } from "../xv-t-string";
import { getInt, getShort, writeInt, writeObject, writeShort } from "../../../hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class BriefingBase extends PyriteBase implements Byteable {
  public BriefingLength: number;
  public RunningTime: number;
  public Unknown1: number;
  public StartEvents: number;
  public EventsLength: number;
  public Events: Event[];
  public Tags: Tag[];
  public Strings: XvTString[];
  
  constructor(hex: ArrayBuffer, tie?: IMission) {
    super(hex, tie);
    this.beforeConstruct();
    let offset = 0;

    this.RunningTime = getShort(hex, 0x000);
    this.Unknown1 = getShort(hex, 0x002);
    this.StartEvents = getShort(hex, 0x004);
    this.EventsLength = getInt(hex, 0x006);
    this.Events = [];
    offset = 0x00A;
    for (let i = 0; i < this.EventsLength; i++) {
      const t = new Event(hex.slice(offset), this.TIE);
      this.Events.push(t);
      offset += t.getLength();
    }
    this.Tags = [];
    offset = 0x334;
    for (let i = 0; i < 32; i++) {
      const t = new Tag(hex.slice(offset), this.TIE);
      this.Tags.push(t);
      offset += t.getLength();
    }
    this.Strings = [];
    offset = offset;
    for (let i = 0; i < 32; i++) {
      const t = new XvTString(hex.slice(offset), this.TIE);
      this.Strings.push(t);
      offset += t.getLength();
    }
    this.BriefingLength = offset;
  }
  
  public toJSON(): object {
    return {
      RunningTime: this.RunningTime,
      Unknown1: this.Unknown1,
      StartEvents: this.StartEvents,
      EventsLength: this.EventsLength,
      Events: this.Events,
      Tags: this.Tags,
      Strings: this.Strings
    };
  }
  
  public toHexString(): string {
    let hex: string = '';
    let offset = 0;

    writeShort(hex, this.RunningTime, 0x000);
    writeShort(hex, this.Unknown1, 0x002);
    writeShort(hex, this.StartEvents, 0x004);
    writeInt(hex, this.EventsLength, 0x006);
    offset = 0x00A;
    for (let i = 0; i < this.EventsLength; i++) {
      const t = this.Events[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    offset = 0x334;
    for (let i = 0; i < 32; i++) {
      const t = this.Tags[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    offset = offset;
    for (let i = 0; i < 32; i++) {
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