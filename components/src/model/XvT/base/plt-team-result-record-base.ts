import { Byteable } from "../../../byteable";
import { IMission, PyriteBase } from "../../../pyrite-base";
import { getInt, writeInt } from "../../../hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class PLTTeamResultRecordBase extends PyriteBase implements Byteable {
  public readonly PLTTEAMRESULTRECORDLENGTH: number = 28;
  public totalMissionScore: number;
  public isMissionComplete: number;
  public unknown0x8: number;
  public timeMissionComplete: number;
  public fullKills: number;
  public sharedKills: number;
  public losses: number;
  
  constructor(hex: ArrayBuffer, tie?: IMission) {
    super(hex, tie);
    this.beforeConstruct();
    let offset = 0;

    this.totalMissionScore = getInt(hex, 0x0000);
    this.isMissionComplete = getInt(hex, 0x0004);
    this.unknown0x8 = getInt(hex, 0x0008);
    this.timeMissionComplete = getInt(hex, 0x000C);
    this.fullKills = getInt(hex, 0x0010);
    this.sharedKills = getInt(hex, 0x0014);
    this.losses = getInt(hex, 0x0018);
    
  }
  
  public toJSON(): object {
    return {
      totalMissionScore: this.totalMissionScore,
      isMissionComplete: this.isMissionComplete,
      unknown0x8: this.unknown0x8,
      timeMissionComplete: this.timeMissionComplete,
      fullKills: this.fullKills,
      sharedKills: this.sharedKills,
      losses: this.losses
    };
  }
  
  public toHexString(): string {
    let hex: string = '';
    let offset = 0;

    writeInt(hex, this.totalMissionScore, 0x0000);
    writeInt(hex, this.isMissionComplete, 0x0004);
    writeInt(hex, this.unknown0x8, 0x0008);
    writeInt(hex, this.timeMissionComplete, 0x000C);
    writeInt(hex, this.fullKills, 0x0010);
    writeInt(hex, this.sharedKills, 0x0014);
    writeInt(hex, this.losses, 0x0018);

    return hex;
  }
  
  
  public getLength(): number {
    return this.PLTTEAMRESULTRECORDLENGTH;
  }
}