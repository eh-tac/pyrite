import { Byteable } from "../../../byteable";
import { Constants } from "../constants";
import { IMission, PyriteBase } from "../../../pyrite-base";
import { getShort, writeShort } from "../../../hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class EventBase extends PyriteBase implements Byteable {
  public EventLength: number;
  public Time: number;
  public Type: number;
  public Variables: number;
  
  constructor(hex: ArrayBuffer, tie?: IMission) {
    super(hex, tie);
    this.beforeConstruct();
    let offset = 0;

    this.Time = getShort(hex, 0x0);
    this.Type = getShort(hex, 0x2);
    this.Variables = getShort(hex, 0x4);
    this.EventLength = offset;
  }
  
  public toJSON(): object {
    return {
      Time: this.Time,
      Type: this.TypeLabel,
      Variables: this.Variables
    };
  }
  
  public toHexString(): string {
    let hex: string = '';
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