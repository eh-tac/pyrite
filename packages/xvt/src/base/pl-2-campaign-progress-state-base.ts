import { Byteable, IMission, PyriteBase } from '@pyrite/core';
import { getInt, writeInt } from '@pyrite/core';
export abstract class PL2CampaignProgressStateBase extends PyriteBase implements Byteable {
  public readonly PL2CAMPAIGNPROGRESSSTATELENGTH: number = 24;
  public unknown1: number;
  public CurrentMissionNumber: number;
  public totalMissionCount: number;
  public CurrentMissionComplete: number;
  public PlayerCount: number;
  public totalScore: number;

  constructor(hex: ArrayBuffer, TIE?: IMission) {
    super(hex, TIE!);
    this.beforeConstruct();

    this.unknown1 = getInt(hex, 0x0000);
    this.CurrentMissionNumber = getInt(hex, 0x0004);
    this.totalMissionCount = getInt(hex, 0x0008);
    this.CurrentMissionComplete = getInt(hex, 0x000c);
    this.PlayerCount = getInt(hex, 0x0010);
    this.totalScore = getInt(hex, 0x0014);
  }

  public toJSON(): Record<string, unknown> | string {
    return {
      unknown1: this.unknown1,
      CurrentMissionNumber: this.CurrentMissionNumber,
      totalMissionCount: this.totalMissionCount,
      CurrentMissionComplete: this.CurrentMissionComplete,
      PlayerCount: this.PlayerCount,
      totalScore: this.totalScore
    };
  }

  public toHexBuffer(): ArrayBuffer {
    const hex: ArrayBuffer = new ArrayBuffer(this.getLength());

    writeInt(hex, this.unknown1, 0x0000);
    writeInt(hex, this.CurrentMissionNumber, 0x0004);
    writeInt(hex, this.totalMissionCount, 0x0008);
    writeInt(hex, this.CurrentMissionComplete, 0x000c);
    writeInt(hex, this.PlayerCount, 0x0010);
    writeInt(hex, this.totalScore, 0x0014);

    return hex;
  }

  public getLength(): number {
    return this.PL2CAMPAIGNPROGRESSSTATELENGTH;
  }
}
