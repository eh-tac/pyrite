import { Byteable } from "../../../byteable";
import { Header } from "../header";
import { IMission, PyriteBase } from "../../../pyrite-base";
import { writeObject } from "../../../hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class LFDBase extends PyriteBase implements Byteable {
  public LFDLength: number;
  public Header: Header;
  
  constructor(hex: ArrayBuffer, tie?: IMission) {
    super(hex, tie);
    this.beforeConstruct();
    let offset = 0;

    this.Header = new Header(hex.slice(0x00), this.TIE);
    this.LFDLength = offset;
  }
  
  public toJSON(): object {
    return {
      Header: this.Header
    };
  }
  
  public toHexString(): string {
    let hex: string = '';
    let offset = 0;

    writeObject(hex, this.Header, 0x00);

    return hex;
  }
  
  
  public getLength(): number {
    return this.LFDLength;
  }
}