import { Byteable } from "../../../byteable";
import { Header } from "../header";
import { IMission, PyriteBase } from "../../../pyrite-base";
import { writeObject } from "../../../hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class VoicBase extends PyriteBase implements Byteable {
  public VoicLength: number;
  public Header: Header;
  public Data: any;
  
  constructor(hex: ArrayBuffer, tie?: IMission) {
    super(hex, tie);
    this.beforeConstruct();
    let offset = 0;

    this.Header = new Header(hex.slice(0x00), this.TIE);
    this.Data = undefined;
    offset = 0x10 + 0
    this.VoicLength = offset;
  }
  
  public toJSON(): object {
    return {
      Header: this.Header,
      Data: this.Data
    };
  }
  
  public toHexString(): string {
    let hex: string = '';
    let offset = 0;

    writeObject(hex, this.Header, 0x00);
    writeObject(hex, this.Data, 0x10);

    return hex;
  }
  
  protected abstract loadData();
protected abstract writeData();
  public getLength(): number {
    return this.VoicLength;
  }
}