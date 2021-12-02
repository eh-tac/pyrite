import { Byteable } from "../../../byteable";
import { IMission, PyriteBase } from "../../../pyrite-base";
import { Trigger } from "../trigger";
import { getBool, writeBool, writeObject } from "../../../hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class SkipBase extends PyriteBase implements Byteable {
  public readonly SKIPLENGTH: number = 16;
  public Trigger1: Trigger;
  public Trigger2: Trigger;
  public Trigger1OrTrigger2: boolean;
  
  constructor(hex: ArrayBuffer, tie?: IMission) {
    super(hex, tie);
    this.beforeConstruct();
    let offset = 0;

    this.Trigger1 = new Trigger(hex.slice(0x0), this.TIE);
    this.Trigger2 = new Trigger(hex.slice(0x6), this.TIE);
    this.Trigger1OrTrigger2 = getBool(hex, 0xE);
    
  }
  
  public toJSON(): object {
    return {
      Trigger1: this.Trigger1,
      Trigger2: this.Trigger2,
      Trigger1OrTrigger2: this.Trigger1OrTrigger2
    };
  }
  
  public toHexString(): string {
    let hex: string = '';
    let offset = 0;

    writeObject(hex, this.Trigger1, 0x0);
    writeObject(hex, this.Trigger2, 0x6);
    writeBool(hex, this.Trigger1OrTrigger2, 0xE);

    return hex;
  }
  
  
  public getLength(): number {
    return this.SKIPLENGTH;
  }
}