import { Byteable } from "../../byteable";
import { IMission, PyriteBase } from "../../pyrite-base";
import { Constants } from "../constants";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class GoalFGBase extends PyriteBase implements Byteable {
  public static GOALFGLENGTH:number = 2;
  public Condition:number;
  public GoalAmount:number;

  constructor(hex: ArrayBuffer, tie?: any){
      super(hex, tie);
  }

  public get ConditionLabel(): string {
    return Constants.CONDITION[this.Condition] || "Unknown";
  }

  public get GoalAmountLabel(): string {
    return Constants.GOALAMOUNT[this.GoalAmount] || "Unknown";
  }
}