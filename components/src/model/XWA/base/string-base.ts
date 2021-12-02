import { Byteable } from "../../../byteable";
import { IMission, PyriteBase } from "../../../pyrite-base";
import { getChar, getShort, writeChar, writeShort } from "../../../hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class StringBase extends PyriteBase implements Byteable {
  public StringLength: number;
  public Length: number;
  public Unnamed: string[];
  
  constructor(hex: ArrayBuffer, tie?: IMission) {
    super(hex, tie);
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
    this.StringLength = offset;
  }
  
  public toJSON(): object {
    return {
      Length: this.Length,
      Unnamed: this.Unnamed
    };
  }
  
  public toHexString(): string {
    let hex: string = '';
    let offset = 0;

    writeShort(hex, this.Length, 0x0);
    offset = 0x2;
    for (let i = 0; i < this.Length; i++) {
      const t = this.Unnamed[i];
      writeChar(hex, t, offset);
      offset += 1;
    }

    return hex;
  }
  
  
  public getLength(): number {
    return this.StringLength;
  }
}