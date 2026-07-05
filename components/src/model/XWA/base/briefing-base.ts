import { BrfStr } from "../brf-str";
import { Byteable } from "../../../byteable";
import { Event } from "../event";
import { IMission, PyriteBase } from "../../../pyrite-base";
import { Icon } from "../icon";
import { getBool, getShort, writeBool, writeObject, writeShort } from "../../../hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class BriefingBase extends PyriteBase implements Byteable {
  public BriefingLength: number;
  public RunningTime: number;
  public CurrentTime: number; //(was Unknown1)
  public StartLength: number;
  public EventsLength: number;
  public Tile: number;
  public Events: Event[];
  public Icons: Icon[];
  public ViewedByTeam: boolean[];
  public Tags: BrfStr[];
  public Strings: BrfStr[];

  constructor(hex: ArrayBuffer, TIE?: IMission) {
    super(hex, TIE!);
    this.beforeConstruct();
    let offset = 0;

    this.RunningTime = getShort(hex, 0x0000);
    this.CurrentTime = getShort(hex, 0x0002);
    this.StartLength = getShort(hex, 0x0004);
    this.EventsLength = getShort(hex, 0x0006);
    this.Tile = getShort(hex, 0x0008);
    this.Events = [];
    offset = 0x000a;
    for (let i = 0; i < 0; i++) {
      const t = new Event(hex.slice(offset), this.TIE);
      this.Events.push(t);
      offset += t.getLength();
    }
    this.Icons = [];
    offset = 0x320a;
    for (let i = 0; i < 192; i++) {
      const t = new Icon(hex.slice(offset), this.TIE);
      this.Icons.push(t);
      offset += t.getLength();
    }
    this.ViewedByTeam = [];
    offset = 0x440a;
    for (let i = 0; i < 10; i++) {
      const t = getBool(hex, offset);
      this.ViewedByTeam.push(t);
      offset += 1;
    }
    this.Tags = [];
    offset = 0x4414;
    for (let i = 0; i < 128; i++) {
      const t = new BrfStr(hex.slice(offset), this.TIE);
      this.Tags.push(t);
      offset += t.getLength();
    }
    this.Strings = [];
    offset = offset;
    for (let i = 0; i < 128; i++) {
      const t = new BrfStr(hex.slice(offset), this.TIE);
      this.Strings.push(t);
      offset += t.getLength();
    }
    this.BriefingLength = offset;
  }

  public toJSON(): Record<string, unknown> | string {
    return {
      RunningTime: this.RunningTime,
      CurrentTime: this.CurrentTime,
      StartLength: this.StartLength,
      EventsLength: this.EventsLength,
      Tile: this.Tile,
      Events: this.Events.map((t) => t.toJSON()),
      Icons: this.Icons.map((t) => t.toJSON()),
      ViewedByTeam: this.ViewedByTeam,
      Tags: this.Tags.map((t) => t.toJSON()),
      Strings: this.Strings.map((t) => t.toJSON()),
    };
  }

  public toHexBuffer(): ArrayBuffer {
    const hex: ArrayBuffer = new ArrayBuffer(this.getLength());
    let offset = 0;

    writeShort(hex, this.RunningTime, 0x0000);
    writeShort(hex, this.CurrentTime, 0x0002);
    writeShort(hex, this.StartLength, 0x0004);
    writeShort(hex, this.EventsLength, 0x0006);
    writeShort(hex, this.Tile, 0x0008);
    offset = 0x000a;
    for (let i = 0; i < this.Events.length; i++) {
      const t = this.Events[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    offset = 0x320a;
    for (let i = 0; i < this.Icons.length; i++) {
      const t = this.Icons[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    offset = 0x440a;
    for (let i = 0; i < this.ViewedByTeam.length; i++) {
      const t = this.ViewedByTeam[i];
      writeBool(hex, t, offset);
      offset += 1;
    }
    offset = 0x4414;
    for (let i = 0; i < this.Tags.length; i++) {
      const t = this.Tags[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    for (let i = 0; i < this.Strings.length; i++) {
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
