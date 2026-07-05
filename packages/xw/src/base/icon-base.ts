import type { Byteable, IMission} from '@pyrite/core';
import { PyriteBase } from '@pyrite/core';
import { getChar, getShort, writeChar, writeShort } from '@pyrite/core';
export abstract class IconBase extends PyriteBase implements Byteable {
  public readonly ICONLENGTH: number = 64;
  public CraftType: number;
  public IFF: number;
  public NumberOfCraft: number;
  public NumberOfWaves: number;
  public Name: string;
  public Cargo: string;
  public SpecialCargo: string;
  public SpecialCargoCraft: number;
  public Yaw: number;
  public Pitch: number;
  public Roll: number;

  constructor(hex: ArrayBuffer, TIE?: IMission) {
    super(hex, TIE!);
    this.beforeConstruct();

    this.CraftType = getShort(hex, 0x000);
    this.IFF = getShort(hex, 0x002);
    this.NumberOfCraft = getShort(hex, 0x004);
    this.NumberOfWaves = getShort(hex, 0x006);
    this.Name = getChar(hex, 0x008, 16);
    this.Cargo = getChar(hex, 0x018, 16);
    this.SpecialCargo = getChar(hex, 0x028, 16);
    this.SpecialCargoCraft = getShort(hex, 0x038);
    this.Yaw = getShort(hex, 0x03a);
    this.Pitch = getShort(hex, 0x03c);
    this.Roll = getShort(hex, 0x03e);
  }

  public toJSON(): Record<string, unknown> | string {
    return {
      CraftType: this.CraftType,
      IFF: this.IFF,
      NumberOfCraft: this.NumberOfCraft,
      NumberOfWaves: this.NumberOfWaves,
      Name: this.Name,
      Cargo: this.Cargo,
      SpecialCargo: this.SpecialCargo,
      SpecialCargoCraft: this.SpecialCargoCraft,
      Yaw: this.Yaw,
      Pitch: this.Pitch,
      Roll: this.Roll
    };
  }

  public toHexBuffer(): ArrayBuffer {
    const hex: ArrayBuffer = new ArrayBuffer(this.getLength());

    writeShort(hex, this.CraftType, 0x000);
    writeShort(hex, this.IFF, 0x002);
    writeShort(hex, this.NumberOfCraft, 0x004);
    writeShort(hex, this.NumberOfWaves, 0x006);
    writeChar(hex, this.Name, 0x008, 16);
    writeChar(hex, this.Cargo, 0x018, 16);
    writeChar(hex, this.SpecialCargo, 0x028, 16);
    writeShort(hex, this.SpecialCargoCraft, 0x038);
    writeShort(hex, this.Yaw, 0x03a);
    writeShort(hex, this.Pitch, 0x03c);
    writeShort(hex, this.Roll, 0x03e);

    return hex;
  }

  public getLength(): number {
    return this.ICONLENGTH;
  }
}
