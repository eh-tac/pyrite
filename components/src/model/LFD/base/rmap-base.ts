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
  
  constructor(hex: ArrayBuffer, TIE?: IMission) {
    super(hex, TIE!);
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
  
  public toJSON(): Record<string, unknown> | string {
    return {
      Header: this.Header.toJSON(),
      Subheaders: this.Subheaders.map((t) => t.toJSON()),
    };
  }
  
  public toHexBuffer(): ArrayBuffer {
    const hex: ArrayBuffer = new ArrayBuffer(this.getLength());
    let offset = 0;

    writeObject(hex, this.Header, 0x00);
    offset = 0x10;
    for (let i = 0; i < this.Subheaders.length; i++) {
      const t = this.Subheaders[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }

    return hex;
  }
  
  protected abstract HeaderCount(): number;
  public getLength(): number {
    return this.RmapLength;
  }
}