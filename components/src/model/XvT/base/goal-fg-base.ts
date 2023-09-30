import { Byteable } from "../../../byteable";
import { Constants } from "../constants";
import { IMission, PyriteBase } from "../../../pyrite-base";
import { getBool, getByte, getSByte, writeBool, writeByte, writeSByte } from "../../../hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class GoalFGBase extends PyriteBase implements Byteable {
  public readonly GOALFGLENGTH: number = 78;
  public GoalArgument: number;
  public Condition: number;
  public Amount: number;
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
  
  constructor(hex: ArrayBuffer, tie?: IMission) {
    super(hex, tie);
    this.beforeConstruct();
    let offset = 0;

    this.GoalArgument = getByte(hex, 0x00);
    this.Condition = getByte(hex, 0x01);
    this.Amount = getByte(hex, 0x02);
    this.Points = getSByte(hex, 0x03);
    this.Enabled = getBool(hex, 0x04);
    this.Team = getByte(hex, 0x05);
    this.Unknown10 = getBool(hex, 0x06);
    this.Unknown11 = getBool(hex, 0x07);
    this.Unknown12 = getBool(hex, 0x08);
    this.Unknown13 = getByte(hex, 0x0B);
    this.Unknown14 = getBool(hex, 0x0C);
    this.Reserved = getByte(hex, 0x0D);
    this.Unknown16 = getByte(hex, 0x0E);
    
  }
  
  public toJSON(): object {
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
  
  public toHexString(): string {
    let hex: string = '';
    let offset = 0;

    writeByte(hex, this.GoalArgument, 0x00);
    writeByte(hex, this.Condition, 0x01);
    writeByte(hex, this.Amount, 0x02);
    writeSByte(hex, this.Points, 0x03);
    writeBool(hex, this.Enabled, 0x04);
    writeByte(hex, this.Team, 0x05);
    writeBool(hex, this.Unknown10, 0x06);
    writeBool(hex, this.Unknown11, 0x07);
    writeBool(hex, this.Unknown12, 0x08);
    writeByte(hex, this.Unknown13, 0x0B);
    writeBool(hex, this.Unknown14, 0x0C);
    writeByte(hex, this.Reserved, 0x0D);
    writeByte(hex, this.Unknown16, 0x0E);

    return hex;
  }
  
  public get GoalArgumentLabel(): string {
    return Constants.GOALARGUMENT[this.GoalArgument] || "Unknown";
  }

  public get ConditionLabel(): string {
    return Constants.CONDITION[this.Condition] || "Unknown";
  }

  public get AmountLabel(): string {
    return Constants.AMOUNT[this.Amount] || "Unknown";
  }
  
  public getLength(): number {
    return this.GOALFGLENGTH;
  }
}