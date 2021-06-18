import { Byteable } from "../../../byteable";
import { IMission, PyriteBase } from "../../../pyrite-base";
import { getByte, getShort, getString, writeByte, writeShort, writeString } from "../../../hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class LStringBase extends PyriteBase implements Byteable {
  public LStringLength: number;
  public Length: number;
  public Substrings: string[];
  public readonly Reserved: number = 0;
  
  constructor(hex: ArrayBuffer, tie?: IMission) {
    super(hex, tie);
    this.beforeConstruct();
    let offset = 0;

    this.Length = getShort(hex, 0x00);
    this.Substrings = [];
    offset = 0x02;
    for (let i = 0; i < 0; i++) {
      const t = getString(hex, offset);
      this.Substrings.push(t);
      offset += t.length;
    }
    // static prop Reserved
    offset += 1;
    this.LStringLength = offset;
  }
  
  public toJSON(): object {
    return {
      Length: this.Length,
      Substrings: this.Substrings
    };
  }
  
  public toHexString(): string {
    let hex: string = '';
    let offset = 0;

    writeShort(hex, this.Length, 0x00);
    offset = 0x02;
    for (let i = 0; i < 0; i++) {
      const t = this.Substrings[i];
      writeString(hex, t, offset);
      offset += t.length;
    }
    writeByte(hex, 0, offset);

    return hex;
  }
  
  
  public getLength(): number {
    return this.LStringLength;
  }
}