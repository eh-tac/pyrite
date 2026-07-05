import { Byteable, IMission, PyriteBase } from '@pyrite/core';
import { Header } from '../header';
import { Row } from '../row';
import { getShort, writeObject, writeShort } from '@pyrite/core';
export abstract class DeltBase extends PyriteBase implements Byteable {
  public DeltLength: number;
  public Header: Header;
  public Left: number;
  public Top: number;
  public Right: number;
  public Bottom: number;
  public Rows: Row[];
  public readonly Reserved: number = 0;

  constructor(hex: ArrayBuffer, TIE?: IMission) {
    super(hex, TIE!);
    this.beforeConstruct();
    let offset = 0;

    this.Header = new Header(hex.slice(0x00), this.TIE);
    this.Left = getShort(hex, 0x10);
    this.Top = getShort(hex, 0x12);
    this.Right = getShort(hex, 0x14);
    this.Bottom = getShort(hex, 0x16);
    this.Rows = [];
    offset = 0x18;
    for (let i = 0; i < this.RowCount(); i++) {
      const t = new Row(hex.slice(offset), this.TIE);
      this.Rows.push(t);
      offset += t.getLength();
    }
    // static prop Reserved
    offset += 2;
    this.DeltLength = offset;
  }

  public toJSON(): Record<string, unknown> | string {
    return {
      Header: this.Header.toJSON(),
      Left: this.Left,
      Top: this.Top,
      Right: this.Right,
      Bottom: this.Bottom,
      Rows: this.Rows.map((t) => t.toJSON())
    };
  }

  public toHexBuffer(): ArrayBuffer {
    const hex: ArrayBuffer = new ArrayBuffer(this.getLength());
    let offset = 0;

    writeObject(hex, this.Header, 0x00);
    writeShort(hex, this.Left, 0x10);
    writeShort(hex, this.Top, 0x12);
    writeShort(hex, this.Right, 0x14);
    writeShort(hex, this.Bottom, 0x16);
    offset = 0x18;
    for (let i = 0; i < this.Rows.length; i++) {
      const t = this.Rows[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    writeShort(hex, this.Reserved, offset);
    offset += 2;

    return hex;
  }

  protected abstract RowCount(): number;
  public getLength(): number {
    return this.DeltLength;
  }
}
