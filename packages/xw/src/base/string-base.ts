import type { Byteable, IMission} from '@pyrite/core';
import { PyriteBase } from '@pyrite/core';
import { getByte, getChar, getShort, writeByte, writeChar, writeShort } from '@pyrite/core';
export abstract class StringBase extends PyriteBase implements Byteable {
  public StringLength: number;
  public Length: number;
  public String: string[];
  public Highlight: number[];

  constructor(hex: ArrayBuffer, TIE?: IMission) {
    super(hex, TIE!);
    this.beforeConstruct();
    let offset = 0;

    this.Length = getShort(hex, 0x0);
    this.String = [];
    offset = 0x2;
    for (let i = 0; i < this.Length; i++) {
      const t = getChar(hex, offset, 1);
      this.String.push(t);
      offset += 1;
    }
    this.Highlight = [];
    for (let i = 0; i < this.Length; i++) {
      const t = getByte(hex, offset);
      this.Highlight.push(t);
      offset += 1;
    }
    this.StringLength = offset;
  }

  public toJSON(): Record<string, unknown> | string {
    return {
      Length: this.Length,
      String: this.String,
      Highlight: this.Highlight
    };
  }

  public toHexBuffer(): ArrayBuffer {
    const hex: ArrayBuffer = new ArrayBuffer(this.getLength());
    let offset = 0;

    writeShort(hex, this.Length, 0x0);
    offset = 0x2;
    for (let i = 0; i < this.String.length; i++) {
      const t = this.String[i];
      writeChar(hex, t, offset, 1);
      offset += 1;
    }
    for (let i = 0; i < this.Highlight.length; i++) {
      const t = this.Highlight[i];
      writeByte(hex, t, offset);
      offset += 1;
    }

    return hex;
  }

  public getLength(): number {
    return this.StringLength;
  }
}
