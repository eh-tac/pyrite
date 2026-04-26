import { Byteable } from "@pickledyoda/pyrite-core/byteable";
import { IMission, PyriteBase } from "@pickledyoda/pyrite-core/pyrite-base";
import { getInt, writeInt } from "@pickledyoda/pyrite-core/hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class PLTTournTeamRecordBase extends PyriteBase implements Byteable {
  public readonly PLTTOURNTEAMRECORDLENGTH: number = 20;
  public teamParticipationState: number;
  public totalTeamScore: number;
  public numberOfMeleeRankingsFirst: number;
  public numberOfMeleeRankingsSecond: number;
  public numberOfMeleeRankingsThird: number;
  
  constructor(hex: ArrayBuffer, tie?: IMission) {
    super(hex, tie);
    this.beforeConstruct();
    let offset = 0;

    this.teamParticipationState = getInt(hex, 0x0000);
    this.totalTeamScore = getInt(hex, 0x0004);
    this.numberOfMeleeRankingsFirst = getInt(hex, 0x0008);
    this.numberOfMeleeRankingsSecond = getInt(hex, 0x000C);
    this.numberOfMeleeRankingsThird = getInt(hex, 0x0010);
    
  }
  
  public toJSON(): object {
    return {
      teamParticipationState: this.teamParticipationState,
      totalTeamScore: this.totalTeamScore,
      numberOfMeleeRankingsFirst: this.numberOfMeleeRankingsFirst,
      numberOfMeleeRankingsSecond: this.numberOfMeleeRankingsSecond,
      numberOfMeleeRankingsThird: this.numberOfMeleeRankingsThird
    };
  }
  
  public toHexString(): string {
    let hex: string = '';
    let offset = 0;

    writeInt(hex, this.teamParticipationState, 0x0000);
    writeInt(hex, this.totalTeamScore, 0x0004);
    writeInt(hex, this.numberOfMeleeRankingsFirst, 0x0008);
    writeInt(hex, this.numberOfMeleeRankingsSecond, 0x000C);
    writeInt(hex, this.numberOfMeleeRankingsThird, 0x0010);

    return hex;
  }
  
  
  public getLength(): number {
    return this.PLTTOURNTEAMRECORDLENGTH;
  }
}