import { Byteable } from "../../../core/src/byteable";
import { IMission, PyriteBase } from "../../../core/src/pyrite-base";
import { getInt, writeInt } from "../../../core/src/hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class PLTBattleSPRecordBase extends PyriteBase implements Byteable {
  public readonly PLTBATTLESPRECORDLENGTH: number = 36;
  public unknown0x0: number;
  public totalCountFlown: number;
  public totalCountVictory: number;
  public totalCountFailure: number;
  public totalCount10MissionMarathonUNK: number;
  public bestScore: number;
  public unknown0x18: number;
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
    this.bestEvaluationMedal = getInt(hex, 0x001C);
    this.bestVictoryMargin = getInt(hex, 0x0020);
    
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
    writeInt(hex, this.bestEvaluationMedal, 0x001C);
    writeInt(hex, this.bestVictoryMargin, 0x0020);

    return hex;
  }
  
  
  public getLength(): number {
    return this.PLTBATTLESPRECORDLENGTH;
  }
}