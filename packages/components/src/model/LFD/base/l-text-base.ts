import { Byteable } from "../../../byteable";
import { IMission, PyriteBase } from "../../../pyrite-base";
import { LString } from "../l-string";
import { getShort, writeObject, writeShort } from "../../../hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class LTextBase extends PyriteBase implements Byteable {
  public LTextLength: number;
  public NumStrings: number;
  public Strings: LString[];
  
  constructor(hex: ArrayBuffer, tie?: IMission) {
    super(hex, tie);
    this.beforeConstruct();
    let offset = 0;

    this.NumStrings = getShort(hex, 0x00);
    this.Strings = [];
    offset = 0x02;
    for (let i = 0; i < this.NumStrings; i++) {
      const t = new LString(hex.slice(offset), this.TIE);
      this.Strings.push(t);
      offset += t.getLength();
    }
    this.LTextLength = offset;
  }
  
  public toJSON(): object {
    return {
      NumStrings: this.NumStrings,
      Strings: this.Strings
    };
  }
  
  public toHexString(): string {
    let hex: string = '';
    let offset = 0;

    writeShort(hex, this.NumStrings, 0x00);
    offset = 0x02;
    for (let i = 0; i < this.NumStrings; i++) {
      const t = this.Strings[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }

    return hex;
  }
  
  
  public getLength(): number {
    return this.LTextLength;
  }
}