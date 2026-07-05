import type { Byteable, IMission} from '@pyrite/core';
import { PyriteBase } from '@pyrite/core';
import { getInt, writeInt } from '@pyrite/core';
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

  constructor(hex: ArrayBuffer, TIE?: IMission) {
    super(hex, TIE!);
    this.beforeConstruct();

    this.unknown0x0 = getInt(hex, 0x0000);
    this.totalCountFlown = getInt(hex, 0x0004);
    this.totalCountVictory = getInt(hex, 0x0008);
    this.totalCountFailure = getInt(hex, 0x000c);
    this.bestScore = getInt(hex, 0x0010);
    this.bestTimeAsSeconds = getInt(hex, 0x0014);
    this.bestFinishRank = getInt(hex, 0x0018);
    this.bestEvaluationBadge = getInt(hex, 0x001c);
    this.bestWinningMargin = getInt(hex, 0x0020);
  }

  public toJSON(): Record<string, unknown> | string {
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

  public toHexBuffer(): ArrayBuffer {
    const hex: ArrayBuffer = new ArrayBuffer(this.getLength());

    writeInt(hex, this.unknown0x0, 0x0000);
    writeInt(hex, this.totalCountFlown, 0x0004);
    writeInt(hex, this.totalCountVictory, 0x0008);
    writeInt(hex, this.totalCountFailure, 0x000c);
    writeInt(hex, this.bestScore, 0x0010);
    writeInt(hex, this.bestTimeAsSeconds, 0x0014);
    writeInt(hex, this.bestFinishRank, 0x0018);
    writeInt(hex, this.bestEvaluationBadge, 0x001c);
    writeInt(hex, this.bestWinningMargin, 0x0020);

    return hex;
  }

  public getLength(): number {
    return this.PLTMISSIONSPRECORDLENGTH;
  }
}
