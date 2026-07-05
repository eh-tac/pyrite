import { Byteable, IMission, PyriteBase } from '@pyrite/core';
import { getByte, getShort, writeByte, writeShort } from '@pyrite/core';
export abstract class IconBase extends PyriteBase implements Byteable {
  public readonly ICONLENGTH: number = 24;
  public Species: number;
  public IFF: number;
  public X: number;
  public Y: number;
  public Orientation: number;

  constructor(hex: ArrayBuffer, TIE?: IMission) {
    super(hex, TIE!);
    this.beforeConstruct();

    this.Species = getByte(hex, 0x00);
    this.IFF = getByte(hex, 0x01);
    this.X = getShort(hex, 0x02);
    this.Y = getShort(hex, 0x04);
    this.Orientation = getShort(hex, 0x06);
  }

  public toJSON(): Record<string, unknown> | string {
    return {
      Species: this.Species,
      IFF: this.IFF,
      X: this.X,
      Y: this.Y,
      Orientation: this.Orientation
    };
  }

  public toHexBuffer(): ArrayBuffer {
    const hex: ArrayBuffer = new ArrayBuffer(this.getLength());

    writeByte(hex, this.Species, 0x00);
    writeByte(hex, this.IFF, 0x01);
    writeShort(hex, this.X, 0x02);
    writeShort(hex, this.Y, 0x04);
    writeShort(hex, this.Orientation, 0x06);

    return hex;
  }

  public getLength(): number {
    return this.ICONLENGTH;
  }
}
