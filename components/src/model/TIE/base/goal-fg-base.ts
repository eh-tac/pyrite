import { Byteable } from "../../../byteable";
import { Condition, Constants, GoalAmount } from "../constants";
import { IMission, PyriteBase } from "../../../pyrite-base";
import { getByte, writeByte } from "../../../hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class GoalFGBase extends PyriteBase implements Byteable {
  public readonly GOALFGLENGTH: number = 2;
  public Condition: Condition;
  public GoalAmount: GoalAmount;

  constructor(hex: ArrayBuffer, TIE?: IMission) {
    super(hex, TIE!);
    this.beforeConstruct();
    let offset = 0;

    this.Condition = getByte(hex, 0x0) as Condition;
    this.GoalAmount = getByte(hex, 0x1) as GoalAmount;
  }

  public toJSON(): Record<string, unknown> | string {
    return {
      Condition: this.ConditionLabel,
      GoalAmount: this.GoalAmountLabel,
    };
  }

  public toHexBuffer(): ArrayBuffer {
    const hex: ArrayBuffer = new ArrayBuffer(this.getLength());
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
