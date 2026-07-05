import type { Byteable, IMission} from '@pyrite/core';
import { PyriteBase } from '@pyrite/core';
import { getInt, writeInt } from '@pyrite/core';
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

  constructor(hex: ArrayBuffer, TIE?: IMission) {
    super(hex, TIE!);
    this.beforeConstruct();

    this.IDNumber = getInt(hex, 0x0000);
    this.totalCountFlown = getInt(hex, 0x0004);
    this.isMissionCompleteWithoutCheat = getInt(hex, 0x0008);
    this.bestScore = getInt(hex, 0x000c);
    this.bestEvaluationBadge = getInt(hex, 0x0010);
    this.bestTimeAsSeconds = getInt(hex, 0x0014);
    this.isMissionComplete = getInt(hex, 0x0018);
    this.UIFrameTimerHelper = getInt(hex, 0x001c);
  }

  public toJSON(): Record<string, unknown> | string {
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

  public toHexBuffer(): ArrayBuffer {
    const hex: ArrayBuffer = new ArrayBuffer(this.getLength());

    writeInt(hex, this.IDNumber, 0x0000);
    writeInt(hex, this.totalCountFlown, 0x0004);
    writeInt(hex, this.isMissionCompleteWithoutCheat, 0x0008);
    writeInt(hex, this.bestScore, 0x000c);
    writeInt(hex, this.bestEvaluationBadge, 0x0010);
    writeInt(hex, this.bestTimeAsSeconds, 0x0014);
    writeInt(hex, this.isMissionComplete, 0x0018);
    writeInt(hex, this.UIFrameTimerHelper, 0x001c);

    return hex;
  }

  public getLength(): number {
    return this.PL2CAMPAIGNRECORDLENGTH;
  }
}
