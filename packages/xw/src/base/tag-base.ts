import { Byteable, IMission, PyriteBase } from '@pyrite/core';
import { getChar, getShort, writeChar, writeShort } from '@pyrite/core';
export abstract class TagBase extends PyriteBase implements Byteable {
  public TagLength: number;
  public Length: number;
  public Unnamed: string[];

  constructor(hex: ArrayBuffer, TIE?: IMission) {
    super(hex, TIE!);
    this.beforeConstruct();
    let offset = 0;

    this.Length = getShort(hex, 0x0);
    this.Unnamed = [];
    offset = 0x2;
    for (let i = 0; i < this.Length; i++) {
      const t = getChar(hex, offset, 1);
      this.Unnamed.push(t);
      offset += 1;
    }
    this.TagLength = offset;
  }

  public toJSON(): Record<string, unknown> | string {
    return {
      Length: this.Length,
      Unnamed: this.Unnamed
    };
  }

  public toHexBuffer(): ArrayBuffer {
    const hex: ArrayBuffer = new ArrayBuffer(this.getLength());
    let offset = 0;

    writeShort(hex, this.Length, 0x0);
    offset = 0x2;
    for (let i = 0; i < this.Unnamed.length; i++) {
      const t = this.Unnamed[i];
      writeChar(hex, t, offset, 1);
      offset += 1;
    }

    return hex;
  }

  public getLength(): number {
    return this.TagLength;
  }
}
