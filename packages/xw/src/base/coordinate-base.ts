import { Byteable, IMission, PyriteBase } from '@pyrite/core';
import { getShort, writeShort } from '@pyrite/core';
export abstract class CoordinateBase extends PyriteBase implements Byteable {
  public readonly COORDINATELENGTH: number = 6;
  public X: number;
  public Y: number;
  public Z: number;

  constructor(
    public hex: ArrayBuffer,
    public TIE?: IMission
  ) {
    super(hex, TIE!);
    this.beforeConstruct();

    this.X = getShort(hex, 0x00);
    this.Y = getShort(hex, 0x02);
    this.Z = getShort(hex, 0x04);
  }

  public toJSON(): Record<string, unknown> | string {
    return {
      X: this.X,
      Y: this.Y,
      Z: this.Z
    };
  }

  public toHexBuffer(): ArrayBuffer {
    const hex: ArrayBuffer = new ArrayBuffer(this.getLength());

    writeShort(hex, this.X, 0x00);
    writeShort(hex, this.Y, 0x02);
    writeShort(hex, this.Z, 0x04);

    return hex;
  }

  public getLength(): number {
    return this.COORDINATELENGTH;
  }
}
