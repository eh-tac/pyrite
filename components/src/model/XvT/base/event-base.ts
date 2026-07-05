import { Byteable } from "../../../byteable";
import { Constants, EventType } from "../constants";
import { IMission, PyriteBase } from "../../../pyrite-base";
import { getShort, writeShort } from "../../../hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class EventBase extends PyriteBase implements Byteable {
  public EventLength: number;
  public Time: number;
  public Type: EventType;
  public Variables: number;

  constructor(hex: ArrayBuffer, TIE?: IMission) {
    super(hex, TIE!);
    this.beforeConstruct();
    let offset = 0;

    this.Time = getShort(hex, 0x0);
    this.Type = getShort(hex, 0x2) as EventType;
    this.Variables = getShort(hex, 0x4);
    this.EventLength = offset;
  }

  public toJSON(): Record<string, unknown> | string {
    return {
      Time: this.Time,
      Type: this.TypeLabel,
      Variables: this.Variables,
    };
  }

  public toHexBuffer(): ArrayBuffer {
    const hex: ArrayBuffer = new ArrayBuffer(this.getLength());
    let offset = 0;

    writeShort(hex, this.Time, 0x0);
    writeShort(hex, this.Type, 0x2);
    writeShort(hex, this.Variables, 0x4);

    return hex;
  }

  public get TypeLabel(): string {
    return Constants.EVENTTYPE[this.Type] || "Unknown";
  }

  public getLength(): number {
    return this.EventLength;
  }
}
