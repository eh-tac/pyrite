import type { Byteable, IMission} from '@pyrite/core';
import { PyriteBase } from '@pyrite/core';
import { getInt, writeInt } from '@pyrite/core';

import type { BestRating} from '../constants';
import { Constants } from '../constants';
export abstract class MissionDataBase extends PyriteBase implements Byteable {
  public readonly MISSIONDATALENGTH: number = 36;
  public AttemptCount: number;
  public WinCount: number;
  public LossCount: number;
  public BestScore: number;
  public BestTime: number;
  public BestTimeSecond: number;
  public BestRating: BestRating;
  public Something: number;
  public Other: number;

  constructor(hex: ArrayBuffer, TIE?: IMission) {
    super(hex, TIE!);
    this.beforeConstruct();

    this.AttemptCount = getInt(hex, 0x00);
    this.WinCount = getInt(hex, 0x04);
    this.LossCount = getInt(hex, 0x08);
    this.BestScore = getInt(hex, 0x0c);
    this.BestTime = getInt(hex, 0x10);
    this.BestTimeSecond = getInt(hex, 0x14);
    this.BestRating = getInt(hex, 0x18) as BestRating;
    this.Something = getInt(hex, 0x1c);
    this.Other = getInt(hex, 0x20);
  }

  public toJSON(): Record<string, unknown> | string {
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

  public toHexBuffer(): ArrayBuffer {
    const hex: ArrayBuffer = new ArrayBuffer(this.getLength());

    writeInt(hex, this.AttemptCount, 0x00);
    writeInt(hex, this.WinCount, 0x04);
    writeInt(hex, this.LossCount, 0x08);
    writeInt(hex, this.BestScore, 0x0c);
    writeInt(hex, this.BestTime, 0x10);
    writeInt(hex, this.BestTimeSecond, 0x14);
    writeInt(hex, this.BestRating, 0x18);
    writeInt(hex, this.Something, 0x1c);
    writeInt(hex, this.Other, 0x20);

    return hex;
  }

  public get BestRatingLabel(): string {
    return Constants.BESTRATING[this.BestRating] || 'Unknown';
  }

  public getLength(): number {
    return this.MISSIONDATALENGTH;
  }
}
