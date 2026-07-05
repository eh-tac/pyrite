import { Byteable, IMission, PyriteBase } from '@pyrite/core';
import { getInt, writeInt } from '@pyrite/core';
export abstract class PLTCategoryTypeRecordBase extends PyriteBase implements Byteable {
  public readonly PLTCATEGORYTYPERECORDLENGTH: number = 12;
  public exercise: number;
  public melee: number;
  public combat: number;

  constructor(hex: ArrayBuffer, TIE?: IMission) {
    super(hex, TIE!);
    this.beforeConstruct();

    this.exercise = getInt(hex, 0x0000);
    this.melee = getInt(hex, 0x0004);
    this.combat = getInt(hex, 0x0008);
  }

  public toJSON(): Record<string, unknown> | string {
    return {
      exercise: this.exercise,
      melee: this.melee,
      combat: this.combat
    };
  }

  public toHexBuffer(): ArrayBuffer {
    const hex: ArrayBuffer = new ArrayBuffer(this.getLength());

    writeInt(hex, this.exercise, 0x0000);
    writeInt(hex, this.melee, 0x0004);
    writeInt(hex, this.combat, 0x0008);

    return hex;
  }

  public getLength(): number {
    return this.PLTCATEGORYTYPERECORDLENGTH;
  }
}
