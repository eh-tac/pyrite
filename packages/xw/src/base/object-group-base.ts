import { Byteable, IMission, PyriteBase } from '@pyrite/core';
import { Constants, CraftType, IFF, ObjectFormation } from '../constants';
import { getChar, getShort, writeChar, writeShort } from '@pyrite/core';
export abstract class ObjectGroupBase extends PyriteBase implements Byteable {
  public readonly OBJECTGROUPLENGTH: number = 70;
  public Name: string; //(ignored?)
  public Cargo: string; //(ignored?)
  public SpecialCargo: string; //(ignored?)
  public SpecialCargoCraft: number; //(ignored?)
  public CraftType: CraftType;
  public IFF: IFF;
  public ObjectFormation: ObjectFormation; //or values (unusual formatting)
  public NumberOfCraft: number; //or values (unusual formatting)
  public X: number;
  public Y: number;
  public Z: number;
  public Yaw: number;
  public Pitch: number;
  public Roll: number;

  constructor(
    public hex: ArrayBuffer,
    public TIE?: IMission
  ) {
    super(hex, TIE!);
    this.beforeConstruct();

    this.Name = getChar(hex, 0x000, 16);
    this.Cargo = getChar(hex, 0x010, 16);
    this.SpecialCargo = getChar(hex, 0x020, 16);
    this.SpecialCargoCraft = getShort(hex, 0x030);
    this.CraftType = getShort(hex, 0x032) as CraftType;
    this.IFF = getShort(hex, 0x034) as IFF;
    this.ObjectFormation = getShort(hex, 0x036) as ObjectFormation;
    this.NumberOfCraft = getShort(hex, 0x038);
    this.X = getShort(hex, 0x03a);
    this.Y = getShort(hex, 0x03c);
    this.Z = getShort(hex, 0x03e);
    this.Yaw = getShort(hex, 0x040);
    this.Pitch = getShort(hex, 0x042);
    this.Roll = getShort(hex, 0x044);
  }

  public toJSON(): Record<string, unknown> | string {
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

  public toHexBuffer(): ArrayBuffer {
    const hex: ArrayBuffer = new ArrayBuffer(this.getLength());

    writeChar(hex, this.Name, 0x000, 16);
    writeChar(hex, this.Cargo, 0x010, 16);
    writeChar(hex, this.SpecialCargo, 0x020, 16);
    writeShort(hex, this.SpecialCargoCraft, 0x030);
    writeShort(hex, this.CraftType, 0x032);
    writeShort(hex, this.IFF, 0x034);
    writeShort(hex, this.ObjectFormation, 0x036);
    writeShort(hex, this.NumberOfCraft, 0x038);
    writeShort(hex, this.X, 0x03a);
    writeShort(hex, this.Y, 0x03c);
    writeShort(hex, this.Z, 0x03e);
    writeShort(hex, this.Yaw, 0x040);
    writeShort(hex, this.Pitch, 0x042);
    writeShort(hex, this.Roll, 0x044);

    return hex;
  }

  public get CraftTypeLabel(): string {
    return Constants.CRAFTTYPE[this.CraftType] || 'Unknown';
  }

  public get IFFLabel(): string {
    return Constants.IFF[this.IFF] || 'Unknown';
  }

  public get ObjectFormationLabel(): string {
    return Constants.OBJECTFORMATION[this.ObjectFormation] || 'Unknown';
  }

  public getLength(): number {
    return this.OBJECTGROUPLENGTH;
  }
}
