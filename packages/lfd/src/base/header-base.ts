import { Byteable, IMission, PyriteBase } from '@pyrite/core';
import { getChar, getInt, writeChar, writeInt } from '@pyrite/core';
export abstract class HeaderBase extends PyriteBase implements Byteable {
  public readonly HEADERLENGTH: number = 16;
  public Type: string;
  public Name: string;
  public Length: number; //little endian

  constructor(
    public hex: ArrayBuffer,
    public TIE?: IMission
  ) {
    super(hex, TIE!);
    this.beforeConstruct();

    this.Type = getChar(hex, 0x00, 4);
    this.Name = getChar(hex, 0x04, 8);
    this.Length = getInt(hex, 0x0c);
  }

  public toJSON(): Record<string, unknown> | string {
    return {
      Type: this.Type,
      Name: this.Name,
      Length: this.Length
    };
  }

  public toHexBuffer(): ArrayBuffer {
    const hex: ArrayBuffer = new ArrayBuffer(this.getLength());

    writeChar(hex, this.Type, 0x00, 4);
    writeChar(hex, this.Name, 0x04, 8);
    writeInt(hex, this.Length, 0x0c);

    return hex;
  }

  public getLength(): number {
    return this.HEADERLENGTH;
  }
}
