import { Byteable } from "../../../byteable";
import { Constants } from "../constants";
import { IMission, PyriteBase } from "../../../pyrite-base";
import { getByte, writeByte } from "../../../hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class TriggerBase extends PyriteBase implements Byteable {
  public readonly TRIGGERLENGTH: number = 4;
  public Condition: number;
  public VariableType: number;
  public Variable: number;
  public TriggerAmount: number;
  
  constructor(hex: ArrayBuffer, tie?: IMission) {
    super(hex, tie);
    this.beforeConstruct();
    let offset = 0;

    this.Condition = getByte(hex, 0x0);
    this.VariableType = getByte(hex, 0x1);
    this.Variable = getByte(hex, 0x2);
    this.TriggerAmount = getByte(hex, 0x3);
    
  }
  
  public toJSON(): object {
    return {
      Condition: this.ConditionLabel,
      VariableType: this.VariableTypeLabel,
      Variable: this.Variable,
      TriggerAmount: this.TriggerAmountLabel
    };
  }
  
  public toHexString(): string {
    let hex: string = '';
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