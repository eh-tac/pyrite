import { Byteable } from "../../../core/src/byteable";
import { IMission, PyriteBase } from "../../../core/src/pyrite-base";
import { PLTTournTeamRecord } from "../plt-tourn-team-record";
import { getChar, getInt, writeChar, writeInt, writeObject } from "../../../core/src/hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class PLTTournamentProgressStateBase extends PyriteBase implements Byteable {
  public readonly PLTTOURNAMENTPROGRESSSTATELENGTH: number = 256;
  public unknown1: string;
  public completedMissionCount: number;
  public totalMissionCount: number;
  public teamRecord: PLTTournTeamRecord[];
  public playersActive: number;
  public teamsActive: number;
  public unknown2: number;
  
  constructor(hex: ArrayBuffer, tie?: IMission) {
    super(hex, tie);
    this.beforeConstruct();
    let offset = 0;

    this.unknown1 = getChar(hex, 0x0000, 36);
    this.completedMissionCount = getInt(hex, 0x0024);
    this.totalMissionCount = getInt(hex, 0x0028);
    this.teamRecord = [];
    offset = 0x002C;
    for (let i = 0; i < 10; i++) {
      const t = new PLTTournTeamRecord(hex.slice(offset), this.TIE);
      this.teamRecord.push(t);
      offset += t.getLength();
    }
    this.playersActive = getInt(hex, 0x00F4);
    this.teamsActive = getInt(hex, 0x00F8);
    this.unknown2 = getInt(hex, 0x00FC);
    
  }
  
  public toJSON(): object {
    return {
      unknown1: this.unknown1,
      completedMissionCount: this.completedMissionCount,
      totalMissionCount: this.totalMissionCount,
      teamRecord: this.teamRecord,
      playersActive: this.playersActive,
      teamsActive: this.teamsActive,
      unknown2: this.unknown2
    };
  }
  
  public toHexString(): string {
    let hex: string = '';
    let offset = 0;

    writeChar(hex, this.unknown1, 0x0000);
    writeInt(hex, this.completedMissionCount, 0x0024);
    writeInt(hex, this.totalMissionCount, 0x0028);
    offset = 0x002C;
    for (let i = 0; i < 10; i++) {
      const t = this.teamRecord[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    writeInt(hex, this.playersActive, 0x00F4);
    writeInt(hex, this.teamsActive, 0x00F8);
    writeInt(hex, this.unknown2, 0x00FC);

    return hex;
  }
  
  
  public getLength(): number {
    return this.PLTTOURNAMENTPROGRESSSTATELENGTH;
  }
}