import { Byteable } from "../../byteable";
import { IMission, PyriteBase } from "../../pyrite-base";
import { Constants } from "../constants";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class OrderBase extends PyriteBase implements Byteable {
  public static ORDERLENGTH:number = 18;
  public Order:number;
  public Throttle:number;
  public Variable1:number;
  public Variable2:number;
  public Unknown18:number;
  public Target3Type:number;
  public Target4Type:number;
  public Target3:number;
  public Target4:number;
  public Target3OrTarget4:boolean;
  public Target1Type:number;
  public Target1:number;
  public Target2Type:number;
  public Target2:number;
  public Target1OrTarget2:boolean;

  constructor(hex: ArrayBuffer, tie?: any){
      super(hex, tie);
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
}