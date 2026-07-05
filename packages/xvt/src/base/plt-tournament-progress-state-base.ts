import { Byteable, IMission, PyriteBase } from '@pyrite/core';
import { PLTTournTeamRecord } from '../plt-tourn-team-record';
import { getChar, getInt, writeChar, writeInt, writeObject } from '@pyrite/core';
export abstract class PLTTournamentProgressStateBase extends PyriteBase implements Byteable {
  public readonly PLTTOURNAMENTPROGRESSSTATELENGTH: number = 256;
  public unknown1: string;
  public completedMissionCount: number;
  public totalMissionCount: number;
  public teamRecord: PLTTournTeamRecord[];
  public playersActive: number;
  public teamsActive: number;
  public unknown2: number;

  constructor(hex: ArrayBuffer, TIE?: IMission) {
    super(hex, TIE!);
    this.beforeConstruct();
    let offset = 0;

    this.unknown1 = getChar(hex, 0x0000, 36);
    this.completedMissionCount = getInt(hex, 0x0024);
    this.totalMissionCount = getInt(hex, 0x0028);
    this.teamRecord = [];
    offset = 0x002c;
    for (let i = 0; i < 10; i++) {
      const t = new PLTTournTeamRecord(hex.slice(offset), this.TIE);
      this.teamRecord.push(t);
      offset += t.getLength();
    }
    this.playersActive = getInt(hex, 0x00f4);
    this.teamsActive = getInt(hex, 0x00f8);
    this.unknown2 = getInt(hex, 0x00fc);
  }

  public toJSON(): Record<string, unknown> | string {
    return {
      unknown1: this.unknown1,
      completedMissionCount: this.completedMissionCount,
      totalMissionCount: this.totalMissionCount,
      teamRecord: this.teamRecord.map((t) => t.toJSON()),
      playersActive: this.playersActive,
      teamsActive: this.teamsActive,
      unknown2: this.unknown2
    };
  }

  public toHexBuffer(): ArrayBuffer {
    const hex: ArrayBuffer = new ArrayBuffer(this.getLength());
    let offset = 0;

    writeChar(hex, this.unknown1, 0x0000, 36);
    writeInt(hex, this.completedMissionCount, 0x0024);
    writeInt(hex, this.totalMissionCount, 0x0028);
    offset = 0x002c;
    for (let i = 0; i < this.teamRecord.length; i++) {
      const t = this.teamRecord[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    writeInt(hex, this.playersActive, 0x00f4);
    writeInt(hex, this.teamsActive, 0x00f8);
    writeInt(hex, this.unknown2, 0x00fc);

    return hex;
  }

  public getLength(): number {
    return this.PLTTOURNAMENTPROGRESSSTATELENGTH;
  }
}
