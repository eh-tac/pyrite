import { Byteable } from "../../../byteable";
import { Constants } from "../constants";
import { IMission, PyriteBase } from "../../../pyrite-base";
import { getInt, writeInt } from "../../../hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class MissionDataBase extends PyriteBase implements Byteable {
  public readonly MISSIONDATALENGTH: number = 36;
  public AttemptCount: number;
  public WinCount: number;
  public LossCount: number;
  public BestScore: number;
  public BestTime: number;
  public BestTimeSecond: number;
  public BestRating: number;
  public Something: number;
  public Other: number;
  
  constructor(hex: ArrayBuffer, tie?: IMission) {
    super(hex, tie);
    this.beforeConstruct();
    let offset = 0;

    this.AttemptCount = getInt(hex, 0x00);
    this.WinCount = getInt(hex, 0x04);
    this.LossCount = getInt(hex, 0x08);
    this.BestScore = getInt(hex, 0x0C);
    this.BestTime = getInt(hex, 0x10);
    this.BestTimeSecond = getInt(hex, 0x14);
    this.BestRating = getInt(hex, 0x18);
    this.Something = getInt(hex, 0x1C);
    this.Other = getInt(hex, 0x20);
    
  }
  
  public toJSON(): object {
    return {
      AttemptCount: this.AttemptCount,
      WinCount: this.WinCount,
      LossCount: this.LossCount,
      BestScore: this.BestScore,
      BestTime: this.BestTime,
      BestTimeSecond: this.BestTimeSecond,
      BestRating: this.BestRatingLabel,
      Something: this.Something,
      Other: this.Other
    };
  }
  
  public toHexString(): string {
    let hex: string = '';
    let offset = 0;

    writeInt(hex, this.AttemptCount, 0x00);
    writeInt(hex, this.WinCount, 0x04);
    writeInt(hex, this.LossCount, 0x08);
    writeInt(hex, this.BestScore, 0x0C);
    writeInt(hex, this.BestTime, 0x10);
    writeInt(hex, this.BestTimeSecond, 0x14);
    writeInt(hex, this.BestRating, 0x18);
    writeInt(hex, this.Something, 0x1C);
    writeInt(hex, this.Other, 0x20);

    return hex;
  }
  
  public get BestRatingLabel(): string {
    return Constants.BESTRATING[this.BestRating] || "Unknown";
  }
  
  public getLength(): number {
    return this.MISSIONDATALENGTH;
  }
}