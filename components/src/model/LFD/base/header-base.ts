import { Byteable } from "../../../byteable";
import { IMission, PyriteBase } from "../../../pyrite-base";
import { getChar, getInt, writeChar, writeInt } from "../../../hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class HeaderBase extends PyriteBase implements Byteable {
  public readonly HEADERLENGTH: number = 16;
  public Type: string;
  public Name: string;
  public Length: number; //little endian

  constructor(hex: ArrayBuffer, TIE?: IMission) {
    super(hex, TIE!);
    this.beforeConstruct();
    let offset = 0;

    this.Type = getChar(hex, 0x00, 4);
    this.Name = getChar(hex, 0x04, 8);
    this.Length = getInt(hex, 0x0c);
  }

  public toJSON(): Record<string, unknown> | string {
    return {
      Type: this.Type,
      Name: this.Name,
      Length: this.Length,
    };
  }

  public toHexBuffer(): ArrayBuffer {
    const hex: ArrayBuffer = new ArrayBuffer(this.getLength());
    let offset = 0;

    writeChar(hex, this.Type, 0x00, 4);
    writeChar(hex, this.Name, 0x04, 8);
    writeInt(hex, this.Length, 0x0c);

    return hex;
  }

  public getLength(): number {
    return this.HEADERLENGTH;
  }
}
