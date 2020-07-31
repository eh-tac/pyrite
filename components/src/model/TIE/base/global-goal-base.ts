import { Byteable } from "../../../byteable";
import { IMission, PyriteBase } from "../../../pyrite-base";
import { Trigger } from "../trigger";
import { getBool, writeBool, writeObject } from "../../../hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class GlobalGoalBase extends PyriteBase implements Byteable {
  public readonly GLOBALGOALLENGTH: number = 28;
  public Triggers: Trigger[];
  public Trigger1OrTrigger2: boolean;
  
  constructor(hex: ArrayBuffer, tie?: IMission) {
    super(hex, tie);
    this.beforeConstruct();
    let offset = 0;

    this.Triggers = [];
    offset = 0x00;
    for (let i = 0; i < 2; i++) {
      const t = new Trigger(hex.slice(offset), this.TIE);
      this.Triggers.push(t);
      offset += t.getLength();
    }
    this.Trigger1OrTrigger2 = getBool(hex, 0x19);
    
  }
  
  public toJSON(): object {
    return {
      Triggers: this.Triggers,
      Trigger1OrTrigger2: this.Trigger1OrTrigger2
    };
  }
  
  public toHexString(): string {
    let hex: string = '';
    let offset = 0;

    offset = 0x00;
    for (let i = 0; i < 2; i++) {
      const t = this.Triggers[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    writeBool(hex, this.Trigger1OrTrigger2, 0x19);

    return hex;
  }
  
  
  public getLength(): number {
    return this.GLOBALGOALLENGTH;
  }
}