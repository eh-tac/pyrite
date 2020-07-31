import { Byteable } from "../../../byteable";
import { IMission, PyriteBase } from "../../../pyrite-base";
import { OpCode } from "../op-code";
import { getByte, getShort, writeByte, writeObject, writeShort } from "../../../hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class RowBase extends PyriteBase implements Byteable {
  public RowLength: number;
  public Length: number;
  public Left: number;
  public Top: number;
  public ColorIndexes: number[];
  public Operations: OpCode[];
  
  constructor(hex: ArrayBuffer, tie?: IMission) {
    super(hex, tie);
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
  
  public toJSON(): object {
    return {
      Length: this.Length,
      Left: this.Left,
      Top: this.Top,
      ColorIndexes: this.ColorIndexes,
      Operations: this.Operations
    };
  }
  
  public toHexString(): string {
    let hex: string = '';
    let offset = 0;

    writeShort(hex, this.Length, 0x00);
    writeShort(hex, this.Left, 0x02);
    writeShort(hex, this.Top, 0x04);
    offset = 0x06;
    for (let i = 0; i < this.ColorCount(); i++) {
      const t = this.ColorIndexes[i];
      writeByte(hex, t, offset);
      offset += 1;
    }
    offset = 0x06;
    for (let i = 0; i < this.OpCount(); i++) {
      const t = this.Operations[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }

    return hex;
  }
  
  protected abstract ColorCount();
protected abstract OpCount();
  public getLength(): number {
    return this.RowLength;
  }
}