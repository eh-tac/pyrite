import { Byteable, IMission, PyriteBase } from '@pyrite/core';
import { getByte, getInt, getString, writeByte, writeInt, writeString } from '@pyrite/core';
export abstract class GlobalCargoBase extends PyriteBase implements Byteable {
  public readonly GLOBALCARGOLENGTH: number = 140;
  public Cargo: string;
  public ID: number;
  public Count: number; //(was Unknown1)
  public Type: number; //(was Unknown2) {solid, liquid, gas}
  public Volume: number; //(was Unknown3)
  public Value: number; //(was Unknown4)
  public Volatility: number; //(was Unknown5) {low, med, high, kaboom!}

  constructor(
    public hex: ArrayBuffer,
    public TIE?: IMission
  ) {
    super(hex, TIE!);
    this.beforeConstruct();

    this.Cargo = getString(hex, 0x00, 64);
    this.ID = getInt(hex, 0x40);
    this.Count = getInt(hex, 0x44);
    this.Type = getByte(hex, 0x48);
    this.Volume = getByte(hex, 0x49);
    this.Value = getByte(hex, 0x4a);
    this.Volatility = getByte(hex, 0x4b);
  }

  public toJSON(): Record<string, unknown> | string {
    return {
      Cargo: this.Cargo,
      ID: this.ID,
      Count: this.Count,
      Type: this.Type,
      Volume: this.Volume,
      Value: this.Value,
      Volatility: this.Volatility
    };
  }

  public toHexBuffer(): ArrayBuffer {
    const hex: ArrayBuffer = new ArrayBuffer(this.getLength());

    writeString(hex, this.Cargo, 0x00, 64);
    writeInt(hex, this.ID, 0x40);
    writeInt(hex, this.Count, 0x44);
    writeByte(hex, this.Type, 0x48);
    writeByte(hex, this.Volume, 0x49);
    writeByte(hex, this.Value, 0x4a);
    writeByte(hex, this.Volatility, 0x4b);

    return hex;
  }

  public getLength(): number {
    return this.GLOBALCARGOLENGTH;
  }
}
