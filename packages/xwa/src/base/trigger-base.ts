import type { Byteable, IMission} from '@pyrite/core';
import { PyriteBase } from '@pyrite/core';
import { getByte, writeByte } from '@pyrite/core';

import type { Amount, Condition, VariableType } from '../constants';
import { Constants } from '../constants';
export abstract class TriggerBase extends PyriteBase implements Byteable {
  public readonly TRIGGERLENGTH: number = 6;
  public Condition: Condition;
  public VariableType: VariableType;
  public Variable: number;
  public Amount: Amount;
  public Parameter: number;
  public Parameter2: number;

  constructor(hex: ArrayBuffer, TIE?: IMission) {
    super(hex, TIE!);
    this.beforeConstruct();

    this.Condition = getByte(hex, 0x0) as Condition;
    this.VariableType = getByte(hex, 0x1) as VariableType;
    this.Variable = getByte(hex, 0x2);
    this.Amount = getByte(hex, 0x3) as Amount;
    this.Parameter = getByte(hex, 0x4);
    this.Parameter2 = getByte(hex, 0x5);
  }

  public toJSON(): Record<string, unknown> | string {
    return {
      Condition: this.ConditionLabel,
      VariableType: this.VariableTypeLabel,
      Variable: this.Variable,
      Amount: this.AmountLabel,
      Parameter: this.Parameter,
      Parameter2: this.Parameter2
    };
  }

  public toHexBuffer(): ArrayBuffer {
    const hex: ArrayBuffer = new ArrayBuffer(this.getLength());

    writeByte(hex, this.Condition, 0x0);
    writeByte(hex, this.VariableType, 0x1);
    writeByte(hex, this.Variable, 0x2);
    writeByte(hex, this.Amount, 0x3);
    writeByte(hex, this.Parameter, 0x4);
    writeByte(hex, this.Parameter2, 0x5);

    return hex;
  }

  public get ConditionLabel(): string {
    return Constants.CONDITION[this.Condition] || 'Unknown';
  }

  public get VariableTypeLabel(): string {
    return Constants.VARIABLETYPE[this.VariableType] || 'Unknown';
  }

  public get AmountLabel(): string {
    return Constants.AMOUNT[this.Amount] || 'Unknown';
  }

  public getLength(): number {
    return this.TRIGGERLENGTH;
  }
}
