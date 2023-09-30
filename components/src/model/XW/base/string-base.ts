import { Byteable } from "../../../byteable";
import { IMission, PyriteBase } from "../../../pyrite-base";
import { getByte, getChar, getShort, writeByte, writeChar, writeShort } from "../../../hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class StringBase extends PyriteBase implements Byteable {
  public StringLength: number;
  public Length: number;
  public String: string[];
  public Highlight: number[];
  
  constructor(hex: ArrayBuffer, tie?: IMission) {
    super(hex, tie);
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
    offset = offset;
    for (let i = 0; i < this.Length; i++) {
      const t = getByte(hex, offset);
      this.Highlight.push(t);
      offset += 1;
    }
    this.StringLength = offset;
  }
  
  public toJSON(): object {
    return {
      Length: this.Length,
      String: this.String,
      Highlight: this.Highlight
    };
  }
  
  public toHexString(): string {
    let hex: string = '';
    let offset = 0;

    writeShort(hex, this.Length, 0x0);
    offset = 0x2;
    for (let i = 0; i < this.Length; i++) {
      const t = this.String[i];
      writeChar(hex, t, offset);
      offset += 1;
    }
    offset = offset;
    for (let i = 0; i < this.Length; i++) {
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