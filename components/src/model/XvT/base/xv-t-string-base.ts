import { Byteable } from "../../../byteable";
import { IMission, PyriteBase } from "../../../pyrite-base";
import { getChar, getShort, writeChar, writeShort } from "../../../hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class XvTStringBase extends PyriteBase implements Byteable {
  public XvTStringLength: number;
  public Length: number;
  public Text: string;
  
  constructor(hex: ArrayBuffer, TIE?: IMission) {
    super(hex, TIE!);
    this.beforeConstruct();
    let offset = 0;

    this.Length = getShort(hex, 0x0);
    this.Text = getChar(hex, 0x2, this.Length);
    offset = 0x2 + this.Length;
    this.XvTStringLength = offset;
  }
  
  public toJSON(): Record<string, unknown> | string {
    return {
      Length: this.Length,
      Text: this.Text,
    };
  }
  
  public toHexBuffer(): ArrayBuffer {
    const hex: ArrayBuffer = new ArrayBuffer(this.getLength());
    let offset = 0;

    writeShort(hex, this.Length, 0x0);
    writeChar(hex, this.Text, 0x2, this.Length);

    return hex;
  }
  
  
  public getLength(): number {
    return this.XvTStringLength;
  }
}