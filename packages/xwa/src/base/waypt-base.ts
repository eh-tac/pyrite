import type { Byteable, IMission} from '@pyrite/core';
import { PyriteBase } from '@pyrite/core';
import { getBool, getShort, writeBool, writeShort } from '@pyrite/core';
export abstract class WayptBase extends PyriteBase implements Byteable {
  public readonly WAYPTLENGTH: number = 8;
  public X: number;
  public Y: number;
  public Z: number;
  public Enabled: boolean;

  constructor(hex: ArrayBuffer, TIE?: IMission) {
    super(hex, TIE!);
    this.beforeConstruct();

    this.X = getShort(hex, 0x0);
    this.Y = getShort(hex, 0x2);
    this.Z = getShort(hex, 0x4);
    this.Enabled = getBool(hex, 0x6);
  }

  public toJSON(): Record<string, unknown> | string {
    return {
      X: this.X,
      Y: this.Y,
      Z: this.Z,
      Enabled: this.Enabled
    };
  }

  public toHexBuffer(): ArrayBuffer {
    const hex: ArrayBuffer = new ArrayBuffer(this.getLength());

    writeShort(hex, this.X, 0x0);
    writeShort(hex, this.Y, 0x2);
    writeShort(hex, this.Z, 0x4);
    writeBool(hex, this.Enabled, 0x6);

    return hex;
  }

  public getLength(): number {
    return this.WAYPTLENGTH;
  }
}
