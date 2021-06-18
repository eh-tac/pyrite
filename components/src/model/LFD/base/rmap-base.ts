import { Byteable } from "../../../byteable";
import { Header } from "../header";
import { IMission, PyriteBase } from "../../../pyrite-base";
import { writeObject } from "../../../hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class RmapBase extends PyriteBase implements Byteable {
  public RmapLength: number;
  public Header: Header;
  public Subheaders: Header[];
  
  constructor(hex: ArrayBuffer, tie?: IMission) {
    super(hex, tie);
    this.beforeConstruct();
    let offset = 0;

    this.Header = new Header(hex.slice(0x00), this.TIE);
    this.Subheaders = [];
    offset = 0x10;
    for (let i = 0; i < this.HeaderCount(); i++) {
      const t = new Header(hex.slice(offset), this.TIE);
      this.Subheaders.push(t);
      offset += t.getLength();
    }
    this.RmapLength = offset;
  }
  
  public toJSON(): object {
    return {
      Header: this.Header,
      Subheaders: this.Subheaders
    };
  }
  
  public toHexString(): string {
    let hex: string = '';
    let offset = 0;

    writeObject(hex, this.Header, 0x00);
    offset = 0x10;
    for (let i = 0; i < this.HeaderCount(); i++) {
      const t = this.Subheaders[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }

    return hex;
  }
  
  protected abstract HeaderCount();
  public getLength(): number {
    return this.RmapLength;
  }
}