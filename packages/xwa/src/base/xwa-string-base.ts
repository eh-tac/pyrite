import type { Byteable, IMission} from '@pyrite/core';
import { PyriteBase } from '@pyrite/core';
import { getByte, writeByte } from '@pyrite/core';
export abstract class XWAStringBase extends PyriteBase implements Byteable {
  public XWAStringLength: number;
  public Magic: number;

  constructor(hex: ArrayBuffer, TIE?: IMission) {
    super(hex, TIE!);
    this.beforeConstruct();

    this.Magic = getByte(hex, 0x0);
    this.XWAStringLength = 0; // implement in child class;
  }

  public toJSON(): Record<string, unknown> | string {
    return {
      Magic: this.Magic
    };
  }

  public toHexBuffer(): ArrayBuffer {
    const hex: ArrayBuffer = new ArrayBuffer(this.getLength());

    writeByte(hex, this.Magic, 0x0);

    return hex;
  }

  public getLength(): number {
    return this.XWAStringLength;
  }
}
