import { Byteable } from "../../../byteable";
import { IMission, PyriteBase } from "../../../pyrite-base";
import { getChar, getShort, writeChar, writeShort } from "../../../hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class IconBase extends PyriteBase implements Byteable {
  public readonly ICONLENGTH: number = 64;
  public CraftType: number;
  public IFF: number;
  public NumberOfCraft: number;
  public NumberOfWaves: number;
  public Name: string[];
  public Cargo: string[];
  public SpecialCargo: string[];
  public SpecialCargoCraft: number;
  public Yaw: number;
  public Pitch: number;
  public Roll: number;
  
  constructor(hex: ArrayBuffer, tie?: IMission) {
    super(hex, tie);
    this.beforeConstruct();
    let offset = 0;

    this.CraftType = getShort(hex, 0x000);
    this.IFF = getShort(hex, 0x002);
    this.NumberOfCraft = getShort(hex, 0x004);
    this.NumberOfWaves = getShort(hex, 0x006);
    this.Name = [];
    offset = 0x008;
    for (let i = 0; i < 16; i++) {
      const t = getChar(hex, offset, 1);
      this.Name.push(t);
      offset += 1;
    }
    this.Cargo = [];
    offset = 0x018;
    for (let i = 0; i < 16; i++) {
      const t = getChar(hex, offset, 1);
      this.Cargo.push(t);
      offset += 1;
    }
    this.SpecialCargo = [];
    offset = 0x028;
    for (let i = 0; i < 16; i++) {
      const t = getChar(hex, offset, 1);
      this.SpecialCargo.push(t);
      offset += 1;
    }
    this.SpecialCargoCraft = getShort(hex, 0x038);
    this.Yaw = getShort(hex, 0x03A);
    this.Pitch = getShort(hex, 0x03C);
    this.Roll = getShort(hex, 0x03E);
    
  }
  
  public toJSON(): object {
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
  
  public toHexString(): string {
    let hex: string = '';
    let offset = 0;

    writeShort(hex, this.CraftType, 0x000);
    writeShort(hex, this.IFF, 0x002);
    writeShort(hex, this.NumberOfCraft, 0x004);
    writeShort(hex, this.NumberOfWaves, 0x006);
    offset = 0x008;
    for (let i = 0; i < 16; i++) {
      const t = this.Name[i];
      writeChar(hex, t, offset);
      offset += 1;
    }
    offset = 0x018;
    for (let i = 0; i < 16; i++) {
      const t = this.Cargo[i];
      writeChar(hex, t, offset);
      offset += 1;
    }
    offset = 0x028;
    for (let i = 0; i < 16; i++) {
      const t = this.SpecialCargo[i];
      writeChar(hex, t, offset);
      offset += 1;
    }
    writeShort(hex, this.SpecialCargoCraft, 0x038);
    writeShort(hex, this.Yaw, 0x03A);
    writeShort(hex, this.Pitch, 0x03C);
    writeShort(hex, this.Roll, 0x03E);

    return hex;
  }
  
  
  public getLength(): number {
    return this.ICONLENGTH;
  }
}