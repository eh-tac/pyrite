import { Byteable } from "../../../byteable";
import { Constants } from "../constants";
import { IMission, PyriteBase } from "../../../pyrite-base";
import { getByte, writeByte } from "../../../hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class GoalFGBase extends PyriteBase implements Byteable {
  public readonly GOALFGLENGTH: number = 2;
  public Condition: number;
  public GoalAmount: number;
  
  constructor(hex: ArrayBuffer, tie?: IMission) {
    super(hex, tie);
    this.beforeConstruct();
    let offset = 0;

    this.Condition = getByte(hex, 0x0);
    this.GoalAmount = getByte(hex, 0x1);
    
  }
  
  public toJSON(): object {
    return {
      Condition: this.ConditionLabel,
      GoalAmount: this.GoalAmountLabel
    };
  }
  
  public toHexString(): string {
    let hex: string = '';
    let offset = 0;

    writeByte(hex, this.Condition, 0x0);
    writeByte(hex, this.GoalAmount, 0x1);

    return hex;
  }
  
  public get ConditionLabel(): string {
    return Constants.CONDITION[this.Condition] || "Unknown";
  }

  public get GoalAmountLabel(): string {
    return Constants.GOALAMOUNT[this.GoalAmount] || "Unknown";
  }
  
  public getLength(): number {
    return this.GOALFGLENGTH;
  }
}