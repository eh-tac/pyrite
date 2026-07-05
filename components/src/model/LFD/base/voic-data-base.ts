import { Byteable } from "../../../byteable";
import { IMission, PyriteBase } from "../../../pyrite-base";
import { getByte, writeByte, writeObject } from "../../../hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class VoicDataBase extends PyriteBase implements Byteable {
  public VoicDataLength: number;
  public Type: number;
  public Size: number[];
  public Data: any;

  constructor(hex: ArrayBuffer, TIE?: IMission) {
    super(hex, TIE!);
    this.beforeConstruct();
    let offset = 0;

    this.Type = getByte(hex, 0x00);
    this.Size = [];
    offset = 0x01;
    for (let i = 0; i < 3; i++) {
      const t = getByte(hex, offset);
      this.Size.push(t);
      offset += 1;
    }
    this.Data = undefined;
    offset = 0x04 + 0;
    this.VoicDataLength = offset;
  }

  public toJSON(): Record<string, unknown> | string {
    return {
      Type: this.Type,
      Size: this.Size,
      Data: this.Data,
    };
  }

  public toHexBuffer(): ArrayBuffer {
    const hex: ArrayBuffer = new ArrayBuffer(this.getLength());
    let offset = 0;

    writeByte(hex, this.Type, 0x00);
    offset = 0x01;
    for (let i = 0; i < this.Size.length; i++) {
      const t = this.Size[i];
      writeByte(hex, t, offset);
      offset += 1;
    }
    writeObject(hex, this.Data, 0x04);

    return hex;
  }

  protected abstract loadData(): number;
  protected abstract writeData(): number;
  public getLength(): number {
    return this.VoicDataLength;
  }
}
