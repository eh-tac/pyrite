import { Byteable } from "../../../byteable";
import { IMission, PyriteBase } from "../../../pyrite-base";
import { getInt, writeInt } from "../../../hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class PL2CampaignRecordBase extends PyriteBase implements Byteable {
  public readonly PL2CAMPAIGNRECORDLENGTH: number = 32;
  public IDNumber: number;
  public totalCountFlown: number;
  public isMissionCompleteWithoutCheat: number;
  public bestScore: number;
  public bestEvaluationBadge: number;
  public bestTimeAsSeconds: number;
  public isMissionComplete: number;
  public UIFrameTimerHelper: number;
  
  constructor(hex: ArrayBuffer, tie?: IMission) {
    super(hex, tie);
    this.beforeConstruct();
    let offset = 0;

    this.IDNumber = getInt(hex, 0x0000);
    this.totalCountFlown = getInt(hex, 0x0004);
    this.isMissionCompleteWithoutCheat = getInt(hex, 0x0008);
    this.bestScore = getInt(hex, 0x000C);
    this.bestEvaluationBadge = getInt(hex, 0x0010);
    this.bestTimeAsSeconds = getInt(hex, 0x0014);
    this.isMissionComplete = getInt(hex, 0x0018);
    this.UIFrameTimerHelper = getInt(hex, 0x001C);
    
  }
  
  public toJSON(): object {
    return {
      IDNumber: this.IDNumber,
      totalCountFlown: this.totalCountFlown,
      isMissionCompleteWithoutCheat: this.isMissionCompleteWithoutCheat,
      bestScore: this.bestScore,
      bestEvaluationBadge: this.bestEvaluationBadge,
      bestTimeAsSeconds: this.bestTimeAsSeconds,
      isMissionComplete: this.isMissionComplete,
      UIFrameTimerHelper: this.UIFrameTimerHelper
    };
  }
  
  public toHexString(): string {
    let hex: string = '';
    let offset = 0;

    writeInt(hex, this.IDNumber, 0x0000);
    writeInt(hex, this.totalCountFlown, 0x0004);
    writeInt(hex, this.isMissionCompleteWithoutCheat, 0x0008);
    writeInt(hex, this.bestScore, 0x000C);
    writeInt(hex, this.bestEvaluationBadge, 0x0010);
    writeInt(hex, this.bestTimeAsSeconds, 0x0014);
    writeInt(hex, this.isMissionComplete, 0x0018);
    writeInt(hex, this.UIFrameTimerHelper, 0x001C);

    return hex;
  }
  
  
  public getLength(): number {
    return this.PL2CAMPAIGNRECORDLENGTH;
  }
}