import { Byteable } from "../../../byteable";
import { Constants } from "../constants";
import { IMission, PyriteBase } from "../../../pyrite-base";
import { getBool, getByte, getInt, getShort, writeBool, writeByte, writeInt, writeShort } from "../../../hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class PilotFileBase extends PyriteBase implements Byteable {
  public PilotFileLength: number;
  public readonly Start: number = 0;
  public PilotStatus: number;
  public PilotRank: number;
  public PilotDifficulty: number;
  public Score: number;
  public SkillScore: number;
  public SecretOrder: number;
  public TrainingScores: number[];
  public TrainingLevels: number[];
  public CombatScores: number[];
  public CombatCompletes: boolean[];
  public BattleStatuses: number[];
  public BattleLastMissions: number[];
  public Persistence: number[];
  public SecretObjectives: number[];
  public BonusObjectives: number[];
  public BattleScores: number[];
  public TotalKills: number;
  public TotalCaptures: number;
  public KillsByType: number[];
  public LasersFired: number;
  public LasersHit: number;
  public WarheadsFired: number;
  public WarheadsHit: number;
  public CraftLost: number;
  
  constructor(hex: ArrayBuffer, tie?: IMission) {
    super(hex, tie);
    this.beforeConstruct();
    let offset = 0;

    // static prop Start
    this.PilotStatus = getByte(hex, 0x01);
    this.PilotRank = getByte(hex, 0x02);
    this.PilotDifficulty = getByte(hex, 0x03);
    this.Score = getInt(hex, 0x04);
    this.SkillScore = getShort(hex, 0x08);
    this.SecretOrder = getByte(hex, 0x0A);
    this.TrainingScores = [];
    offset = 0x2A;
    for (let i = 0; i < 7; i++) {
      const t = getInt(hex, offset);
      this.TrainingScores.push(t);
      offset += 4;
    }
    this.TrainingLevels = [];
    offset = 0x5A;
    for (let i = 0; i < 7; i++) {
      const t = getByte(hex, offset);
      this.TrainingLevels.push(t);
      offset += 1;
    }
    this.CombatScores = [];
    offset = 0x88;
    for (let i = 0; i < 56; i++) {
      const t = getInt(hex, offset);
      this.CombatScores.push(t);
      offset += 4;
    }
    this.CombatCompletes = [];
    offset = 0x208;
    for (let i = 0; i < 56; i++) {
      const t = getBool(hex, offset);
      this.CombatCompletes.push(t);
      offset += 1;
    }
    this.BattleStatuses = [];
    offset = 0x269;
    for (let i = 0; i < 20; i++) {
      const t = getByte(hex, offset);
      this.BattleStatuses.push(t);
      offset += 1;
    }
    this.BattleLastMissions = [];
    offset = 0x27D;
    for (let i = 0; i < 20; i++) {
      const t = getByte(hex, offset);
      this.BattleLastMissions.push(t);
      offset += 1;
    }
    this.Persistence = [];
    offset = 0x291;
    for (let i = 0; i < 256; i++) {
      const t = getByte(hex, offset);
      this.Persistence.push(t);
      offset += 1;
    }
    this.SecretObjectives = [];
    offset = 0x391;
    for (let i = 0; i < 20; i++) {
      const t = getByte(hex, offset);
      this.SecretObjectives.push(t);
      offset += 1;
    }
    this.BonusObjectives = [];
    offset = 0x3A5;
    for (let i = 0; i < 20; i++) {
      const t = getByte(hex, offset);
      this.BonusObjectives.push(t);
      offset += 1;
    }
    this.BattleScores = [];
    offset = 0x3DA;
    for (let i = 0; i < 160; i++) {
      const t = getInt(hex, offset);
      this.BattleScores.push(t);
      offset += 4;
    }
    this.TotalKills = getShort(hex, 0x65A);
    this.TotalCaptures = getShort(hex, 0x65C);
    this.KillsByType = [];
    offset = 0x660;
    for (let i = 0; i < 69; i++) {
      const t = getShort(hex, offset);
      this.KillsByType.push(t);
      offset += 2;
    }
    this.LasersFired = getInt(hex, 0x774);
    this.LasersHit = getInt(hex, 0x778);
    this.WarheadsFired = getShort(hex, 0x780);
    this.WarheadsHit = getShort(hex, 0x782);
    this.CraftLost = getShort(hex, 0x786);
    this.PilotFileLength = offset;
  }
  
  public toJSON(): object {
    return {
      PilotStatus: this.PilotStatusLabel,
      PilotRank: this.PilotRankLabel,
      PilotDifficulty: this.PilotDifficultyLabel,
      Score: this.Score,
      SkillScore: this.SkillScore,
      SecretOrder: this.SecretOrderLabel,
      TrainingScores: this.TrainingScores,
      TrainingLevels: this.TrainingLevels,
      CombatScores: this.CombatScores,
      CombatCompletes: this.CombatCompletes,
      BattleStatuses: this.BattleStatuses,
      BattleLastMissions: this.BattleLastMissions,
      Persistence: this.Persistence,
      SecretObjectives: this.SecretObjectives,
      BonusObjectives: this.BonusObjectives,
      BattleScores: this.BattleScores,
      TotalKills: this.TotalKills,
      TotalCaptures: this.TotalCaptures,
      KillsByType: this.KillsByType,
      LasersFired: this.LasersFired,
      LasersHit: this.LasersHit,
      WarheadsFired: this.WarheadsFired,
      WarheadsHit: this.WarheadsHit,
      CraftLost: this.CraftLost
    };
  }
  
  public toHexString(): string {
    let hex: string = '';
    let offset = 0;

    writeByte(hex, 0, 0x00);
    writeByte(hex, this.PilotStatus, 0x01);
    writeByte(hex, this.PilotRank, 0x02);
    writeByte(hex, this.PilotDifficulty, 0x03);
    writeInt(hex, this.Score, 0x04);
    writeShort(hex, this.SkillScore, 0x08);
    writeByte(hex, this.SecretOrder, 0x0A);
    offset = 0x2A;
    for (let i = 0; i < 7; i++) {
      const t = this.TrainingScores[i];
      writeInt(hex, t, 0x2A);
      offset += 4;
    }
    offset = 0x5A;
    for (let i = 0; i < 7; i++) {
      const t = this.TrainingLevels[i];
      writeByte(hex, t, 0x5A);
      offset += 1;
    }
    offset = 0x88;
    for (let i = 0; i < 56; i++) {
      const t = this.CombatScores[i];
      writeInt(hex, t, 0x88);
      offset += 4;
    }
    offset = 0x208;
    for (let i = 0; i < 56; i++) {
      const t = this.CombatCompletes[i];
      writeBool(hex, t, 0x208);
      offset += 1;
    }
    offset = 0x269;
    for (let i = 0; i < 20; i++) {
      const t = this.BattleStatuses[i];
      writeByte(hex, t, 0x269);
      offset += 1;
    }
    offset = 0x27D;
    for (let i = 0; i < 20; i++) {
      const t = this.BattleLastMissions[i];
      writeByte(hex, t, 0x27D);
      offset += 1;
    }
    offset = 0x291;
    for (let i = 0; i < 256; i++) {
      const t = this.Persistence[i];
      writeByte(hex, t, 0x291);
      offset += 1;
    }
    offset = 0x391;
    for (let i = 0; i < 20; i++) {
      const t = this.SecretObjectives[i];
      writeByte(hex, t, 0x391);
      offset += 1;
    }
    offset = 0x3A5;
    for (let i = 0; i < 20; i++) {
      const t = this.BonusObjectives[i];
      writeByte(hex, t, 0x3A5);
      offset += 1;
    }
    offset = 0x3DA;
    for (let i = 0; i < 160; i++) {
      const t = this.BattleScores[i];
      writeInt(hex, t, 0x3DA);
      offset += 4;
    }
    writeShort(hex, this.TotalKills, 0x65A);
    writeShort(hex, this.TotalCaptures, 0x65C);
    offset = 0x660;
    for (let i = 0; i < 69; i++) {
      const t = this.KillsByType[i];
      writeShort(hex, t, 0x660);
      offset += 2;
    }
    writeInt(hex, this.LasersFired, 0x774);
    writeInt(hex, this.LasersHit, 0x778);
    writeShort(hex, this.WarheadsFired, 0x780);
    writeShort(hex, this.WarheadsHit, 0x782);
    writeShort(hex, this.CraftLost, 0x786);

    return hex;
  }
  
  public get PilotStatusLabel(): string {
    return Constants.PILOTSTATUS[this.PilotStatus] || "Unknown";
  }

  public get PilotRankLabel(): string {
    return Constants.PILOTRANK[this.PilotRank] || "Unknown";
  }

  public get PilotDifficultyLabel(): string {
    return Constants.PILOTDIFFICULTY[this.PilotDifficulty] || "Unknown";
  }

  public get SecretOrderLabel(): string {
    return Constants.SECRETORDER[this.SecretOrder] || "Unknown";
  }
  
  public getLength(): number {
    return this.PilotFileLength;
  }
}