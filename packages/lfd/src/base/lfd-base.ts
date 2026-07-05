import { Byteable, IMission, PyriteBase } from '@pyrite/core';
import { Header } from '../header';
import { writeObject } from '@pyrite/core';
export abstract class LFDBase extends PyriteBase implements Byteable {
  public readonly LFDLENGTH: number = 16;
  public Header: Header;

  constructor(
    public hex: ArrayBuffer,
    public TIE?: IMission
  ) {
    super(hex, TIE!);
    this.beforeConstruct();

    this.Header = new Header(hex.slice(0x00), this.TIE);
  }

  public toJSON(): Record<string, unknown> | string {
    return {
      Header: this.Header.toJSON()
    };
  }

  public toHexBuffer(): ArrayBuffer {
    const hex: ArrayBuffer = new ArrayBuffer(this.getLength());

    writeObject(hex, this.Header, 0x00);

    return hex;
  }

  public getLength(): number {
    return this.LFDLENGTH;
  }
}
