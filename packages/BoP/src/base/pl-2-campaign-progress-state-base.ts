import { Byteable } from "../../../core/src/byteable";
import { IMission, PyriteBase } from "../../../core/src/pyrite-base";
import { getInt, writeInt } from "../../../core/src/hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class PL2CampaignProgressStateBase extends PyriteBase implements Byteable {
  public readonly PL2CAMPAIGNPROGRESSSTATELENGTH: number = 24;
  public unknown1: number;
  public CurrentMissionNumber: number;
  public totalMissionCount: number;
  public CurrentMissionComplete: number;
  public PlayerCount: number;
  public totalScore: number;
  
  constructor(hex: ArrayBuffer, tie?: IMission) {
    super(hex, tie);
    this.beforeConstruct();
    let offset = 0;

    this.unknown1 = getInt(hex, 0x0000);
    this.CurrentMissionNumber = getInt(hex, 0x0004);
    this.totalMissionCount = getInt(hex, 0x0008);
    this.CurrentMissionComplete = getInt(hex, 0x000C);
    this.PlayerCount = getInt(hex, 0x0010);
    this.totalScore = getInt(hex, 0x0014);
    
  }
  
  public toJSON(): object {
    return {
      unknown1: this.unknown1,
      CurrentMissionNumber: this.CurrentMissionNumber,
      totalMissionCount: this.totalMissionCount,
      CurrentMissionComplete: this.CurrentMissionComplete,
      PlayerCount: this.PlayerCount,
      totalScore: this.totalScore
    };
  }
  
  public toHexString(): string {
    let hex: string = '';
    let offset = 0;

    writeInt(hex, this.unknown1, 0x0000);
    writeInt(hex, this.CurrentMissionNumber, 0x0004);
    writeInt(hex, this.totalMissionCount, 0x0008);
    writeInt(hex, this.CurrentMissionComplete, 0x000C);
    writeInt(hex, this.PlayerCount, 0x0010);
    writeInt(hex, this.totalScore, 0x0014);

    return hex;
  }
  
  
  public getLength(): number {
    return this.PL2CAMPAIGNPROGRESSSTATELENGTH;
  }
}