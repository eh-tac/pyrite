import { Byteable } from "../../../byteable";
import { Constants } from "../constants";
import { IMission, PyriteBase } from "../../../pyrite-base";
import { getByte, writeByte } from "../../../hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class TriggerBase extends PyriteBase implements Byteable {
  public readonly TRIGGERLENGTH: number = 6;
  public Condition: number;
  public VariableType: number;
  public Variable: number;
  public Amount: number;
  public Parameter: number;
  public Parameter2: number;
  
  constructor(hex: ArrayBuffer, tie?: IMission) {
    super(hex, tie);
    this.beforeConstruct();
    let offset = 0;

    this.Condition = getByte(hex, 0x0);
    this.VariableType = getByte(hex, 0x1);
    this.Variable = getByte(hex, 0x2);
    this.Amount = getByte(hex, 0x3);
    this.Parameter = getByte(hex, 0x4);
    this.Parameter2 = getByte(hex, 0x5);
    
  }
  
  public toJSON(): object {
    return {
      Condition: this.ConditionLabel,
      VariableType: this.VariableTypeLabel,
      Variable: this.Variable,
      Amount: this.AmountLabel,
      Parameter: this.Parameter,
      Parameter2: this.Parameter2
    };
  }
  
  public toHexString(): string {
    let hex: string = '';
    let offset = 0;

    writeByte(hex, this.Condition, 0x0);
    writeByte(hex, this.VariableType, 0x1);
    writeByte(hex, this.Variable, 0x2);
    writeByte(hex, this.Amount, 0x3);
    writeByte(hex, this.Parameter, 0x4);
    writeByte(hex, this.Parameter2, 0x5);

    return hex;
  }
  
  public get ConditionLabel(): string {
    return Constants.CONDITION[this.Condition] || "Unknown";
  }

  public get VariableTypeLabel(): string {
    return Constants.VARIABLETYPE[this.VariableType] || "Unknown";
  }

  public get AmountLabel(): string {
    return Constants.AMOUNT[this.Amount] || "Unknown";
  }
  
  public getLength(): number {
    return this.TRIGGERLENGTH;
  }
}