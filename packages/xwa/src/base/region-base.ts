import type { Byteable, IMission} from '@pyrite/core';
import { PyriteBase } from '@pyrite/core';
import { getInt, getString, writeInt, writeString } from '@pyrite/core';
export abstract class RegionBase extends PyriteBase implements Byteable {
  public readonly REGIONLENGTH: number = 132;
  public Name: string;
  public ID: number;

  constructor(hex: ArrayBuffer, TIE?: IMission) {
    super(hex, TIE!);
    this.beforeConstruct();

    this.Name = getString(hex, 0x00, 64);
    this.ID = getInt(hex, 0x40);
  }

  public toJSON(): Record<string, unknown> | string {
    return {
      Name: this.Name,
      ID: this.ID
    };
  }

  public toHexBuffer(): ArrayBuffer {
    const hex: ArrayBuffer = new ArrayBuffer(this.getLength());

    writeString(hex, this.Name, 0x00, 64);
    writeInt(hex, this.ID, 0x40);

    return hex;
  }

  public getLength(): number {
    return this.REGIONLENGTH;
  }
}
