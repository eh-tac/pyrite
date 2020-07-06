import { Byteable } from "../../byteable";
import { IMission, PyriteBase } from "../../pyrite-base";
import { Constants } from "../constants";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class TriggerBase extends PyriteBase implements Byteable {
  public static TRIGGERLENGTH:number = 4;
  public Condition:number;
  public VariableType:number;
  public Variable:number;
  public TriggerAmount:number;

  constructor(hex: ArrayBuffer, tie?: any){
      super(hex, tie);
  }

  public get ConditionLabel(): string {
    return Constants.CONDITION[this.Condition] || "Unknown";
  }

  public get VariableTypeLabel(): string {
    return Constants.VARIABLETYPE[this.VariableType] || "Unknown";
  }

  public get TriggerAmountLabel(): string {
    return Constants.TRIGGERAMOUNT[this.TriggerAmount] || "Unknown";
  }
}