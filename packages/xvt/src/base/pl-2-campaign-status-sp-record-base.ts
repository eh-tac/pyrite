import type { Byteable, IMission} from '@pyrite/core';
import { PyriteBase } from '@pyrite/core';
import { getInt, writeInt } from '@pyrite/core';
export abstract class PL2CampaignStatusSPRecordBase extends PyriteBase implements Byteable {
  public readonly PL2CAMPAIGNSTATUSSPRECORDLENGTH: number = 36;
  public unknown0x0: number;
  public isStartedUNK: number;
  public missionNumber: number;
  public isFinished: number;
  public bestScore: number;
  public unknown0x14: number;
  public unknown0x18: number;
  public unknown0x1C: number;
  public unknown0x20: number;

  constructor(hex: ArrayBuffer, TIE?: IMission) {
    super(hex, TIE!);
    this.beforeConstruct();

    this.unknown0x0 = getInt(hex, 0x0000);
    this.isStartedUNK = getInt(hex, 0x0004);
    this.missionNumber = getInt(hex, 0x0008);
    this.isFinished = getInt(hex, 0x000c);
    this.bestScore = getInt(hex, 0x0010);
    this.unknown0x14 = getInt(hex, 0x0014);
    this.unknown0x18 = getInt(hex, 0x0018);
    this.unknown0x1C = getInt(hex, 0x001c);
    this.unknown0x20 = getInt(hex, 0x0020);
  }

  public toJSON(): Record<string, unknown> | string {
    return {
      unknown0x0: this.unknown0x0,
      isStartedUNK: this.isStartedUNK,
      missionNumber: this.missionNumber,
      isFinished: this.isFinished,
      bestScore: this.bestScore,
      unknown0x14: this.unknown0x14,
      unknown0x18: this.unknown0x18,
      unknown0x1C: this.unknown0x1C,
      unknown0x20: this.unknown0x20
    };
  }

  public toHexBuffer(): ArrayBuffer {
    const hex: ArrayBuffer = new ArrayBuffer(this.getLength());

    writeInt(hex, this.unknown0x0, 0x0000);
    writeInt(hex, this.isStartedUNK, 0x0004);
    writeInt(hex, this.missionNumber, 0x0008);
    writeInt(hex, this.isFinished, 0x000c);
    writeInt(hex, this.bestScore, 0x0010);
    writeInt(hex, this.unknown0x14, 0x0014);
    writeInt(hex, this.unknown0x18, 0x0018);
    writeInt(hex, this.unknown0x1C, 0x001c);
    writeInt(hex, this.unknown0x20, 0x0020);

    return hex;
  }

  public getLength(): number {
    return this.PL2CAMPAIGNSTATUSSPRECORDLENGTH;
  }
}
