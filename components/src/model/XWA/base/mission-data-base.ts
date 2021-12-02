import { Byteable } from "../../../byteable";
import { IMission, PyriteBase } from "../../../pyrite-base";
import { getInt, writeInt } from "../../../hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class MissionDataBase extends PyriteBase implements Byteable {
  public readonly MISSIONDATALENGTH: number = 48;
  public UnkA: number;
  public AttemptCount: number;
  public UnkB: number;
  public UnkC: number;
  public UnkD: number;
  public WinCount: number;
  public UnkE: number;
  public Score: number;
  public Time: number;
  public UnkF: number;
  public UnkG: number;
  public BonusScoreTen: number;
  
  constructor(hex: ArrayBuffer, tie?: IMission) {
    super(hex, tie);
    this.beforeConstruct();
    let offset = 0;

    this.UnkA = getInt(hex, 0x00);
    this.AttemptCount = getInt(hex, 0x04);
    this.UnkB = getInt(hex, 0x08);
    this.UnkC = getInt(hex, 0x0C);
    this.UnkD = getInt(hex, 0x10);
    this.WinCount = getInt(hex, 0x14);
    this.UnkE = getInt(hex, 0x18);
    this.Score = getInt(hex, 0x1C);
    this.Time = getInt(hex, 0x20);
    this.UnkF = getInt(hex, 0x24);
    this.UnkG = getInt(hex, 0x28);
    this.BonusScoreTen = getInt(hex, 0x2C);
    
  }
  
  public toJSON(): object {
    return {
      UnkA: this.UnkA,
      AttemptCount: this.AttemptCount,
      UnkB: this.UnkB,
      UnkC: this.UnkC,
      UnkD: this.UnkD,
      WinCount: this.WinCount,
      UnkE: this.UnkE,
      Score: this.Score,
      Time: this.Time,
      UnkF: this.UnkF,
      UnkG: this.UnkG,
      BonusScoreTen: this.BonusScoreTen
    };
  }
  
  public toHexString(): string {
    let hex: string = '';
    let offset = 0;

    writeInt(hex, this.UnkA, 0x00);
    writeInt(hex, this.AttemptCount, 0x04);
    writeInt(hex, this.UnkB, 0x08);
    writeInt(hex, this.UnkC, 0x0C);
    writeInt(hex, this.UnkD, 0x10);
    writeInt(hex, this.WinCount, 0x14);
    writeInt(hex, this.UnkE, 0x18);
    writeInt(hex, this.Score, 0x1C);
    writeInt(hex, this.Time, 0x20);
    writeInt(hex, this.UnkF, 0x24);
    writeInt(hex, this.UnkG, 0x28);
    writeInt(hex, this.BonusScoreTen, 0x2C);

    return hex;
  }
  
  
  public getLength(): number {
    return this.MISSIONDATALENGTH;
  }
}