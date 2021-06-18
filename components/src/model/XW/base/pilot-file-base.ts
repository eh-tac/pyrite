import { Byteable } from "../../../byteable";
import { Constants } from "../constants";
import { IMission, PyriteBase } from "../../../pyrite-base";
import { getBool, getByte, getInt, getShort, writeBool, writeByte, writeInt, writeShort } from "../../../hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class PilotFileBase extends PyriteBase implements Byteable {
  public readonly PILOTFILELENGTH: number = 1704;
  public PlatformID: number;
  public PilotStatus: number;
  public PilotRank: number;
  public TotalTODScore: number;
  public RookieNumber: number;
  public TODMedals: boolean[];
  public KalidorCrescent: number;
  public MazeScore: number[]; //XW YW AW BW
  public MazeLevel: number[];
  public XWingHistoricalScore: number[];
  public YWingHistoricalScore: number[];
  public AWingHistoricalScore: number[];
  public BWingHistoricalScore: number[];
  public BonusHistoricalScore: number[];
  public XWingHistoricalComplete: boolean[];
  public YWingHistoricalComplete: boolean[];
  public AWingHistoricalComplete: boolean[];
  public BWingHistoricalComplete: boolean[];
  public BonusHistoricalComplete: boolean[];
  public TourStatus: number[];
  public TourOperationsComplete: number[];
  public Tour1Scores: number[];
  public Tour2Scores: number[];
  public Tour3Scores: number[];
  public Tour4Scores: number[];
  public Tour5Scores: number[];
  public SurfaceVictories: number;
  public TODKills: number[];
  public TODCaptures: number[];
  public LasersFired: number;
  public LaserCraftHits: number;
  public LaserGroundHits: number;
  public MissilesFired: number;
  public MissileCraftHits: number;
  public MissileGroundHits: number;
  public CraftLost: number;
  
  constructor(hex: ArrayBuffer, tie?: IMission) {
    super(hex, tie);
    this.beforeConstruct();
    let offset = 0;

    this.PlatformID = getShort(hex, 0x000);
    this.PilotStatus = getByte(hex, 0x002);
    this.PilotRank = getByte(hex, 0x003);
    this.TotalTODScore = getInt(hex, 0x004);
    this.RookieNumber = getShort(hex, 0x008);
    this.TODMedals = [];
    offset = 0x00A;
    for (let i = 0; i < 5; i++) {
      const t = getBool(hex, offset);
      this.TODMedals.push(t);
      offset += 1;
    }
    this.KalidorCrescent = getByte(hex, 0x011);
    this.MazeScore = [];
    offset = 0x026;
    for (let i = 0; i < 4; i++) {
      const t = getInt(hex, offset);
      this.MazeScore.push(t);
      offset += 4;
    }
    this.MazeLevel = [];
    offset = 0x086;
    for (let i = 0; i < 4; i++) {
      const t = getByte(hex, offset);
      this.MazeLevel.push(t);
      offset += 1;
    }
    this.XWingHistoricalScore = [];
    offset = 0x0A0;
    for (let i = 0; i < 6; i++) {
      const t = getInt(hex, offset);
      this.XWingHistoricalScore.push(t);
      offset += 4;
    }
    this.YWingHistoricalScore = [];
    offset = 0x0E0;
    for (let i = 0; i < 6; i++) {
      const t = getInt(hex, offset);
      this.YWingHistoricalScore.push(t);
      offset += 4;
    }
    this.AWingHistoricalScore = [];
    offset = 0x120;
    for (let i = 0; i < 6; i++) {
      const t = getInt(hex, offset);
      this.AWingHistoricalScore.push(t);
      offset += 4;
    }
    this.BWingHistoricalScore = [];
    offset = 0x160;
    for (let i = 0; i < 6; i++) {
      const t = getInt(hex, offset);
      this.BWingHistoricalScore.push(t);
      offset += 4;
    }
    this.BonusHistoricalScore = [];
    offset = 0x1A0;
    for (let i = 0; i < 6; i++) {
      const t = getInt(hex, offset);
      this.BonusHistoricalScore.push(t);
      offset += 4;
    }
    this.XWingHistoricalComplete = [];
    offset = 0x220;
    for (let i = 0; i < 6; i++) {
      const t = getBool(hex, offset);
      this.XWingHistoricalComplete.push(t);
      offset += 1;
    }
    this.YWingHistoricalComplete = [];
    offset = 0x230;
    for (let i = 0; i < 6; i++) {
      const t = getBool(hex, offset);
      this.YWingHistoricalComplete.push(t);
      offset += 1;
    }
    this.AWingHistoricalComplete = [];
    offset = 0x240;
    for (let i = 0; i < 6; i++) {
      const t = getBool(hex, offset);
      this.AWingHistoricalComplete.push(t);
      offset += 1;
    }
    this.BWingHistoricalComplete = [];
    offset = 0x250;
    for (let i = 0; i < 6; i++) {
      const t = getBool(hex, offset);
      this.BWingHistoricalComplete.push(t);
      offset += 1;
    }
    this.BonusHistoricalComplete = [];
    offset = 0x260;
    for (let i = 0; i < 6; i++) {
      const t = getBool(hex, offset);
      this.BonusHistoricalComplete.push(t);
      offset += 1;
    }
    this.TourStatus = [];
    offset = 0x2DF;
    for (let i = 0; i < 5; i++) {
      const t = getByte(hex, offset);
      this.TourStatus.push(t);
      offset += 1;
    }
    this.TourOperationsComplete = [];
    offset = 0x2EF;
    for (let i = 0; i < 5; i++) {
      const t = getByte(hex, offset);
      this.TourOperationsComplete.push(t);
      offset += 1;
    }
    this.Tour1Scores = [];
    offset = 0x2F7;
    for (let i = 0; i < 12; i++) {
      const t = getInt(hex, offset);
      this.Tour1Scores.push(t);
      offset += 4;
    }
    this.Tour2Scores = [];
    offset = 0x35B;
    for (let i = 0; i < 12; i++) {
      const t = getInt(hex, offset);
      this.Tour2Scores.push(t);
      offset += 4;
    }
    this.Tour3Scores = [];
    offset = 0x3BF;
    for (let i = 0; i < 14; i++) {
      const t = getInt(hex, offset);
      this.Tour3Scores.push(t);
      offset += 4;
    }
    this.Tour4Scores = [];
    offset = 0x423;
    for (let i = 0; i < 24; i++) {
      const t = getInt(hex, offset);
      this.Tour4Scores.push(t);
      offset += 4;
    }
    this.Tour5Scores = [];
    offset = 0x487;
    for (let i = 0; i < 24; i++) {
      const t = getInt(hex, offset);
      this.Tour5Scores.push(t);
      offset += 4;
    }
    this.SurfaceVictories = getShort(hex, 0x633);
    this.TODKills = [];
    offset = 0x635;
    for (let i = 0; i < 24; i++) {
      const t = getShort(hex, offset);
      this.TODKills.push(t);
      offset += 2;
    }
    this.TODCaptures = [];
    offset = 0x665;
    for (let i = 0; i < 24; i++) {
      const t = getShort(hex, offset);
      this.TODCaptures.push(t);
      offset += 2;
    }
    this.LasersFired = getInt(hex, 0x695);
    this.LaserCraftHits = getInt(hex, 0x699);
    this.LaserGroundHits = getInt(hex, 0x69D);
    this.MissilesFired = getShort(hex, 0x6A1);
    this.MissileCraftHits = getShort(hex, 0x6A3);
    this.MissileGroundHits = getShort(hex, 0x6A5);
    this.CraftLost = getShort(hex, 0x6A7);
    
  }
  
  public toJSON(): object {
    return {
      PlatformID: this.PlatformID,
      PilotStatus: this.PilotStatusLabel,
      PilotRank: this.PilotRankLabel,
      TotalTODScore: this.TotalTODScore,
      RookieNumber: this.RookieNumber,
      TODMedals: this.TODMedals,
      KalidorCrescent: this.KalidorCrescentLabel,
      MazeScore: this.MazeScore,
      MazeLevel: this.MazeLevel,
      XWingHistoricalScore: this.XWingHistoricalScore,
      YWingHistoricalScore: this.YWingHistoricalScore,
      AWingHistoricalScore: this.AWingHistoricalScore,
      BWingHistoricalScore: this.BWingHistoricalScore,
      BonusHistoricalScore: this.BonusHistoricalScore,
      XWingHistoricalComplete: this.XWingHistoricalComplete,
      YWingHistoricalComplete: this.YWingHistoricalComplete,
      AWingHistoricalComplete: this.AWingHistoricalComplete,
      BWingHistoricalComplete: this.BWingHistoricalComplete,
      BonusHistoricalComplete: this.BonusHistoricalComplete,
      TourStatus: this.TourStatus,
      TourOperationsComplete: this.TourOperationsComplete,
      Tour1Scores: this.Tour1Scores,
      Tour2Scores: this.Tour2Scores,
      Tour3Scores: this.Tour3Scores,
      Tour4Scores: this.Tour4Scores,
      Tour5Scores: this.Tour5Scores,
      SurfaceVictories: this.SurfaceVictories,
      TODKills: this.TODKills,
      TODCaptures: this.TODCaptures,
      LasersFired: this.LasersFired,
      LaserCraftHits: this.LaserCraftHits,
      LaserGroundHits: this.LaserGroundHits,
      MissilesFired: this.MissilesFired,
      MissileCraftHits: this.MissileCraftHits,
      MissileGroundHits: this.MissileGroundHits,
      CraftLost: this.CraftLost
    };
  }
  
  public toHexString(): string {
    let hex: string = '';
    let offset = 0;

    writeShort(hex, this.PlatformID, 0x000);
    writeByte(hex, this.PilotStatus, 0x002);
    writeByte(hex, this.PilotRank, 0x003);
    writeInt(hex, this.TotalTODScore, 0x004);
    writeShort(hex, this.RookieNumber, 0x008);
    offset = 0x00A;
    for (let i = 0; i < 5; i++) {
      const t = this.TODMedals[i];
      writeBool(hex, t, offset);
      offset += 1;
    }
    writeByte(hex, this.KalidorCrescent, 0x011);
    offset = 0x026;
    for (let i = 0; i < 4; i++) {
      const t = this.MazeScore[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x086;
    for (let i = 0; i < 4; i++) {
      const t = this.MazeLevel[i];
      writeByte(hex, t, offset);
      offset += 1;
    }
    offset = 0x0A0;
    for (let i = 0; i < 6; i++) {
      const t = this.XWingHistoricalScore[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x0E0;
    for (let i = 0; i < 6; i++) {
      const t = this.YWingHistoricalScore[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x120;
    for (let i = 0; i < 6; i++) {
      const t = this.AWingHistoricalScore[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x160;
    for (let i = 0; i < 6; i++) {
      const t = this.BWingHistoricalScore[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x1A0;
    for (let i = 0; i < 6; i++) {
      const t = this.BonusHistoricalScore[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x220;
    for (let i = 0; i < 6; i++) {
      const t = this.XWingHistoricalComplete[i];
      writeBool(hex, t, offset);
      offset += 1;
    }
    offset = 0x230;
    for (let i = 0; i < 6; i++) {
      const t = this.YWingHistoricalComplete[i];
      writeBool(hex, t, offset);
      offset += 1;
    }
    offset = 0x240;
    for (let i = 0; i < 6; i++) {
      const t = this.AWingHistoricalComplete[i];
      writeBool(hex, t, offset);
      offset += 1;
    }
    offset = 0x250;
    for (let i = 0; i < 6; i++) {
      const t = this.BWingHistoricalComplete[i];
      writeBool(hex, t, offset);
      offset += 1;
    }
    offset = 0x260;
    for (let i = 0; i < 6; i++) {
      const t = this.BonusHistoricalComplete[i];
      writeBool(hex, t, offset);
      offset += 1;
    }
    offset = 0x2DF;
    for (let i = 0; i < 5; i++) {
      const t = this.TourStatus[i];
      writeByte(hex, t, offset);
      offset += 1;
    }
    offset = 0x2EF;
    for (let i = 0; i < 5; i++) {
      const t = this.TourOperationsComplete[i];
      writeByte(hex, t, offset);
      offset += 1;
    }
    offset = 0x2F7;
    for (let i = 0; i < 12; i++) {
      const t = this.Tour1Scores[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x35B;
    for (let i = 0; i < 12; i++) {
      const t = this.Tour2Scores[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x3BF;
    for (let i = 0; i < 14; i++) {
      const t = this.Tour3Scores[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x423;
    for (let i = 0; i < 24; i++) {
      const t = this.Tour4Scores[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x487;
    for (let i = 0; i < 24; i++) {
      const t = this.Tour5Scores[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    writeShort(hex, this.SurfaceVictories, 0x633);
    offset = 0x635;
    for (let i = 0; i < 24; i++) {
      const t = this.TODKills[i];
      writeShort(hex, t, offset);
      offset += 2;
    }
    offset = 0x665;
    for (let i = 0; i < 24; i++) {
      const t = this.TODCaptures[i];
      writeShort(hex, t, offset);
      offset += 2;
    }
    writeInt(hex, this.LasersFired, 0x695);
    writeInt(hex, this.LaserCraftHits, 0x699);
    writeInt(hex, this.LaserGroundHits, 0x69D);
    writeShort(hex, this.MissilesFired, 0x6A1);
    writeShort(hex, this.MissileCraftHits, 0x6A3);
    writeShort(hex, this.MissileGroundHits, 0x6A5);
    writeShort(hex, this.CraftLost, 0x6A7);

    return hex;
  }
  
  public get PilotStatusLabel(): string {
    return Constants.PILOTSTATUS[this.PilotStatus] || "Unknown";
  }

  public get PilotRankLabel(): string {
    return Constants.PILOTRANK[this.PilotRank] || "Unknown";
  }

  public get KalidorCrescentLabel(): string {
    return Constants.KALIDORCRESCENT[this.KalidorCrescent] || "Unknown";
  }
  
  public getLength(): number {
    return this.PILOTFILELENGTH;
  }
}