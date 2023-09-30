import { Byteable } from "../../../byteable";
import { Constants } from "../constants";
import { IMission, PyriteBase } from "../../../pyrite-base";
import { getChar, getShort, writeChar, writeShort } from "../../../hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class ObjectGroupBase extends PyriteBase implements Byteable {
  public readonly OBJECTGROUPLENGTH: number = 70;
  public Name: string[]; //(ignored?)
  public Cargo: string[]; //(ignored?)
  public SpecialCargo: string[]; //(ignored?)
  public SpecialCargoCraft: number; //(ignored?)
  public CraftType: number;
  public IFF: number;
  public ObjectFormation: number; //or values (unusual formatting)
  public NumberOfCraft: number; //or values (unusual formatting)
  public X: number;
  public Y: number;
  public Z: number;
  public Yaw: number;
  public Pitch: number;
  public Roll: number;
  
  constructor(hex: ArrayBuffer, tie?: IMission) {
    super(hex, tie);
    this.beforeConstruct();
    let offset = 0;

    this.Name = [];
    offset = 0x000;
    for (let i = 0; i < 16; i++) {
      const t = getChar(hex, offset, 1);
      this.Name.push(t);
      offset += 1;
    }
    this.Cargo = [];
    offset = 0x010;
    for (let i = 0; i < 16; i++) {
      const t = getChar(hex, offset, 1);
      this.Cargo.push(t);
      offset += 1;
    }
    this.SpecialCargo = [];
    offset = 0x020;
    for (let i = 0; i < 16; i++) {
      const t = getChar(hex, offset, 1);
      this.SpecialCargo.push(t);
      offset += 1;
    }
    this.SpecialCargoCraft = getShort(hex, 0x030);
    this.CraftType = getShort(hex, 0x032);
    this.IFF = getShort(hex, 0x034);
    this.ObjectFormation = getShort(hex, 0x036);
    this.NumberOfCraft = getShort(hex, 0x038);
    this.X = getShort(hex, 0x03A);
    this.Y = getShort(hex, 0x03C);
    this.Z = getShort(hex, 0x03E);
    this.Yaw = getShort(hex, 0x040);
    this.Pitch = getShort(hex, 0x042);
    this.Roll = getShort(hex, 0x044);
    
  }
  
  public toJSON(): object {
    return {
      Name: this.Name,
      Cargo: this.Cargo,
      SpecialCargo: this.SpecialCargo,
      SpecialCargoCraft: this.SpecialCargoCraft,
      CraftType: this.CraftTypeLabel,
      IFF: this.IFFLabel,
      ObjectFormation: this.ObjectFormationLabel,
      NumberOfCraft: this.NumberOfCraft,
      X: this.X,
      Y: this.Y,
      Z: this.Z,
      Yaw: this.Yaw,
      Pitch: this.Pitch,
      Roll: this.Roll
    };
  }
  
  public toHexString(): string {
    let hex: string = '';
    let offset = 0;

    offset = 0x000;
    for (let i = 0; i < 16; i++) {
      const t = this.Name[i];
      writeChar(hex, t, offset);
      offset += 1;
    }
    offset = 0x010;
    for (let i = 0; i < 16; i++) {
      const t = this.Cargo[i];
      writeChar(hex, t, offset);
      offset += 1;
    }
    offset = 0x020;
    for (let i = 0; i < 16; i++) {
      const t = this.SpecialCargo[i];
      writeChar(hex, t, offset);
      offset += 1;
    }
    writeShort(hex, this.SpecialCargoCraft, 0x030);
    writeShort(hex, this.CraftType, 0x032);
    writeShort(hex, this.IFF, 0x034);
    writeShort(hex, this.ObjectFormation, 0x036);
    writeShort(hex, this.NumberOfCraft, 0x038);
    writeShort(hex, this.X, 0x03A);
    writeShort(hex, this.Y, 0x03C);
    writeShort(hex, this.Z, 0x03E);
    writeShort(hex, this.Yaw, 0x040);
    writeShort(hex, this.Pitch, 0x042);
    writeShort(hex, this.Roll, 0x044);

    return hex;
  }
  
  public get CraftTypeLabel(): string {
    return Constants.CRAFTTYPE[this.CraftType] || "Unknown";
  }

  public get IFFLabel(): string {
    return Constants.IFF[this.IFF] || "Unknown";
  }

  public get ObjectFormationLabel(): string {
    return Constants.OBJECTFORMATION[this.ObjectFormation] || "Unknown";
  }
  
  public getLength(): number {
    return this.OBJECTGROUPLENGTH;
  }
}