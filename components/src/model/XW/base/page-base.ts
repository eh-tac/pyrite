import { Byteable } from "../../../byteable";
import { IMission, PyriteBase } from "../../../pyrite-base";
import { getShort, writeShort } from "../../../hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class PageBase extends PyriteBase implements Byteable {
  public PageLength: number;
  public Duration: number; //(ticks)
  public EventsLength: number;
  public CoordinateSet: number;
  public PageType: number;
  public Events: number[];
  
  constructor(hex: ArrayBuffer, tie?: IMission) {
    super(hex, tie);
    this.beforeConstruct();
    let offset = 0;

    this.Duration = getShort(hex, 0x00);
    this.EventsLength = getShort(hex, 0x02);
    this.CoordinateSet = getShort(hex, 0x04);
    this.PageType = getShort(hex, 0x06);
    this.Events = [];
    offset = 0x08;
    for (let i = 0; i < this.EventsLength; i++) {
      const t = getShort(hex, offset);
      this.Events.push(t);
      offset += 2;
    }
    this.PageLength = offset;
  }
  
  public toJSON(): object {
    return {
      Duration: this.Duration,
      EventsLength: this.EventsLength,
      CoordinateSet: this.CoordinateSet,
      PageType: this.PageType,
      Events: this.Events
    };
  }
  
  public toHexString(): string {
    let hex: string = '';
    let offset = 0;

    writeShort(hex, this.Duration, 0x00);
    writeShort(hex, this.EventsLength, 0x02);
    writeShort(hex, this.CoordinateSet, 0x04);
    writeShort(hex, this.PageType, 0x06);
    offset = 0x08;
    for (let i = 0; i < this.EventsLength; i++) {
      const t = this.Events[i];
      writeShort(hex, t, offset);
      offset += 2;
    }

    return hex;
  }
  
  
  public getLength(): number {
    return this.PageLength;
  }
}