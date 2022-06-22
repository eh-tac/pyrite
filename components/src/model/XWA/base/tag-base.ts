import { Byteable } from "../../../byteable";
import { IMission, PyriteBase } from "../../../pyrite-base";
import { getChar, getShort, writeChar, writeShort } from "../../../hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class TagBase extends PyriteBase implements Byteable {
  public TagLength: number;
  public Length: number;
  public Text: string[];
  
  constructor(hex: ArrayBuffer, tie?: IMission) {
    super(hex, tie);
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
    this.TagLength = offset;
  }
  
  public toJSON(): object {
    return {
      Length: this.Length,
      Text: this.Text
    };
  }
  
  public toHexString(): string {
    let hex: string = '';
    let offset = 0;

    writeShort(hex, this.Length, 0x0);
    offset = 0x2;
    for (let i = 0; i < this.Length; i++) {
      const t = this.Text[i];
      writeChar(hex, t, offset);
      offset += 1;
    }

    return hex;
  }
  
  
  public getLength(): number {
    return this.TagLength;
  }
}