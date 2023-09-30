import { Byteable } from "../../../byteable";
import { Highlight } from "../highlight";
import { IMission, PyriteBase } from "../../../pyrite-base";
import { getChar, getShort, writeChar, writeObject, writeShort } from "../../../hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class StringBase extends PyriteBase implements Byteable {
  public StringLength: number;
  public Length: number;
  public String: string[];
  public Unnamed: Highlight;
  
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
    this.Unnamed = new Highlight(hex.slice(BYTE[Length]), this.TIE);
    offset = BYTE[Length] + this.Unnamed.getLength();
    this.StringLength = offset;
  }
  
  public toJSON(): object {
    return {
      Length: this.Length,
      String: this.String,
      Unnamed: this.Unnamed
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
    writeObject(hex, this.Unnamed, BYTE[Length]);

    return hex;
  }
  
  
  public getLength(): number {
    return this.StringLength;
  }
}