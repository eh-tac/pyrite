import type { Byteable, IMission} from '@pyrite/core';
import { PyriteBase } from '@pyrite/core';
import { getInt, writeInt } from '@pyrite/core';
export abstract class PLTAIRankCountRecordBase extends PyriteBase implements Byteable {
  public readonly PLTAIRANKCOUNTRECORDLENGTH: number = 72;
  public exercise: number[];
  public melee: number[];
  public combat: number[];

  constructor(hex: ArrayBuffer, TIE?: IMission) {
    super(hex, TIE!);
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

  public toJSON(): Record<string, unknown> | string {
    return {
      exercise: this.exercise,
      melee: this.melee,
      combat: this.combat
    };
  }

  public toHexBuffer(): ArrayBuffer {
    const hex: ArrayBuffer = new ArrayBuffer(this.getLength());
    let offset = 0;

    offset = 0x0000;
    for (let i = 0; i < this.exercise.length; i++) {
      const t = this.exercise[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x0018;
    for (let i = 0; i < this.melee.length; i++) {
      const t = this.melee[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x0030;
    for (let i = 0; i < this.combat.length; i++) {
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
