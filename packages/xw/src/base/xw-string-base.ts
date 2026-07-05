import { Byteable, IMission, PyriteBase } from '@pyrite/core';
import { getByte, getChar, getShort, writeByte, writeChar, writeShort } from '@pyrite/core';
export abstract class XWStringBase extends PyriteBase implements Byteable {
  public XWStringLength: number;
  public Length: number;
  public Content: string[];
  public Highlight: number[];

  constructor(hex: ArrayBuffer, TIE?: IMission) {
    super(hex, TIE!);
    this.beforeConstruct();
    let offset = 0;

    this.Length = getShort(hex, 0x0);
    this.Content = [];
    offset = 0x2;
    for (let i = 0; i < this.Length; i++) {
      const t = getChar(hex, offset, 1);
      this.Content.push(t);
      offset += 1;
    }
    this.Highlight = [];
    for (let i = 0; i < this.Length; i++) {
      const t = getByte(hex, offset);
      this.Highlight.push(t);
      offset += 1;
    }
    this.XWStringLength = offset;
  }

  public toJSON(): Record<string, unknown> | string {
    return {
      Length: this.Length,
      Content: this.Content,
      Highlight: this.Highlight
    };
  }

  public toHexBuffer(): ArrayBuffer {
    const hex: ArrayBuffer = new ArrayBuffer(this.getLength());
    let offset = 0;

    writeShort(hex, this.Length, 0x0);
    offset = 0x2;
    for (let i = 0; i < this.Content.length; i++) {
      const t = this.Content[i];
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
    return this.XWStringLength;
  }
}
