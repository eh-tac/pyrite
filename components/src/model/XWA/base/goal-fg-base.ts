import { Byteable } from "../../../byteable";
import { IMission, PyriteBase } from "../../../pyrite-base";
import { getBool, getByte, getSByte, writeBool, writeByte, writeSByte } from "../../../hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class GoalFGBase extends PyriteBase implements Byteable {
  public readonly GOALFGLENGTH: number = 80;
  public Argument: number;
  public Condition: number;
  public Amount: number;
  public Points: number;
  public Enabled: boolean;
  public Team: number;
  public Unknown42: number;
  public Parameter: number; //or Goal time limit depending on order
  public ActiveSequence: number;
  public Unknown15: boolean; //** retains FG Unknown numbering
  
  constructor(hex: ArrayBuffer, tie?: IMission) {
    super(hex, tie);
    this.beforeConstruct();
    let offset = 0;

    this.Argument = getByte(hex, 0x00);
    this.Condition = getByte(hex, 0x01);
    this.Amount = getByte(hex, 0x02);
    this.Points = getSByte(hex, 0x03);
    this.Enabled = getBool(hex, 0x04);
    this.Team = getByte(hex, 0x05);
    this.Unknown42 = getByte(hex, 0x0D);
    this.Parameter = getByte(hex, 0x0E);
    this.ActiveSequence = getByte(hex, 0x0F);
    this.Unknown15 = getBool(hex, 0x4F);
    
  }
  
  public toJSON(): object {
    return {
      Argument: this.Argument,
      Condition: this.Condition,
      Amount: this.Amount,
      Points: this.Points,
      Enabled: this.Enabled,
      Team: this.Team,
      Unknown42: this.Unknown42,
      Parameter: this.Parameter,
      ActiveSequence: this.ActiveSequence,
      Unknown15: this.Unknown15
    };
  }
  
  public toHexString(): string {
    let hex: string = '';
    let offset = 0;

    writeByte(hex, this.Argument, 0x00);
    writeByte(hex, this.Condition, 0x01);
    writeByte(hex, this.Amount, 0x02);
    writeSByte(hex, this.Points, 0x03);
    writeBool(hex, this.Enabled, 0x04);
    writeByte(hex, this.Team, 0x05);
    writeByte(hex, this.Unknown42, 0x0D);
    writeByte(hex, this.Parameter, 0x0E);
    writeByte(hex, this.ActiveSequence, 0x0F);
    writeBool(hex, this.Unknown15, 0x4F);

    return hex;
  }
  
  
  public getLength(): number {
    return this.GOALFGLENGTH;
  }
}