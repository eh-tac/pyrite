import { Byteable } from "../../../byteable";
import { IMission, PyriteBase } from "../../../pyrite-base";
import { getInt, writeInt } from "../../../hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class PLTCategoryTypeRecordBase extends PyriteBase implements Byteable {
  public readonly PLTCATEGORYTYPERECORDLENGTH: number = 12;
  public exercise: number;
  public melee: number;
  public combat: number;
  
  constructor(hex: ArrayBuffer, tie?: IMission) {
    super(hex, tie);
    this.beforeConstruct();
    let offset = 0;

    this.exercise = getInt(hex, 0x0000);
    this.melee = getInt(hex, 0x0004);
    this.combat = getInt(hex, 0x0008);
    
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

    writeInt(hex, this.exercise, 0x0000);
    writeInt(hex, this.melee, 0x0004);
    writeInt(hex, this.combat, 0x0008);

    return hex;
  }
  
  
  public getLength(): number {
    return this.PLTCATEGORYTYPERECORDLENGTH;
  }
}