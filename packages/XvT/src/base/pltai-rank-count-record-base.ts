import { Byteable } from "@pickledyoda/pyrite-core/byteable";
import { IMission, PyriteBase } from "@pickledyoda/pyrite-core/pyrite-base";
import { getInt, writeInt } from "@pickledyoda/pyrite-core/hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class PLTAIRankCountRecordBase extends PyriteBase implements Byteable {
  public readonly PLTAIRANKCOUNTRECORDLENGTH: number = 72;
  public exercise: number[];
  public melee: number[];
  public combat: number[];
  
  constructor(hex: ArrayBuffer, tie?: IMission) {
    super(hex, tie);
    this.beforeConstruct();
    let offset = 0;

    this.exercise = [];
    offset = 0x0000;
    for (let i = 0; i < 6; i++) {
      const t = getInt(hex, offset);
      this.exercise.push(t);
      offset += 4;
    }
    this.melee = [];
    offset = 0x0018;
    for (let i = 0; i < 6; i++) {
      const t = getInt(hex, offset);
      this.melee.push(t);
      offset += 4;
    }
    this.combat = [];
    offset = 0x0030;
    for (let i = 0; i < 6; i++) {
      const t = getInt(hex, offset);
      this.combat.push(t);
      offset += 4;
    }
    
  }
  
  public toJSON(): object {
    return {
      exercise: this.exercise,
      melee: this.melee,
      combat: this.combat
    };
  }
  
  public toHexString(): string {
    let hex: string = '';
    let offset = 0;

    offset = 0x0000;
    for (let i = 0; i < 6; i++) {
      const t = this.exercise[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x0018;
    for (let i = 0; i < 6; i++) {
      const t = this.melee[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x0030;
    for (let i = 0; i < 6; i++) {
      const t = this.combat[i];
      writeInt(hex, t, offset);
      offset += 4;
    }

    return hex;
  }
  
  
  public getLength(): number {
    return this.PLTAIRANKCOUNTRECORDLENGTH;
  }
}