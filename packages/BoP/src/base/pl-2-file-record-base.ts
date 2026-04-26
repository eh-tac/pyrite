import { Byteable } from "@pickledyoda/pyrite-core/byteable";
import { IMission, PyriteBase } from "@pickledyoda/pyrite-core/pyrite-base";
import { PL2CampaignProgressState } from "../pl-2-campaign-progress-state";
import { PL2CampaignState } from "../pl-2-campaign-state";
import { PL2DebriefRecord } from "../pl-2-debrief-record";
import { PL2FactionRecord } from "../pl-2-faction-record";
import { PLTAIRankCountRecord } from "../pltai-rank-count-record";
import { PLTBattleProgressState } from "../plt-battle-progress-state";
import { PLTBattleState } from "../plt-battle-state";
import { PLTCategoryTypeRecord } from "../plt-category-type-record";
import { PLTConnectedPlayerData } from "../plt-connected-player-data";
import { PLTPlayerRankCountRecord } from "../plt-player-rank-count-record";
import { PLTTeamResultRecord } from "../plt-team-result-record";
import { PLTTournamentProgressState } from "../plt-tournament-progress-state";
import { getByte, getChar, getInt, getShort, writeByte, writeChar, writeInt, writeObject, writeShort } from "@pickledyoda/pyrite-core/hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class PL2FileRecordBase extends PyriteBase implements Byteable {
  public readonly PL2FILERECORDLENGTH: number = 296238;
  public PilotName: string;
  public totalScore: PLTCategoryTypeRecord;
  public PlayerID: number;
  public continuedOrReflownMission: number;
  public isHosting: number;
  public numHumanPlayersInMission: number;
  public frontFlyMode: number;
  public unknown0x26: number[];
  public unknown0x166: number[];
  public unknown0x186: number[];
  public activeMissionTeam: number;
  public MissionFolderIndex: number;
  public SelectedIDNumOfMissionCategory: number[];
  public GameName: string;
  public LastGameName: string;
  public isMissionCategorySeries: number;
  public activeMissionIDNum: number;
  public PromoPoints: number;
  public WorsePromoPoints: number;
  public RankAdjustmentApplied: number;
  public PercentToNextRank: number;
  public numFlownNonSeries: PLTCategoryTypeRecord;
  public numFlownSeries: PLTCategoryTypeRecord;
  public totalKillCount: PLTCategoryTypeRecord;
  public totalFriendlyKillCount: PLTCategoryTypeRecord;
  public totalKillCountByCraftType: number[];
  public totalFullKillsOnPlayerRank: PLTPlayerRankCountRecord;
  public totalSharedKillsOnPlayerRank: PLTPlayerRankCountRecord;
  public totalAssistKillsOnPlayerRank: PLTPlayerRankCountRecord;
  public totalFullKillsOnAIRank: PLTAIRankCountRecord;
  public totalSharedKillsOnAIRank: PLTAIRankCountRecord;
  public totalAssistKillsOnAIRank: PLTAIRankCountRecord;
  public totalHiddenCargoFound: PLTCategoryTypeRecord;
  public totalLaserHit: PLTCategoryTypeRecord;
  public totalLaserFired: PLTCategoryTypeRecord;
  public totalWarheadHit: PLTCategoryTypeRecord;
  public totalWarheadFired: PLTCategoryTypeRecord;
  public totalCraftLosses: PLTCategoryTypeRecord;
  public totalLossesFromCollision: PLTCategoryTypeRecord;
  public totalLossesFromStarships: PLTCategoryTypeRecord;
  public totalLossesFromMines: PLTCategoryTypeRecord;
  public totalLossesFromPlayerRank: PLTPlayerRankCountRecord;
  public totalLossesFromAIRank: PLTAIRankCountRecord;
  public activeTournament: PLTTournamentProgressState;
  public activeBattle: PLTBattleProgressState;
  public CurrentRank: number;
  public totalCountMissionsFlown: number;
  public RankAchievedOnMissionCount: number[];
  public RankString: string;
  public debriefMissionScore: number;
  public debriefFullKillsOnPlayer: number[];
  public debriefSharedKillsOnPlayer: number[];
  public debriefFullKillsOnFG: number[];
  public debriefSharedKillsOnFG: number[];
  public debriefFullKillsByPlayer: number[];
  public debriefSharedKillsByPlayer: number[];
  public debriefFullKillsByFG: number[];
  public debriefSharedKillsByFG: number[];
  public debriefMeleeAIRankFG: number[];
  public debrief: PL2DebriefRecord;
  public connectedPlayerData: PLTConnectedPlayerData[];
  public debriefTeamResult: PLTTeamResultRecord[];
  public SelectedFaction: number;
  public faction: PL2FactionRecord[];
  public activeCampaign: PL2CampaignProgressState;
  public gap45E1E: number[];
  public spBattleState: PLTBattleState[];
  public mpBattleState: PLTBattleState[];
  public spCampaignState: PL2CampaignState[];
  public mpCampaignHostState: PL2CampaignState[];
  public mpCampaignClientState: PL2CampaignState[];
  public anonymous_259: number[];
  public anonymous_260: number;
  public anonymous_261: number;
  
  constructor(hex: ArrayBuffer, tie?: IMission) {
    super(hex, tie);
    this.beforeConstruct();
    let offset = 0;

    this.PilotName = getChar(hex, 0x0000, 14);
    this.totalScore = new PLTCategoryTypeRecord(hex.slice(0x033E), this.TIE);
    this.PlayerID = getInt(hex, 0x0012);
    this.continuedOrReflownMission = getInt(hex, 0x0016);
    this.isHosting = getInt(hex, 0x001A);
    this.numHumanPlayersInMission = getInt(hex, 0x001E);
    this.frontFlyMode = getInt(hex, 0x0022);
    this.unknown0x26 = [];
    offset = 0x0026;
    for (let i = 0; i < 80; i++) {
      const t = getInt(hex, offset);
      this.unknown0x26.push(t);
      offset += 4;
    }
    this.unknown0x166 = [];
    offset = 0x0166;
    for (let i = 0; i < 8; i++) {
      const t = getInt(hex, offset);
      this.unknown0x166.push(t);
      offset += 4;
    }
    this.unknown0x186 = [];
    offset = 0x0186;
    for (let i = 0; i < 80; i++) {
      const t = getInt(hex, offset);
      this.unknown0x186.push(t);
      offset += 4;
    }
    this.activeMissionTeam = getInt(hex, 0x02C6);
    this.MissionFolderIndex = getInt(hex, 0x02CA);
    this.SelectedIDNumOfMissionCategory = [];
    offset = 0x02CE;
    for (let i = 0; i < 6; i++) {
      const t = getInt(hex, offset);
      this.SelectedIDNumOfMissionCategory.push(t);
      offset += 4;
    }
    this.GameName = getChar(hex, 0x02E6, 32);
    this.LastGameName = getChar(hex, 0x0306, 32);
    this.isMissionCategorySeries = getInt(hex, 0x0326);
    this.activeMissionIDNum = getInt(hex, 0x032A);
    this.PromoPoints = getInt(hex, 0x032E);
    this.WorsePromoPoints = getInt(hex, 0x0332);
    this.RankAdjustmentApplied = getInt(hex, 0x0336);
    this.PercentToNextRank = getInt(hex, 0x033A);
    this.numFlownNonSeries = new PLTCategoryTypeRecord(hex.slice(0x034A), this.TIE);
    this.numFlownSeries = new PLTCategoryTypeRecord(hex.slice(0x0356), this.TIE);
    this.totalKillCount = new PLTCategoryTypeRecord(hex.slice(0x0362), this.TIE);
    this.totalFriendlyKillCount = new PLTCategoryTypeRecord(hex.slice(0x036E), this.TIE);
    this.totalKillCountByCraftType = [];
    offset = 0x037A;
    for (let i = 0; i < 900; i++) {
      const t = getInt(hex, offset);
      this.totalKillCountByCraftType.push(t);
      offset += 4;
    }
    this.totalFullKillsOnPlayerRank = new PLTPlayerRankCountRecord(hex.slice(0x118A), this.TIE);
    this.totalSharedKillsOnPlayerRank = new PLTPlayerRankCountRecord(hex.slice(0x12B6), this.TIE);
    this.totalAssistKillsOnPlayerRank = new PLTPlayerRankCountRecord(hex.slice(0x13E2), this.TIE);
    this.totalFullKillsOnAIRank = new PLTAIRankCountRecord(hex.slice(0x150E), this.TIE);
    this.totalSharedKillsOnAIRank = new PLTAIRankCountRecord(hex.slice(0x1556), this.TIE);
    this.totalAssistKillsOnAIRank = new PLTAIRankCountRecord(hex.slice(0x159E), this.TIE);
    this.totalHiddenCargoFound = new PLTCategoryTypeRecord(hex.slice(0x15E6), this.TIE);
    this.totalLaserHit = new PLTCategoryTypeRecord(hex.slice(0x15F2), this.TIE);
    this.totalLaserFired = new PLTCategoryTypeRecord(hex.slice(0x15FE), this.TIE);
    this.totalWarheadHit = new PLTCategoryTypeRecord(hex.slice(0x160A), this.TIE);
    this.totalWarheadFired = new PLTCategoryTypeRecord(hex.slice(0x1616), this.TIE);
    this.totalCraftLosses = new PLTCategoryTypeRecord(hex.slice(0x1622), this.TIE);
    this.totalLossesFromCollision = new PLTCategoryTypeRecord(hex.slice(0x162E), this.TIE);
    this.totalLossesFromStarships = new PLTCategoryTypeRecord(hex.slice(0x163A), this.TIE);
    this.totalLossesFromMines = new PLTCategoryTypeRecord(hex.slice(0x1646), this.TIE);
    this.totalLossesFromPlayerRank = new PLTPlayerRankCountRecord(hex.slice(0x1652), this.TIE);
    this.totalLossesFromAIRank = new PLTAIRankCountRecord(hex.slice(0x177E), this.TIE);
    this.activeTournament = new PLTTournamentProgressState(hex.slice(0x17C6), this.TIE);
    this.activeBattle = new PLTBattleProgressState(hex.slice(0x18C6), this.TIE);
    this.CurrentRank = getInt(hex, 0x1952);
    this.totalCountMissionsFlown = getInt(hex, 0x1956);
    this.RankAchievedOnMissionCount = [];
    offset = 0x195A;
    for (let i = 0; i < 25; i++) {
      const t = getInt(hex, offset);
      this.RankAchievedOnMissionCount.push(t);
      offset += 4;
    }
    this.RankString = getChar(hex, 0x19BE, 32);
    this.debriefMissionScore = getInt(hex, 0x19DE);
    this.debriefFullKillsOnPlayer = [];
    offset = 0x19E2;
    for (let i = 0; i < 8; i++) {
      const t = getInt(hex, offset);
      this.debriefFullKillsOnPlayer.push(t);
      offset += 4;
    }
    this.debriefSharedKillsOnPlayer = [];
    offset = 0x1A02;
    for (let i = 0; i < 8; i++) {
      const t = getInt(hex, offset);
      this.debriefSharedKillsOnPlayer.push(t);
      offset += 4;
    }
    this.debriefFullKillsOnFG = [];
    offset = 0x1A22;
    for (let i = 0; i < 48; i++) {
      const t = getInt(hex, offset);
      this.debriefFullKillsOnFG.push(t);
      offset += 4;
    }
    this.debriefSharedKillsOnFG = [];
    offset = 0x1AE2;
    for (let i = 0; i < 48; i++) {
      const t = getInt(hex, offset);
      this.debriefSharedKillsOnFG.push(t);
      offset += 4;
    }
    this.debriefFullKillsByPlayer = [];
    offset = 0x1BA2;
    for (let i = 0; i < 8; i++) {
      const t = getInt(hex, offset);
      this.debriefFullKillsByPlayer.push(t);
      offset += 4;
    }
    this.debriefSharedKillsByPlayer = [];
    offset = 0x1BC2;
    for (let i = 0; i < 8; i++) {
      const t = getInt(hex, offset);
      this.debriefSharedKillsByPlayer.push(t);
      offset += 4;
    }
    this.debriefFullKillsByFG = [];
    offset = 0x1BE2;
    for (let i = 0; i < 48; i++) {
      const t = getInt(hex, offset);
      this.debriefFullKillsByFG.push(t);
      offset += 4;
    }
    this.debriefSharedKillsByFG = [];
    offset = 0x1CA2;
    for (let i = 0; i < 48; i++) {
      const t = getInt(hex, offset);
      this.debriefSharedKillsByFG.push(t);
      offset += 4;
    }
    this.debriefMeleeAIRankFG = [];
    offset = 0x1D62;
    for (let i = 0; i < 48; i++) {
      const t = getInt(hex, offset);
      this.debriefMeleeAIRankFG.push(t);
      offset += 4;
    }
    this.debrief = new PL2DebriefRecord(hex.slice(0x1E22), this.TIE);
    this.connectedPlayerData = [];
    offset = 0x32AA;
    for (let i = 0; i < 8; i++) {
      const t = new PLTConnectedPlayerData(hex.slice(offset), this.TIE);
      this.connectedPlayerData.push(t);
      offset += t.getLength();
    }
    this.debriefTeamResult = [];
    offset = 0x356A;
    for (let i = 0; i < 10; i++) {
      const t = new PLTTeamResultRecord(hex.slice(offset), this.TIE);
      this.debriefTeamResult.push(t);
      offset += t.getLength();
    }
    this.SelectedFaction = getInt(hex, 0x3682);
    this.faction = [];
    offset = 0x3686;
    for (let i = 0; i < 4; i++) {
      const t = new PL2FactionRecord(hex.slice(offset), this.TIE);
      this.faction.push(t);
      offset += t.getLength();
    }
    this.activeCampaign = new PL2CampaignProgressState(hex.slice(0x45E06), this.TIE);
    this.gap45E1E = [];
    offset = 0x45E1E;
    for (let i = 0; i < 4; i++) {
      const t = getByte(hex, offset);
      this.gap45E1E.push(t);
      offset += 1;
    }
    this.spBattleState = [];
    offset = 0x45E22;
    for (let i = 0; i < 25; i++) {
      const t = new PLTBattleState(hex.slice(offset), this.TIE);
      this.spBattleState.push(t);
      offset += t.getLength();
    }
    this.mpBattleState = [];
    offset = 0x46DC2;
    for (let i = 0; i < 25; i++) {
      const t = new PLTBattleState(hex.slice(offset), this.TIE);
      this.mpBattleState.push(t);
      offset += t.getLength();
    }
    this.spCampaignState = [];
    offset = 0x47D62;
    for (let i = 0; i < 25; i++) {
      const t = new PL2CampaignState(hex.slice(offset), this.TIE);
      this.spCampaignState.push(t);
      offset += t.getLength();
    }
    this.mpCampaignHostState = [];
    offset = 0x4814A;
    for (let i = 0; i < 12; i++) {
      const t = new PL2CampaignState(hex.slice(offset), this.TIE);
      this.mpCampaignHostState.push(t);
      offset += t.getLength();
    }
    this.mpCampaignClientState = [];
    offset = 0x4832A;
    for (let i = 0; i < 12; i++) {
      const t = new PL2CampaignState(hex.slice(offset), this.TIE);
      this.mpCampaignClientState.push(t);
      offset += t.getLength();
    }
    this.anonymous_259 = [];
    offset = 0x4850A;
    for (let i = 0; i < 8; i++) {
      const t = getInt(hex, offset);
      this.anonymous_259.push(t);
      offset += 4;
    }
    this.anonymous_260 = getShort(hex, 0x4852A);
    this.anonymous_261 = getShort(hex, 0x4852C);
    
  }
  
  public toJSON(): object {
    return {
      PilotName: this.PilotName,
      totalScore: this.totalScore,
      PlayerID: this.PlayerID,
      continuedOrReflownMission: this.continuedOrReflownMission,
      isHosting: this.isHosting,
      numHumanPlayersInMission: this.numHumanPlayersInMission,
      frontFlyMode: this.frontFlyMode,
      unknown0x26: this.unknown0x26,
      unknown0x166: this.unknown0x166,
      unknown0x186: this.unknown0x186,
      activeMissionTeam: this.activeMissionTeam,
      MissionFolderIndex: this.MissionFolderIndex,
      SelectedIDNumOfMissionCategory: this.SelectedIDNumOfMissionCategory,
      GameName: this.GameName,
      LastGameName: this.LastGameName,
      isMissionCategorySeries: this.isMissionCategorySeries,
      activeMissionIDNum: this.activeMissionIDNum,
      PromoPoints: this.PromoPoints,
      WorsePromoPoints: this.WorsePromoPoints,
      RankAdjustmentApplied: this.RankAdjustmentApplied,
      PercentToNextRank: this.PercentToNextRank,
      numFlownNonSeries: this.numFlownNonSeries,
      numFlownSeries: this.numFlownSeries,
      totalKillCount: this.totalKillCount,
      totalFriendlyKillCount: this.totalFriendlyKillCount,
      totalKillCountByCraftType: this.totalKillCountByCraftType,
      totalFullKillsOnPlayerRank: this.totalFullKillsOnPlayerRank,
      totalSharedKillsOnPlayerRank: this.totalSharedKillsOnPlayerRank,
      totalAssistKillsOnPlayerRank: this.totalAssistKillsOnPlayerRank,
      totalFullKillsOnAIRank: this.totalFullKillsOnAIRank,
      totalSharedKillsOnAIRank: this.totalSharedKillsOnAIRank,
      totalAssistKillsOnAIRank: this.totalAssistKillsOnAIRank,
      totalHiddenCargoFound: this.totalHiddenCargoFound,
      totalLaserHit: this.totalLaserHit,
      totalLaserFired: this.totalLaserFired,
      totalWarheadHit: this.totalWarheadHit,
      totalWarheadFired: this.totalWarheadFired,
      totalCraftLosses: this.totalCraftLosses,
      totalLossesFromCollision: this.totalLossesFromCollision,
      totalLossesFromStarships: this.totalLossesFromStarships,
      totalLossesFromMines: this.totalLossesFromMines,
      totalLossesFromPlayerRank: this.totalLossesFromPlayerRank,
      totalLossesFromAIRank: this.totalLossesFromAIRank,
      activeTournament: this.activeTournament,
      activeBattle: this.activeBattle,
      CurrentRank: this.CurrentRank,
      totalCountMissionsFlown: this.totalCountMissionsFlown,
      RankAchievedOnMissionCount: this.RankAchievedOnMissionCount,
      RankString: this.RankString,
      debriefMissionScore: this.debriefMissionScore,
      debriefFullKillsOnPlayer: this.debriefFullKillsOnPlayer,
      debriefSharedKillsOnPlayer: this.debriefSharedKillsOnPlayer,
      debriefFullKillsOnFG: this.debriefFullKillsOnFG,
      debriefSharedKillsOnFG: this.debriefSharedKillsOnFG,
      debriefFullKillsByPlayer: this.debriefFullKillsByPlayer,
      debriefSharedKillsByPlayer: this.debriefSharedKillsByPlayer,
      debriefFullKillsByFG: this.debriefFullKillsByFG,
      debriefSharedKillsByFG: this.debriefSharedKillsByFG,
      debriefMeleeAIRankFG: this.debriefMeleeAIRankFG,
      debrief: this.debrief,
      connectedPlayerData: this.connectedPlayerData,
      debriefTeamResult: this.debriefTeamResult,
      SelectedFaction: this.SelectedFaction,
      faction: this.faction,
      activeCampaign: this.activeCampaign,
      gap45E1E: this.gap45E1E,
      spBattleState: this.spBattleState,
      mpBattleState: this.mpBattleState,
      spCampaignState: this.spCampaignState,
      mpCampaignHostState: this.mpCampaignHostState,
      mpCampaignClientState: this.mpCampaignClientState,
      anonymous_259: this.anonymous_259,
      anonymous_260: this.anonymous_260,
      anonymous_261: this.anonymous_261
    };
  }
  
  public toHexString(): string {
    let hex: string = '';
    let offset = 0;

    writeChar(hex, this.PilotName, 0x0000);
    writeObject(hex, this.totalScore, 0x033E);
    writeInt(hex, this.PlayerID, 0x0012);
    writeInt(hex, this.continuedOrReflownMission, 0x0016);
    writeInt(hex, this.isHosting, 0x001A);
    writeInt(hex, this.numHumanPlayersInMission, 0x001E);
    writeInt(hex, this.frontFlyMode, 0x0022);
    offset = 0x0026;
    for (let i = 0; i < 80; i++) {
      const t = this.unknown0x26[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x0166;
    for (let i = 0; i < 8; i++) {
      const t = this.unknown0x166[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x0186;
    for (let i = 0; i < 80; i++) {
      const t = this.unknown0x186[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    writeInt(hex, this.activeMissionTeam, 0x02C6);
    writeInt(hex, this.MissionFolderIndex, 0x02CA);
    offset = 0x02CE;
    for (let i = 0; i < 6; i++) {
      const t = this.SelectedIDNumOfMissionCategory[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    writeChar(hex, this.GameName, 0x02E6);
    writeChar(hex, this.LastGameName, 0x0306);
    writeInt(hex, this.isMissionCategorySeries, 0x0326);
    writeInt(hex, this.activeMissionIDNum, 0x032A);
    writeInt(hex, this.PromoPoints, 0x032E);
    writeInt(hex, this.WorsePromoPoints, 0x0332);
    writeInt(hex, this.RankAdjustmentApplied, 0x0336);
    writeInt(hex, this.PercentToNextRank, 0x033A);
    writeObject(hex, this.numFlownNonSeries, 0x034A);
    writeObject(hex, this.numFlownSeries, 0x0356);
    writeObject(hex, this.totalKillCount, 0x0362);
    writeObject(hex, this.totalFriendlyKillCount, 0x036E);
    offset = 0x037A;
    for (let i = 0; i < 900; i++) {
      const t = this.totalKillCountByCraftType[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    writeObject(hex, this.totalFullKillsOnPlayerRank, 0x118A);
    writeObject(hex, this.totalSharedKillsOnPlayerRank, 0x12B6);
    writeObject(hex, this.totalAssistKillsOnPlayerRank, 0x13E2);
    writeObject(hex, this.totalFullKillsOnAIRank, 0x150E);
    writeObject(hex, this.totalSharedKillsOnAIRank, 0x1556);
    writeObject(hex, this.totalAssistKillsOnAIRank, 0x159E);
    writeObject(hex, this.totalHiddenCargoFound, 0x15E6);
    writeObject(hex, this.totalLaserHit, 0x15F2);
    writeObject(hex, this.totalLaserFired, 0x15FE);
    writeObject(hex, this.totalWarheadHit, 0x160A);
    writeObject(hex, this.totalWarheadFired, 0x1616);
    writeObject(hex, this.totalCraftLosses, 0x1622);
    writeObject(hex, this.totalLossesFromCollision, 0x162E);
    writeObject(hex, this.totalLossesFromStarships, 0x163A);
    writeObject(hex, this.totalLossesFromMines, 0x1646);
    writeObject(hex, this.totalLossesFromPlayerRank, 0x1652);
    writeObject(hex, this.totalLossesFromAIRank, 0x177E);
    writeObject(hex, this.activeTournament, 0x17C6);
    writeObject(hex, this.activeBattle, 0x18C6);
    writeInt(hex, this.CurrentRank, 0x1952);
    writeInt(hex, this.totalCountMissionsFlown, 0x1956);
    offset = 0x195A;
    for (let i = 0; i < 25; i++) {
      const t = this.RankAchievedOnMissionCount[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    writeChar(hex, this.RankString, 0x19BE);
    writeInt(hex, this.debriefMissionScore, 0x19DE);
    offset = 0x19E2;
    for (let i = 0; i < 8; i++) {
      const t = this.debriefFullKillsOnPlayer[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x1A02;
    for (let i = 0; i < 8; i++) {
      const t = this.debriefSharedKillsOnPlayer[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x1A22;
    for (let i = 0; i < 48; i++) {
      const t = this.debriefFullKillsOnFG[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x1AE2;
    for (let i = 0; i < 48; i++) {
      const t = this.debriefSharedKillsOnFG[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x1BA2;
    for (let i = 0; i < 8; i++) {
      const t = this.debriefFullKillsByPlayer[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x1BC2;
    for (let i = 0; i < 8; i++) {
      const t = this.debriefSharedKillsByPlayer[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x1BE2;
    for (let i = 0; i < 48; i++) {
      const t = this.debriefFullKillsByFG[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x1CA2;
    for (let i = 0; i < 48; i++) {
      const t = this.debriefSharedKillsByFG[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x1D62;
    for (let i = 0; i < 48; i++) {
      const t = this.debriefMeleeAIRankFG[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    writeObject(hex, this.debrief, 0x1E22);
    offset = 0x32AA;
    for (let i = 0; i < 8; i++) {
      const t = this.connectedPlayerData[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    offset = 0x356A;
    for (let i = 0; i < 10; i++) {
      const t = this.debriefTeamResult[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    writeInt(hex, this.SelectedFaction, 0x3682);
    offset = 0x3686;
    for (let i = 0; i < 4; i++) {
      const t = this.faction[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    writeObject(hex, this.activeCampaign, 0x45E06);
    offset = 0x45E1E;
    for (let i = 0; i < 4; i++) {
      const t = this.gap45E1E[i];
      writeByte(hex, t, offset);
      offset += 1;
    }
    offset = 0x45E22;
    for (let i = 0; i < 25; i++) {
      const t = this.spBattleState[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    offset = 0x46DC2;
    for (let i = 0; i < 25; i++) {
      const t = this.mpBattleState[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    offset = 0x47D62;
    for (let i = 0; i < 25; i++) {
      const t = this.spCampaignState[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    offset = 0x4814A;
    for (let i = 0; i < 12; i++) {
      const t = this.mpCampaignHostState[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    offset = 0x4832A;
    for (let i = 0; i < 12; i++) {
      const t = this.mpCampaignClientState[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    offset = 0x4850A;
    for (let i = 0; i < 8; i++) {
      const t = this.anonymous_259[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    writeShort(hex, this.anonymous_260, 0x4852A);
    writeShort(hex, this.anonymous_261, 0x4852C);

    return hex;
  }
  
  
  public getLength(): number {
    return this.PL2FILERECORDLENGTH;
  }
}