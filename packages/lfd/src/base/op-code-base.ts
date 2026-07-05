import { Byteable, IMission, PyriteBase } from '@pyrite/core';
import { getByte, writeByte } from '@pyrite/core';
export abstract class OpCodeBase extends PyriteBase implements Byteable {
  public OpCodeLength: number;
  public Value: number;
  public ColorIndex: number[];

  constructor(
    public hex: ArrayBuffer,
    public TIE?: IMission
  ) {
    super(hex, TIE!);
    this.beforeConstruct();
    let offset = 0;

    this.Value = getByte(hex, 0x00);
    this.ColorIndex = [];
    offset = 0x01;
    for (let i = 0; i < this.ColorCount(); i++) {
      const t = getByte(hex, offset);
      this.ColorIndex.push(t);
      offset += 1;
    }
    this.OpCodeLength = offset;
  }

  public toJSON(): Record<string, unknown> | string {
    return {
      Value: this.Value,
      ColorIndex: this.ColorIndex
    };
  }

  public toHexBuffer(): ArrayBuffer {
    const hex: ArrayBuffer = new ArrayBuffer(this.getLength());
    let offset = 0;

    writeByte(hex, this.Value, 0x00);
    offset = 0x01;
    for (let i = 0; i < this.ColorIndex.length; i++) {
      const t = this.ColorIndex[i];
      writeByte(hex, t, offset);
      offset += 1;
    }

    return hex;
  }

  protected abstract ColorCount(): number;
  public getLength(): number {
    return this.OpCodeLength;
  }
}
