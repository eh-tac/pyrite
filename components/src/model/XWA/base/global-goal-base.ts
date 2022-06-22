import { Byteable } from "../../../byteable";
import { GoalGlobal } from "../goal-global";
import { IMission, PyriteBase } from "../../../pyrite-base";
import { getShort, writeObject, writeShort } from "../../../hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class GlobalGoalBase extends PyriteBase implements Byteable {
  public readonly GLOBALGOALLENGTH: number = 368;
  public Reserved: number; //(3)
  public Goal: GoalGlobal[];
  
  constructor(hex: ArrayBuffer, tie?: IMission) {
    super(hex, tie);
    this.beforeConstruct();
    let offset = 0;

    this.Reserved = getShort(hex, 0x00);
    this.Goal = [];
    offset = 0x02;
    for (let i = 0; i < 3; i++) {
      const t = new GoalGlobal(hex.slice(offset), this.TIE);
      this.Goal.push(t);
      offset += t.getLength();
    }
    
  }
  
  public toJSON(): object {
    return {
      Reserved: this.Reserved,
      Goal: this.Goal
    };
  }
  
  public toHexString(): string {
    let hex: string = '';
    let offset = 0;

    writeShort(hex, this.Reserved, 0x00);
    offset = 0x02;
    for (let i = 0; i < 3; i++) {
      const t = this.Goal[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }

    return hex;
  }
  
  
  public getLength(): number {
    return this.GLOBALGOALLENGTH;
  }
}