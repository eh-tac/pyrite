import { Byteable } from "../../../byteable";
import { IMission, PyriteBase } from "../../../pyrite-base";
import { getInt, writeInt } from "../../../hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class PLTMissionMPRecordBase extends PyriteBase implements Byteable {
  public readonly PLTMISSIONMPRECORDLENGTH: number = 48;
  public unknown0x0: number;
  public totalCountFlown: number;
  public totalCountFinishedFirst: number;
  public totalCountFinishedSecond: number;
  public totalCountFinishedThird: number;
  public totalCountVictory: number;
  public totalCountFailure: number;
  public bestScore: number;
  public bestTimeAsSeconds: number;
  public bestFinishPlace: number;
  public bestEvaluationBadge: number;
  public bestWinningMargin: number;
  
  constructor(hex: ArrayBuffer, tie?: IMission) {
    super(hex, tie);
    this.beforeConstruct();
    let offset = 0;

    this.unknown0x0 = getInt(hex, 0x0000);
    this.totalCountFlown = getInt(hex, 0x0004);
    this.totalCountFinishedFirst = getInt(hex, 0x0008);
    this.totalCountFinishedSecond = getInt(hex, 0x000C);
    this.totalCountFinishedThird = getInt(hex, 0x0010);
    this.totalCountVictory = getInt(hex, 0x0014);
    this.totalCountFailure = getInt(hex, 0x0018);
    this.bestScore = getInt(hex, 0x001C);
    this.bestTimeAsSeconds = getInt(hex, 0x0020);
    this.bestFinishPlace = getInt(hex, 0x0024);
    this.bestEvaluationBadge = getInt(hex, 0x0028);
    this.bestWinningMargin = getInt(hex, 0x002C);
    
  }
  
  public toJSON(): object {
    return {
      unknown0x0: this.unknown0x0,
      totalCountFlown: this.totalCountFlown,
      totalCountFinishedFirst: this.totalCountFinishedFirst,
      totalCountFinishedSecond: this.totalCountFinishedSecond,
      totalCountFinishedThird: this.totalCountFinishedThird,
      totalCountVictory: this.totalCountVictory,
      totalCountFailure: this.totalCountFailure,
      bestScore: this.bestScore,
      bestTimeAsSeconds: this.bestTimeAsSeconds,
      bestFinishPlace: this.bestFinishPlace,
      bestEvaluationBadge: this.bestEvaluationBadge,
      bestWinningMargin: this.bestWinningMargin
    };
  }
  
  public toHexString(): string {
    let hex: string = '';
    let offset = 0;

    writeInt(hex, this.unknown0x0, 0x0000);
    writeInt(hex, this.totalCountFlown, 0x0004);
    writeInt(hex, this.totalCountFinishedFirst, 0x0008);
    writeInt(hex, this.totalCountFinishedSecond, 0x000C);
    writeInt(hex, this.totalCountFinishedThird, 0x0010);
    writeInt(hex, this.totalCountVictory, 0x0014);
    writeInt(hex, this.totalCountFailure, 0x0018);
    writeInt(hex, this.bestScore, 0x001C);
    writeInt(hex, this.bestTimeAsSeconds, 0x0020);
    writeInt(hex, this.bestFinishPlace, 0x0024);
    writeInt(hex, this.bestEvaluationBadge, 0x0028);
    writeInt(hex, this.bestWinningMargin, 0x002C);

    return hex;
  }
  
  
  public getLength(): number {
    return this.PLTMISSIONMPRECORDLENGTH;
  }
}