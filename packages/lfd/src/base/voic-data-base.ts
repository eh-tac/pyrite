import { Byteable, IMission, PyriteBase } from '@pyrite/core';
import { getByte, writeByte } from '@pyrite/core';
export abstract class VoicDataBase extends PyriteBase implements Byteable {
  public VoicDataLength: number;
  public Type: number;
  public Size: number[];
  public Data: number;

  constructor(
    public hex: ArrayBuffer,
    public TIE?: IMission
  ) {
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
    this.Data = getByte(hex, 0x04);
    this.VoicDataLength = offset;
  }

  public toJSON(): Record<string, unknown> | string {
    return {
      Type: this.Type,
      Size: this.Size,
      Data: this.Data
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
    writeByte(hex, this.Data, 0x04);

    return hex;
  }

  public getLength(): number {
    return this.VoicDataLength;
  }
}
