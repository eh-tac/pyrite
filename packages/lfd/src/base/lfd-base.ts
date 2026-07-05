import type { Byteable, IMission} from '@pyrite/core';
import { PyriteBase } from '@pyrite/core';
import { writeObject } from '@pyrite/core';

import { Header } from '../header';
export abstract class LFDBase extends PyriteBase implements Byteable {
  public readonly LFDLENGTH: number = 16;
  public Header: Header;

  constructor(hex: ArrayBuffer, TIE?: IMission) {
    super(hex, TIE!);
    this.beforeConstruct();

    this.Header = new Header([...hex], this.TIE);
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
