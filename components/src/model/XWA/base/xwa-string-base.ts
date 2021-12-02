import { Byteable } from "../../../byteable";
import { IMission, PyriteBase } from "../../../pyrite-base";
import { getByte, writeByte } from "../../../hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class XWAStringBase extends PyriteBase implements Byteable {
  public XWAStringLength: number;
  public Magic: number;
  
  constructor(hex: ArrayBuffer, tie?: IMission) {
    super(hex, tie);
    this.beforeConstruct();
    let offset = 0;

    this.Magic = getByte(hex, 0x0);
    this.XWAStringLength = offset;
  }
  
  public toJSON(): object {
    return {
      Magic: this.Magic
    };
  }
  
  public toHexString(): string {
    let hex: string = '';
    let offset = 0;

    writeByte(hex, this.Magic, 0x0);

    return hex;
  }
  
  
  public getLength(): number {
    return this.XWAStringLength;
  }
}