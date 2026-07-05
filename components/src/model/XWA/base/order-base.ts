import { Byteable } from "../../../byteable";
import { Constants, Order, VariableType } from "../constants";
import { IMission, PyriteBase } from "../../../pyrite-base";
import { Waypt } from "../waypt";
import { getBool, getByte, writeBool, writeByte, writeObject } from "../../../hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class OrderBase extends PyriteBase implements Byteable {
  public readonly ORDERLENGTH: number = 148;
  public Order: Order;
  public Throttle: number;
  public Variables: number[]; //(contains Unknown9)
  public Target3Type: VariableType;
  public Target4Type: VariableType;
  public Target3: number;
  public Target4: number;
  public Target3OrTarget4: boolean;
  public Target1Type: VariableType;
  public Target1: number;
  public Target2Type: VariableType;
  public Target2: number;
  public Target1OrTarget2: boolean;
  public Speed: number;
  public Waypoints: Waypt[];

  constructor(hex: ArrayBuffer, TIE?: IMission) {
    super(hex, TIE!);
    this.beforeConstruct();
    let offset = 0;

    this.Order = getByte(hex, 0x00) as Order;
    this.Throttle = getByte(hex, 0x01);
    this.Variables = [];
    offset = 0x02;
    for (let i = 0; i < 4; i++) {
      const t = getByte(hex, offset);
      this.Variables.push(t);
      offset += 1;
    }
    this.Target3Type = getByte(hex, 0x06) as VariableType;
    this.Target4Type = getByte(hex, 0x07) as VariableType;
    this.Target3 = getByte(hex, 0x08);
    this.Target4 = getByte(hex, 0x09);
    this.Target3OrTarget4 = getBool(hex, 0x0a);
    this.Target1Type = getByte(hex, 0x0c) as VariableType;
    this.Target1 = getByte(hex, 0x0d);
    this.Target2Type = getByte(hex, 0x0e) as VariableType;
    this.Target2 = getByte(hex, 0x0f);
    this.Target1OrTarget2 = getBool(hex, 0x10);
    this.Speed = getByte(hex, 0x12);
    this.Waypoints = [];
    offset = 0x14;
    for (let i = 0; i < 8; i++) {
      const t = new Waypt(hex.slice(offset), this.TIE);
      this.Waypoints.push(t);
      offset += t.getLength();
    }
  }

  public toJSON(): Record<string, unknown> | string {
    return {
      Order: this.OrderLabel,
      Throttle: this.Throttle,
      Variables: this.Variables,
      Target3Type: this.Target3TypeLabel,
      Target4Type: this.Target4TypeLabel,
      Target3: this.Target3,
      Target4: this.Target4,
      Target3OrTarget4: this.Target3OrTarget4,
      Target1Type: this.Target1TypeLabel,
      Target1: this.Target1,
      Target2Type: this.Target2TypeLabel,
      Target2: this.Target2,
      Target1OrTarget2: this.Target1OrTarget2,
      Speed: this.Speed,
      Waypoints: this.Waypoints.map((t) => t.toJSON()),
    };
  }

  public toHexBuffer(): ArrayBuffer {
    const hex: ArrayBuffer = new ArrayBuffer(this.getLength());
    let offset = 0;

    writeByte(hex, this.Order, 0x00);
    writeByte(hex, this.Throttle, 0x01);
    offset = 0x02;
    for (let i = 0; i < this.Variables.length; i++) {
      const t = this.Variables[i];
      writeByte(hex, t, offset);
      offset += 1;
    }
    writeByte(hex, this.Target3Type, 0x06);
    writeByte(hex, this.Target4Type, 0x07);
    writeByte(hex, this.Target3, 0x08);
    writeByte(hex, this.Target4, 0x09);
    writeBool(hex, this.Target3OrTarget4, 0x0a);
    writeByte(hex, this.Target1Type, 0x0c);
    writeByte(hex, this.Target1, 0x0d);
    writeByte(hex, this.Target2Type, 0x0e);
    writeByte(hex, this.Target2, 0x0f);
    writeBool(hex, this.Target1OrTarget2, 0x10);
    writeByte(hex, this.Speed, 0x12);
    offset = 0x14;
    for (let i = 0; i < this.Waypoints.length; i++) {
      const t = this.Waypoints[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }

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
