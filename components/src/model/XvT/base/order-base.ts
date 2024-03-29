import { Byteable } from "../../../byteable";
import { Constants } from "../constants";
import { IMission, PyriteBase } from "../../../pyrite-base";
import { getBool, getByte, getString, writeBool, writeByte, writeString } from "../../../hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class OrderBase extends PyriteBase implements Byteable {
  public readonly ORDERLENGTH: number = 82;
  public Order: number;
  public Throttle: number;
  public Variable1: number;
  public Variable2: number;
  public Unknown6: number;
  public Unknown7: number;
  public Target3Type: number;
  public Target4Type: number;
  public Target3: number;
  public Target4: number;
  public Target3OrTarget4: boolean;
  public Unknown8: number;
  public Target1Type: number;
  public Target1: number;
  public Target2Type: number;
  public Target2: number;
  public Target1OrTarget2: boolean;
  public Unknown9: number;
  public Speed: number;
  public Designation: string;
  
  constructor(hex: ArrayBuffer, tie?: IMission) {
    super(hex, tie);
    this.beforeConstruct();
    let offset = 0;

    this.Order = getByte(hex, 0x00);
    this.Throttle = getByte(hex, 0x01);
    this.Variable1 = getByte(hex, 0x02);
    this.Variable2 = getByte(hex, 0x03);
    this.Unknown6 = getByte(hex, 0x04);
    this.Unknown7 = getByte(hex, 0x05);
    this.Target3Type = getByte(hex, 0x06);
    this.Target4Type = getByte(hex, 0x07);
    this.Target3 = getByte(hex, 0x08);
    this.Target4 = getByte(hex, 0x09);
    this.Target3OrTarget4 = getBool(hex, 0x0A);
    this.Unknown8 = getByte(hex, 0x0B);
    this.Target1Type = getByte(hex, 0x0C);
    this.Target1 = getByte(hex, 0x0D);
    this.Target2Type = getByte(hex, 0x0E);
    this.Target2 = getByte(hex, 0x0F);
    this.Target1OrTarget2 = getBool(hex, 0x10);
    this.Unknown9 = getByte(hex, 0x11);
    this.Speed = getByte(hex, 0x12);
    this.Designation = getString(hex, 0x13, 16);
    
  }
  
  public toJSON(): object {
    return {
      Order: this.OrderLabel,
      Throttle: this.Throttle,
      Variable1: this.Variable1,
      Variable2: this.Variable2,
      Unknown6: this.Unknown6,
      Unknown7: this.Unknown7,
      Target3Type: this.Target3TypeLabel,
      Target4Type: this.Target4TypeLabel,
      Target3: this.Target3,
      Target4: this.Target4,
      Target3OrTarget4: this.Target3OrTarget4,
      Unknown8: this.Unknown8,
      Target1Type: this.Target1TypeLabel,
      Target1: this.Target1,
      Target2Type: this.Target2TypeLabel,
      Target2: this.Target2,
      Target1OrTarget2: this.Target1OrTarget2,
      Unknown9: this.Unknown9,
      Speed: this.Speed,
      Designation: this.Designation
    };
  }
  
  public toHexString(): string {
    let hex: string = '';
    let offset = 0;

    writeByte(hex, this.Order, 0x00);
    writeByte(hex, this.Throttle, 0x01);
    writeByte(hex, this.Variable1, 0x02);
    writeByte(hex, this.Variable2, 0x03);
    writeByte(hex, this.Unknown6, 0x04);
    writeByte(hex, this.Unknown7, 0x05);
    writeByte(hex, this.Target3Type, 0x06);
    writeByte(hex, this.Target4Type, 0x07);
    writeByte(hex, this.Target3, 0x08);
    writeByte(hex, this.Target4, 0x09);
    writeBool(hex, this.Target3OrTarget4, 0x0A);
    writeByte(hex, this.Unknown8, 0x0B);
    writeByte(hex, this.Target1Type, 0x0C);
    writeByte(hex, this.Target1, 0x0D);
    writeByte(hex, this.Target2Type, 0x0E);
    writeByte(hex, this.Target2, 0x0F);
    writeBool(hex, this.Target1OrTarget2, 0x10);
    writeByte(hex, this.Unknown9, 0x11);
    writeByte(hex, this.Speed, 0x12);
    writeString(hex, this.Designation, 0x13);

    return hex;
  }
  
  public get OrderLabel(): string {
    return Constants.ORDER[this.Order] || "Unknown";
  }

  public get Target3TypeLabel(): string {
    return Constants.VARIABLETYPE[this.Target3Type] || "Unknown";
  }

  public get Target4TypeLabel(): string {
    return Constants.VARIABLETYPE[this.Target4Type] || "Unknown";
  }

  public get Target1TypeLabel(): string {
    return Constants.VARIABLETYPE[this.Target1Type] || "Unknown";
  }

  public get Target2TypeLabel(): string {
    return Constants.VARIABLETYPE[this.Target2Type] || "Unknown";
  }
  
  public getLength(): number {
    return this.ORDERLENGTH;
  }
}