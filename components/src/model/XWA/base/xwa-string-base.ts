import { Byteable } from "../../../byteable";
import { IMission, PyriteBase } from "../../../pyrite-base";
import { getByte, writeByte } from "../../../hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class XWAStringBase extends PyriteBase implements Byteable {
  public XWAStringLength: number;
  public Magic: number;
  
  constructor(hex: ArrayBuffer, TIE?: IMission) {
    super(hex, TIE!);
    this.beforeConstruct();
    let offset = 0;

    this.Magic = getByte(hex, 0x0);
    this.XWAStringLength = offset;
  }
  
  public toJSON(): Record<string, unknown> | string {
    return {
      Magic: this.Magic,
    };
  }
  
  public toHexBuffer(): ArrayBuffer {
    const hex: ArrayBuffer = new ArrayBuffer(this.getLength());
    let offset = 0;

    writeByte(hex, this.Magic, 0x0);

    return hex;
  }
  
  
  public getLength(): number {
    return this.XWAStringLength;
  }
}