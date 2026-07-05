import { Byteable } from "../../../byteable";
import { Header } from "../header";
import { IMission, PyriteBase } from "../../../pyrite-base";
import { writeObject } from "../../../hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class LFDBase extends PyriteBase implements Byteable {
  public LFDLength: number;
  public Header: Header;

  constructor(hex: ArrayBuffer, TIE?: IMission) {
    super(hex, TIE!);
    this.beforeConstruct();
    let offset = 0;

    this.Header = new Header(hex.slice(0x00), this.TIE);
    this.LFDLength = offset;
  }

  public toJSON(): Record<string, unknown> | string {
    return {
      Header: this.Header.toJSON(),
    };
  }

  public toHexBuffer(): ArrayBuffer {
    const hex: ArrayBuffer = new ArrayBuffer(this.getLength());
    let offset = 0;

    writeObject(hex, this.Header, 0x00);

    return hex;
  }

  public getLength(): number {
    return this.LFDLength;
  }
}
