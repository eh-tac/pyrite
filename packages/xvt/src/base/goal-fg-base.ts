import { Byteable, IMission, PyriteBase } from '@pyrite/core';
import { Amount, Condition, Constants, GoalArgument } from '../constants';
import { getBool, getByte, getSByte, writeBool, writeByte, writeSByte } from '@pyrite/core';
export abstract class GoalFGBase extends PyriteBase implements Byteable {
  public readonly GOALFGLENGTH: number = 78;
  public GoalArgument: GoalArgument;
  public Condition: Condition;
  public Amount: Amount;
  public Points: number;
  public Enabled: boolean;
  public Team: number;
  public Unknown10: boolean;
  public Unknown11: boolean;
  public Unknown12: boolean;
  public Unknown13: number;
  public Unknown14: boolean;
  public Reserved: number; //(0) Unknown15
  public Unknown16: number;

  constructor(
    public hex: ArrayBuffer,
    public TIE?: IMission
  ) {
    super(hex, TIE!);
    this.beforeConstruct();

    this.GoalArgument = getByte(hex, 0x00) as GoalArgument;
    this.Condition = getByte(hex, 0x01) as Condition;
    this.Amount = getByte(hex, 0x02) as Amount;
    this.Points = getSByte(hex, 0x03);
    this.Enabled = getBool(hex, 0x04);
    this.Team = getByte(hex, 0x05);
    this.Unknown10 = getBool(hex, 0x06);
    this.Unknown11 = getBool(hex, 0x07);
    this.Unknown12 = getBool(hex, 0x08);
    this.Unknown13 = getByte(hex, 0x0b);
    this.Unknown14 = getBool(hex, 0x0c);
    this.Reserved = getByte(hex, 0x0d);
    this.Unknown16 = getByte(hex, 0x0e);
  }

  public toJSON(): Record<string, unknown> | string {
    return {
      GoalArgument: this.GoalArgumentLabel,
      Condition: this.ConditionLabel,
      Amount: this.AmountLabel,
      Points: this.Points,
      Enabled: this.Enabled,
      Team: this.Team,
      Unknown10: this.Unknown10,
      Unknown11: this.Unknown11,
      Unknown12: this.Unknown12,
      Unknown13: this.Unknown13,
      Unknown14: this.Unknown14,
      Reserved: this.Reserved,
      Unknown16: this.Unknown16
    };
  }

  public toHexBuffer(): ArrayBuffer {
    const hex: ArrayBuffer = new ArrayBuffer(this.getLength());

    writeByte(hex, this.GoalArgument, 0x00);
    writeByte(hex, this.Condition, 0x01);
    writeByte(hex, this.Amount, 0x02);
    writeSByte(hex, this.Points, 0x03);
    writeBool(hex, this.Enabled, 0x04);
    writeByte(hex, this.Team, 0x05);
    writeBool(hex, this.Unknown10, 0x06);
    writeBool(hex, this.Unknown11, 0x07);
    writeBool(hex, this.Unknown12, 0x08);
    writeByte(hex, this.Unknown13, 0x0b);
    writeBool(hex, this.Unknown14, 0x0c);
    writeByte(hex, this.Reserved, 0x0d);
    writeByte(hex, this.Unknown16, 0x0e);

    return hex;
  }

  public get GoalArgumentLabel(): string {
    return Constants.GOALARGUMENT[this.GoalArgument] || 'Unknown';
  }

  public get ConditionLabel(): string {
    return Constants.CONDITION[this.Condition] || 'Unknown';
  }

  public get AmountLabel(): string {
    return Constants.AMOUNT[this.Amount] || 'Unknown';
  }

  public getLength(): number {
    return this.GOALFGLENGTH;
  }
}
