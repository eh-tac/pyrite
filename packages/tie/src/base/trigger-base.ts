import { Byteable } from "../../../byteable";
import { Condition, Constants, TriggerAmount, VariableType } from "../constants";
import { IMission, PyriteBase } from "../../../pyrite-base";
import { getByte, writeByte } from "../../../hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class TriggerBase extends PyriteBase implements Byteable {
  public readonly TRIGGERLENGTH: number = 4;
  public Condition: Condition;
  public VariableType: VariableType;
  public Variable: number;
  public TriggerAmount: TriggerAmount;
  
  constructor(hex: ArrayBuffer, TIE?: IMission) {
    super(hex, TIE!);
    this.beforeConstruct();
    let offset = 0;

    this.Condition = getByte(hex, 0x0) as Condition;
    this.VariableType = getByte(hex, 0x1) as VariableType;
    this.Variable = getByte(hex, 0x2);
    this.TriggerAmount = getByte(hex, 0x3) as TriggerAmount;
    
  }
  
  public toJSON(): Record<string, unknown> | string {
    return {
      Condition: this.ConditionLabel,
      VariableType: this.VariableTypeLabel,
      Variable: this.Variable,
      TriggerAmount: this.TriggerAmountLabel,
    };
  }
  
  public toHexBuffer(): ArrayBuffer {
    const hex: ArrayBuffer = new ArrayBuffer(this.getLength());
    let offset = 0;

    writeByte(hex, this.Condition, 0x0);
    writeByte(hex, this.VariableType, 0x1);
    writeByte(hex, this.Variable, 0x2);
    writeByte(hex, this.TriggerAmount, 0x3);

    return hex;
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
  
  public getLength(): number {
    return this.TRIGGERLENGTH;
  }
}