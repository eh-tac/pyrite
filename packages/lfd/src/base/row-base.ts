import type { Byteable, IMission} from '@pyrite/core';
import { PyriteBase } from '@pyrite/core';
import { getByte, getShort, writeByte, writeObject, writeShort } from '@pyrite/core';

import { OpCode } from '../op-code';
export abstract class RowBase extends PyriteBase implements Byteable {
  public RowLength: number;
  public Length: number;
  public Left: number;
  public Top: number;
  public ColorIndexes: number[];
  public Operations: OpCode[];

  constructor(hex: ArrayBuffer, TIE?: IMission) {
    super(hex, TIE!);
    this.beforeConstruct();
    let offset = 0;

    this.Length = getShort(hex, 0x00);
    this.Left = getShort(hex, 0x02);
    this.Top = getShort(hex, 0x04);
    this.ColorIndexes = [];
    offset = 0x06;
    for (let i = 0; i < this.ColorCount(); i++) {
      const t = getByte(hex, offset);
      this.ColorIndexes.push(t);
      offset += 1;
    }
    this.Operations = [];
    offset = 0x06;
    for (let i = 0; i < this.OpCount(); i++) {
      const t = new OpCode(hex.slice(offset), this.TIE);
      this.Operations.push(t);
      offset += t.getLength();
    }
    this.RowLength = offset;
  }

  public toJSON(): Record<string, unknown> | string {
    return {
      Length: this.Length,
      Left: this.Left,
      Top: this.Top,
      ColorIndexes: this.ColorIndexes,
      Operations: this.Operations.map((t) => t.toJSON())
    };
  }

  public toHexBuffer(): ArrayBuffer {
    const hex: ArrayBuffer = new ArrayBuffer(this.getLength());
    let offset = 0;

    writeShort(hex, this.Length, 0x00);
    writeShort(hex, this.Left, 0x02);
    writeShort(hex, this.Top, 0x04);
    offset = 0x06;
    for (let i = 0; i < this.ColorIndexes.length; i++) {
      const t = this.ColorIndexes[i];
      writeByte(hex, t, offset);
      offset += 1;
    }
    offset = 0x06;
    for (let i = 0; i < this.Operations.length; i++) {
      const t = this.Operations[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }

    return hex;
  }

  protected abstract ColorCount(): number;
  protected abstract OpCount(): number;
  public getLength(): number {
    return this.RowLength;
  }
}
