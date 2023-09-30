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
  public Events[EventsLength]: number;
  
  constructor(hex: ArrayBuffer, tie?: IMission) {
    super(hex, tie);
    this.beforeConstruct();
    let offset = 0;

    this.Duration = getShort(hex, 0x00);
    this.EventsLength = getShort(hex, 0x02);
    this.CoordinateSet = getShort(hex, 0x04);
    this.PageType = getShort(hex, 0x06);
    this.Events[EventsLength] = getShort(hex, 0x08);
    this.PageLength = offset;
  }
  
  public toJSON(): object {
    return {
      Duration: this.Duration,
      EventsLength: this.EventsLength,
      CoordinateSet: this.CoordinateSet,
      PageType: this.PageType,
      Events[EventsLength]: this.Events[EventsLength]
    };
  }
  
  public toHexString(): string {
    let hex: string = '';
    let offset = 0;

    writeShort(hex, this.Duration, 0x00);
    writeShort(hex, this.EventsLength, 0x02);
    writeShort(hex, this.CoordinateSet, 0x04);
    writeShort(hex, this.PageType, 0x06);
    writeShort(hex, this.Events[EventsLength], 0x08);

    return hex;
  }
  
  
  public getLength(): number {
    return this.PageLength;
  }
}