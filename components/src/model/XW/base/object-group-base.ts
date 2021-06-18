import { Byteable } from "../../../byteable";
import { Constants } from "../constants";
import { IMission, PyriteBase } from "../../../pyrite-base";
import { getShort, getString, writeShort, writeString } from "../../../hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class ObjectGroupBase extends PyriteBase implements Byteable {
  public readonly OBJECTGROUPLENGTH: number = 70;
  public Name: string;
  public Cargo: string;
  public SpecialCargo: string;
  public readonly Reserved: number = 0;
  public ObjectType: number;
  public IFF: number;
  public Objective: number;
  public NumberOfObjects: number;
  public PositionX: number;
  public PositionY: number;
  public PositionZ: number;
  public readonly Unknown1: number = 0;
  public readonly Unknown2: number = 64;
  public readonly Unknown3: number = 0;
  
  constructor(hex: ArrayBuffer, tie?: IMission) {
    super(hex, tie);
    this.beforeConstruct();
    let offset = 0;

    this.Name = getString(hex, 0x00);
    this.Cargo = getString(hex, 0x10);
    this.SpecialCargo = getString(hex, 0x20);
    // static prop Reserved
    this.ObjectType = getShort(hex, 0x32);
    this.IFF = getShort(hex, 0x34);
    this.Objective = getShort(hex, 0x36);
    this.NumberOfObjects = getShort(hex, 0x38);
    this.PositionX = getShort(hex, 0x3A);
    this.PositionY = getShort(hex, 0x3C);
    this.PositionZ = getShort(hex, 0x3E);
    // static prop Unknown1
    // static prop Unknown2
    // static prop Unknown3
    
  }
  
  public toJSON(): object {
    return {
      Name: this.Name,
      Cargo: this.Cargo,
      SpecialCargo: this.SpecialCargo,
      ObjectType: this.ObjectType,
      IFF: this.IFFLabel,
      Objective: this.Objective,
      NumberOfObjects: this.NumberOfObjects,
      PositionX: this.PositionX,
      PositionY: this.PositionY,
      PositionZ: this.PositionZ
    };
  }
  
  public toHexString(): string {
    let hex: string = '';
    let offset = 0;

    writeString(hex, this.Name, 0x00);
    writeString(hex, this.Cargo, 0x10);
    writeString(hex, this.SpecialCargo, 0x20);
    writeShort(hex, 0, 0x30);
    writeShort(hex, this.ObjectType, 0x32);
    writeShort(hex, this.IFF, 0x34);
    writeShort(hex, this.Objective, 0x36);
    writeShort(hex, this.NumberOfObjects, 0x38);
    writeShort(hex, this.PositionX, 0x3A);
    writeShort(hex, this.PositionY, 0x3C);
    writeShort(hex, this.PositionZ, 0x3E);
    writeShort(hex, 0, 0x40);
    writeShort(hex, 64, 0x42);
    writeShort(hex, 0, 0x44);

    return hex;
  }
  
  public get IFFLabel(): string {
    return Constants.IFF[this.IFF] || "Unknown";
  }
  
  public getLength(): number {
    return this.OBJECTGROUPLENGTH;
  }
}