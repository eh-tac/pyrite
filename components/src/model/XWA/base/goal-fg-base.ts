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
  public EnabledForTeam: boolean[];
  public Parameter: number; //or Goal time limit depending on order
  public ActiveSequence: number;

  constructor(hex: ArrayBuffer, TIE?: IMission) {
    super(hex, TIE!);
    this.beforeConstruct();
    let offset = 0;

    this.Argument = getByte(hex, 0x00);
    this.Condition = getByte(hex, 0x01);
    this.Amount = getByte(hex, 0x02);
    this.Points = getSByte(hex, 0x03);
    this.EnabledForTeam = [];
    offset = 0x04;
    for (let i = 0; i < 10; i++) {
      const t = getBool(hex, offset);
      this.EnabledForTeam.push(t);
      offset += 1;
    }
    this.Parameter = getByte(hex, 0x0e);
    this.ActiveSequence = getByte(hex, 0x0f);
  }

  public toJSON(): Record<string, unknown> | string {
    return {
      Argument: this.Argument,
      Condition: this.Condition,
      Amount: this.Amount,
      Points: this.Points,
      EnabledForTeam: this.EnabledForTeam,
      Parameter: this.Parameter,
      ActiveSequence: this.ActiveSequence,
    };
  }

  public toHexBuffer(): ArrayBuffer {
    const hex: ArrayBuffer = new ArrayBuffer(this.getLength());
    let offset = 0;

    writeByte(hex, this.Argument, 0x00);
    writeByte(hex, this.Condition, 0x01);
    writeByte(hex, this.Amount, 0x02);
    writeSByte(hex, this.Points, 0x03);
    offset = 0x04;
    for (let i = 0; i < this.EnabledForTeam.length; i++) {
      const t = this.EnabledForTeam[i];
      writeBool(hex, t, offset);
      offset += 1;
    }
    writeByte(hex, this.Parameter, 0x0e);
    writeByte(hex, this.ActiveSequence, 0x0f);

    return hex;
  }

  public getLength(): number {
    return this.GOALFGLENGTH;
  }
}
