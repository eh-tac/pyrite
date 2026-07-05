import { Byteable, IMission, PyriteBase } from '@pyrite/core';
import { getBool, getByte, getString, writeBool, writeByte, writeString } from '@pyrite/core';
export abstract class GlobalUnitBase extends PyriteBase implements Byteable {
  public readonly GLOBALUNITLENGTH: number = 87;
  public Name: string;
  public Leader: number;
  public SpecialCargoCraft: number;
  public SpecialCargo: string;
  public RandSpecCraft: boolean;

  constructor(hex: ArrayBuffer, TIE?: IMission) {
    super(hex, TIE!);
    this.beforeConstruct();

    this.Name = getString(hex, 0x00, 64);
    this.Leader = getByte(hex, 0x40);
    this.SpecialCargoCraft = getByte(hex, 0x41);
    this.SpecialCargo = getString(hex, 0x42, 20);
    this.RandSpecCraft = getBool(hex, 0x56);
  }

  public toJSON(): Record<string, unknown> | string {
    return {
      Name: this.Name,
      Leader: this.Leader,
      SpecialCargoCraft: this.SpecialCargoCraft,
      SpecialCargo: this.SpecialCargo,
      RandSpecCraft: this.RandSpecCraft
    };
  }

  public toHexBuffer(): ArrayBuffer {
    const hex: ArrayBuffer = new ArrayBuffer(this.getLength());

    writeString(hex, this.Name, 0x00, 64);
    writeByte(hex, this.Leader, 0x40);
    writeByte(hex, this.SpecialCargoCraft, 0x41);
    writeString(hex, this.SpecialCargo, 0x42, 20);
    writeBool(hex, this.RandSpecCraft, 0x56);

    return hex;
  }

  public getLength(): number {
    return this.GLOBALUNITLENGTH;
  }
}
