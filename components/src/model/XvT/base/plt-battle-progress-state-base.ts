import { Byteable } from "../../../byteable";
import { IMission, PyriteBase } from "../../../pyrite-base";
import { getInt, writeInt } from "../../../hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class PLTBattleProgressStateBase extends PyriteBase implements Byteable {
  public readonly PLTBATTLEPROGRESSSTATELENGTH: number = 140;
  public MissionsFlown: number;
  public CombatMissionID: number;
  public totalMissionCount: number;
  public Outcome: number[];
  public BattleListIndex: number[];
  public CombatMissionListIndex: number[];
  public NumPlayers: number;
  public totalScore: number;
  
  constructor(hex: ArrayBuffer, tie?: IMission) {
    super(hex, tie);
    this.beforeConstruct();
    let offset = 0;

    this.MissionsFlown = getInt(hex, 0x0000);
    this.CombatMissionID = getInt(hex, 0x0004);
    this.totalMissionCount = getInt(hex, 0x0008);
    this.Outcome = [];
    offset = 0x000C;
    for (let i = 0; i < 10; i++) {
      const t = getInt(hex, offset);
      this.Outcome.push(t);
      offset += 4;
    }
    this.BattleListIndex = [];
    offset = 0x0034;
    for (let i = 0; i < 10; i++) {
      const t = getInt(hex, offset);
      this.BattleListIndex.push(t);
      offset += 4;
    }
    this.CombatMissionListIndex = [];
    offset = 0x005C;
    for (let i = 0; i < 10; i++) {
      const t = getInt(hex, offset);
      this.CombatMissionListIndex.push(t);
      offset += 4;
    }
    this.NumPlayers = getInt(hex, 0x0084);
    this.totalScore = getInt(hex, 0x0088);
    
  }
  
  public toJSON(): object {
    return {
      MissionsFlown: this.MissionsFlown,
      CombatMissionID: this.CombatMissionID,
      totalMissionCount: this.totalMissionCount,
      Outcome: this.Outcome,
      BattleListIndex: this.BattleListIndex,
      CombatMissionListIndex: this.CombatMissionListIndex,
      NumPlayers: this.NumPlayers,
      totalScore: this.totalScore
    };
  }
  
  public toHexString(): string {
    let hex: string = '';
    let offset = 0;

    writeInt(hex, this.MissionsFlown, 0x0000);
    writeInt(hex, this.CombatMissionID, 0x0004);
    writeInt(hex, this.totalMissionCount, 0x0008);
    offset = 0x000C;
    for (let i = 0; i < 10; i++) {
      const t = this.Outcome[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x0034;
    for (let i = 0; i < 10; i++) {
      const t = this.BattleListIndex[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x005C;
    for (let i = 0; i < 10; i++) {
      const t = this.CombatMissionListIndex[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    writeInt(hex, this.NumPlayers, 0x0084);
    writeInt(hex, this.totalScore, 0x0088);

    return hex;
  }
  
  
  public getLength(): number {
    return this.PLTBATTLEPROGRESSSTATELENGTH;
  }
}