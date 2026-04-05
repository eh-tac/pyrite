import { Byteable } from "../../../byteable";
import { IMission, PyriteBase } from "../../../pyrite-base";
import { getInt, writeInt } from "../../../hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class PLTBattleMPRecordBase extends PyriteBase implements Byteable {
  public readonly PLTBATTLEMPRECORDLENGTH: number = 40;
  public unknown0x0: number;
  public totalCountFlown: number;
  public totalCountVictory: number;
  public totalCountFailure: number;
  public totalCount10MissionMarathonUNK: number;
  public bestScore: number;
  public unknown0x18: number;
  public unknown0x1C: number;
  public bestEvaluationMedal: number;
  public bestVictoryMargin: number;
  
  constructor(hex: ArrayBuffer, tie?: IMission) {
    super(hex, tie);
    this.beforeConstruct();
    let offset = 0;

    this.unknown0x0 = getInt(hex, 0x0000);
    this.totalCountFlown = getInt(hex, 0x0004);
    this.totalCountVictory = getInt(hex, 0x0008);
    this.totalCountFailure = getInt(hex, 0x000C);
    this.totalCount10MissionMarathonUNK = getInt(hex, 0x0010);
    this.bestScore = getInt(hex, 0x0014);
    this.unknown0x18 = getInt(hex, 0x0018);
    this.unknown0x1C = getInt(hex, 0x001C);
    this.bestEvaluationMedal = getInt(hex, 0x0020);
    this.bestVictoryMargin = getInt(hex, 0x0024);
    
  }
  
  public toJSON(): object {
    return {
      unknown0x0: this.unknown0x0,
      totalCountFlown: this.totalCountFlown,
      totalCountVictory: this.totalCountVictory,
      totalCountFailure: this.totalCountFailure,
      totalCount10MissionMarathonUNK: this.totalCount10MissionMarathonUNK,
      bestScore: this.bestScore,
      unknown0x18: this.unknown0x18,
      unknown0x1C: this.unknown0x1C,
      bestEvaluationMedal: this.bestEvaluationMedal,
      bestVictoryMargin: this.bestVictoryMargin
    };
  }
  
  public toHexString(): string {
    let hex: string = '';
    let offset = 0;

    writeInt(hex, this.unknown0x0, 0x0000);
    writeInt(hex, this.totalCountFlown, 0x0004);
    writeInt(hex, this.totalCountVictory, 0x0008);
    writeInt(hex, this.totalCountFailure, 0x000C);
    writeInt(hex, this.totalCount10MissionMarathonUNK, 0x0010);
    writeInt(hex, this.bestScore, 0x0014);
    writeInt(hex, this.unknown0x18, 0x0018);
    writeInt(hex, this.unknown0x1C, 0x001C);
    writeInt(hex, this.bestEvaluationMedal, 0x0020);
    writeInt(hex, this.bestVictoryMargin, 0x0024);

    return hex;
  }
  
  
  public getLength(): number {
    return this.PLTBATTLEMPRECORDLENGTH;
  }
}