import { Byteable, IMission, PyriteBase } from '@pyrite/core';
import { getShort, getString, writeByte, writeShort, writeString } from '@pyrite/core';
export abstract class LStringBase extends PyriteBase implements Byteable {
  public LStringLength: number;
  public Length: number;
  public Substrings: string[];
  public readonly Reserved: number = 0;

  constructor(
    public hex: ArrayBuffer,
    public TIE?: IMission
  ) {
    super(hex, TIE!);
    this.beforeConstruct();
    let offset = 0;

    this.Length = getShort(hex, 0x00);
    this.Substrings = [];
    offset = 0x02;
    for (let i = 0; i < 0; i++) {
      const t = getString(hex, offset, 0);
      this.Substrings.push(t);
      offset += t.length + 1;
    }
    // static prop Reserved
    offset += 1;
    this.LStringLength = offset;
  }

  public toJSON(): Record<string, unknown> | string {
    return {
      Length: this.Length,
      Substrings: this.Substrings
    };
  }

  public toHexBuffer(): ArrayBuffer {
    const hex: ArrayBuffer = new ArrayBuffer(this.getLength());
    let offset = 0;

    writeShort(hex, this.Length, 0x00);
    offset = 0x02;
    for (let i = 0; i < this.Substrings.length; i++) {
      const t = this.Substrings[i];
      writeString(hex, t, offset, 0);
      offset += t.length + 1;
    }
    writeByte(hex, this.Reserved, offset);
    offset += 1;

    return hex;
  }

  public getLength(): number {
    return this.LStringLength;
  }
}
