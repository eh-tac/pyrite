import { Byteable, IMission, PyriteBase } from '@pyrite/core';
import { getInt, writeInt } from '@pyrite/core';
export abstract class PLTTournTeamRecordBase extends PyriteBase implements Byteable {
  public readonly PLTTOURNTEAMRECORDLENGTH: number = 20;
  public teamParticipationState: number;
  public totalTeamScore: number;
  public numberOfMeleeRankingsFirst: number;
  public numberOfMeleeRankingsSecond: number;
  public numberOfMeleeRankingsThird: number;

  constructor(
    public hex: ArrayBuffer,
    public TIE?: IMission
  ) {
    super(hex, TIE!);
    this.beforeConstruct();

    this.teamParticipationState = getInt(hex, 0x0000);
    this.totalTeamScore = getInt(hex, 0x0004);
    this.numberOfMeleeRankingsFirst = getInt(hex, 0x0008);
    this.numberOfMeleeRankingsSecond = getInt(hex, 0x000c);
    this.numberOfMeleeRankingsThird = getInt(hex, 0x0010);
  }

  public toJSON(): Record<string, unknown> | string {
    return {
      teamParticipationState: this.teamParticipationState,
      totalTeamScore: this.totalTeamScore,
      numberOfMeleeRankingsFirst: this.numberOfMeleeRankingsFirst,
      numberOfMeleeRankingsSecond: this.numberOfMeleeRankingsSecond,
      numberOfMeleeRankingsThird: this.numberOfMeleeRankingsThird
    };
  }

  public toHexBuffer(): ArrayBuffer {
    const hex: ArrayBuffer = new ArrayBuffer(this.getLength());

    writeInt(hex, this.teamParticipationState, 0x0000);
    writeInt(hex, this.totalTeamScore, 0x0004);
    writeInt(hex, this.numberOfMeleeRankingsFirst, 0x0008);
    writeInt(hex, this.numberOfMeleeRankingsSecond, 0x000c);
    writeInt(hex, this.numberOfMeleeRankingsThird, 0x0010);

    return hex;
  }

  public getLength(): number {
    return this.PLTTOURNTEAMRECORDLENGTH;
  }
}
