import { Byteable } from "../../../byteable";
import { IMission, PyriteBase } from "../../../pyrite-base";
import { getInt, writeInt } from "../../../hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class PLTMissionSPRecordBase extends PyriteBase implements Byteable {
  public readonly PLTMISSIONSPRECORDLENGTH: number = 36;
  public unknown0x0: number;
  public totalCountFlown: number;
  public totalCountVictory: number;
  public totalCountFailure: number;
  public bestScore: number;
  public bestTimeAsSeconds: number;
  public bestFinishRank: number;
  public bestEvaluationBadge: number;
  public bestWinningMargin: number;
  
  constructor(hex: ArrayBuffer, tie?: IMission) {
    super(hex, tie);
    this.beforeConstruct();
    let offset = 0;

    this.unknown0x0 = getInt(hex, 0x0000);
    this.totalCountFlown = getInt(hex, 0x0004);
    this.totalCountVictory = getInt(hex, 0x0008);
    this.totalCountFailure = getInt(hex, 0x000C);
    this.bestScore = getInt(hex, 0x0010);
    this.bestTimeAsSeconds = getInt(hex, 0x0014);
    this.bestFinishRank = getInt(hex, 0x0018);
    this.bestEvaluationBadge = getInt(hex, 0x001C);
    this.bestWinningMargin = getInt(hex, 0x0020);
    
  }
  
  public toJSON(): object {
    return {
      unknown0x0: this.unknown0x0,
      totalCountFlown: this.totalCountFlown,
      totalCountVictory: this.totalCountVictory,
      totalCountFailure: this.totalCountFailure,
      bestScore: this.bestScore,
      bestTimeAsSeconds: this.bestTimeAsSeconds,
      bestFinishRank: this.bestFinishRank,
      bestEvaluationBadge: this.bestEvaluationBadge,
      bestWinningMargin: this.bestWinningMargin
    };
  }
  
  public toHexString(): string {
    let hex: string = '';
    let offset = 0;

    writeInt(hex, this.unknown0x0, 0x0000);
    writeInt(hex, this.totalCountFlown, 0x0004);
    writeInt(hex, this.totalCountVictory, 0x0008);
    writeInt(hex, this.totalCountFailure, 0x000C);
    writeInt(hex, this.bestScore, 0x0010);
    writeInt(hex, this.bestTimeAsSeconds, 0x0014);
    writeInt(hex, this.bestFinishRank, 0x0018);
    writeInt(hex, this.bestEvaluationBadge, 0x001C);
    writeInt(hex, this.bestWinningMargin, 0x0020);

    return hex;
  }
  
  
  public getLength(): number {
    return this.PLTMISSIONSPRECORDLENGTH;
  }
}