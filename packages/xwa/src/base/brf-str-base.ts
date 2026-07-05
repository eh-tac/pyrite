import type { Byteable, IMission} from '@pyrite/core';
import { PyriteBase } from '@pyrite/core';
import { getChar, getShort, writeChar, writeShort } from '@pyrite/core';
export abstract class BrfStrBase extends PyriteBase implements Byteable {
  public BrfStrLength: number;
  public Length: number;
  public Text: string[];

  constructor(hex: ArrayBuffer, TIE?: IMission) {
    super(hex, TIE!);
    this.beforeConstruct();
    let offset = 0;

    this.Length = getShort(hex, 0x0);
    this.Text = [];
    offset = 0x2;
    for (let i = 0; i < this.Length; i++) {
      const t = getChar(hex, offset, 1);
      this.Text.push(t);
      offset += 1;
    }
    this.BrfStrLength = offset;
  }

  public toJSON(): Record<string, unknown> | string {
    return {
      Length: this.Length,
      Text: this.Text
    };
  }

  public toHexBuffer(): ArrayBuffer {
    const hex: ArrayBuffer = new ArrayBuffer(this.getLength());
    let offset = 0;

    writeShort(hex, this.Length, 0x0);
    offset = 0x2;
    for (let i = 0; i < this.Text.length; i++) {
      const t = this.Text[i];
      writeChar(hex, t, offset, 1);
      offset += 1;
    }

    return hex;
  }

  public getLength(): number {
    return this.BrfStrLength;
  }
}
