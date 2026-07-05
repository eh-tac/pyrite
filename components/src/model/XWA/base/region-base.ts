import { Byteable } from "../../../byteable";
import { IMission, PyriteBase } from "../../../pyrite-base";
import { getInt, getString, writeInt, writeString } from "../../../hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class RegionBase extends PyriteBase implements Byteable {
  public readonly REGIONLENGTH: number = 132;
  public Name: string;
  public ID: number;

  constructor(hex: ArrayBuffer, TIE?: IMission) {
    super(hex, TIE!);
    this.beforeConstruct();
    let offset = 0;

    this.Name = getString(hex, 0x00, 64);
    this.ID = getInt(hex, 0x40);
  }

  public toJSON(): Record<string, unknown> | string {
    return {
      Name: this.Name,
      ID: this.ID,
    };
  }

  public toHexBuffer(): ArrayBuffer {
    const hex: ArrayBuffer = new ArrayBuffer(this.getLength());
    let offset = 0;

    writeString(hex, this.Name, 0x00, 64);
    writeInt(hex, this.ID, 0x40);

    return hex;
  }

  public getLength(): number {
    return this.REGIONLENGTH;
  }
}
