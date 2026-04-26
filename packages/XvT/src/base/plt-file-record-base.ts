import { Byteable } from "../../../core/src/byteable";
import { IMission, PyriteBase } from "../../../core/src/pyrite-base";
import { PLTAIRankCountRecord } from "../pltai-rank-count-record";
import { PLTCategoryTypeRecord } from "../plt-category-type-record";
import { PLTConnectedPlayerData } from "../plt-connected-player-data";
import { PLTFactionRecord } from "../plt-faction-record";
import { PLTPlayerRankCountRecord } from "../plt-player-rank-count-record";
import { PLTTeamResultRecord } from "../plt-team-result-record";
import { PLTTournTeamRecord } from "../plt-tourn-team-record";
import { getByte, getChar, getInt, writeByte, writeChar, writeInt, writeObject } from "../../../core/src/hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class PLTFileRecordBase extends PyriteBase implements Byteable {
  public readonly PLTFILERECORDLENGTH: number = 253754;
  public PilotName: string;
  public totalScore: number;
  public PlayerID: number;
  public continuedOrReflownMission: number;
  public isHosting: number;
  public numHumanPlayersInMission: number;
  public frontFlyMode: number;
  public unknown0x26: number[];
  public unknown0x166: number[];
  public unknown0x186: number[];
  public lastTeamNumber: number;
  public lastSelectedMissionType: number;
  public lastSelectedTraining: number;
  public lastSelectedMelee: number;
  public lastSelectedTournament: number;
  public lastSelectedCombat: number;
  public lastSelectedBattle: number;
  public GameNameString: string;
  public unknown0x2F8: number[];
  public GameNameString2: string;
  public unknown0x318: number[];
  public lastMissionWasNonSpecific: number;
  public unknown0x326: number;
  public PromoPoints: number;
  public WorsePromoPoints: number;
  public RankAdjustmentApplied: number;
  public PercentToNextRank: number;
  public totalCategoryScore: PLTCategoryTypeRecord;
  public numFlownNonSeries: PLTCategoryTypeRecord;
  public numFlownSeries: PLTCategoryTypeRecord;
  public totalKillCount: PLTCategoryTypeRecord;
  public numVanillaFriendlyKills: PLTCategoryTypeRecord;
  public totalCraftFullKillsExercise: number[];
  public totalCraftFullKillsMelee: number[];
  public totalCraftFullKillsCombat: number[];
  public totalCraftSharedKillsExercise: number[];
  public totalCraftSharedKillsMelee: number[];
  public totalCraftSharedKillsCombat: number[];
  public totalCraftAssistKillsExercise: number[];
  public totalCraftAssistKillsMelee: number[];
  public totalCraftAssistKillsCombat: number[];
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
  public unknown0x1612: number[];
  public unknownPlaqueWon: number;
  public TournTeamRecords: PLTTournTeamRecord[];
  public numHumanPlayersUNK: number;
  public numTeamsUNK: number;
  public unknown0x170E: number;
  public unknown0x1712: number;
  public numCombatFlownInLastBattle: number;
  public unknown0x171A: number[];
  public battleCombatMissionID: number[];
  public unknown0x1F2E: number[];
  public totalScoreForCurrentBattleUNK: number;
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
  public UnknownRecord1: PLTCategoryTypeRecord;
  public UnknownRecord2: PLTCategoryTypeRecord;
  public UnknownRecord3: PLTCategoryTypeRecord;
  public debriefEnemyKills: PLTCategoryTypeRecord;
  public debriefFriendlyKills: PLTCategoryTypeRecord;
  public debriefFullKillsByShipTypeA: number[];
  public debriefFullKillsByShipTypeB: number[];
  public debriefFullKillsByShipTypeC: number[];
  public debriefSharedKillsByShipTypeA: number[];
  public debriefSharedKillsByShipTypeB: number[];
  public debriefSharedKillsByShipTypeC: number[];
  public debriefAssistKillsByShipTypeA: number[];
  public debriefAssistKillsByShipTypeB: number[];
  public debriefAssistKillsByShipTypeC: number[];
  public debriefFullKillsOnPlayerRank: PLTPlayerRankCountRecord;
  public debriefSharedKillsOnPlayerRank: PLTPlayerRankCountRecord;
  public debriefAssistKillsOnPlayerRank: PLTPlayerRankCountRecord;
  public debriefFullKillsOnAIRank: PLTAIRankCountRecord;
  public debriefSharedKillsOnAIRank: PLTAIRankCountRecord;
  public debriefAssistKillsOnAIRank: PLTAIRankCountRecord;
  public debriefNumHiddenCargoFound: PLTCategoryTypeRecord;
  public debriefNumCannonHits: PLTCategoryTypeRecord;
  public debriefNumCannonFired: PLTCategoryTypeRecord;
  public debriefNumWarheadHits: PLTCategoryTypeRecord;
  public debriefNumWarheadFired: PLTCategoryTypeRecord;
  public debriefNumCraftLosses: PLTCategoryTypeRecord;
  public debriefCraftLossesFromCollision: PLTCategoryTypeRecord;
  public debriefCraftLossesFromStarship: PLTCategoryTypeRecord;
  public debriefCraftLossesFromMine: PLTCategoryTypeRecord;
  public debriefLossesFromPlayerRank: PLTPlayerRankCountRecord;
  public debriefLossesFromAIRank: PLTAIRankCountRecord;
  public connectedPlayerData: PLTConnectedPlayerData[];
  public debriefTeamResult: PLTTeamResultRecord[];
  public lastSelectedFaction: number;
  public rebelSingleplayerData: PLTFactionRecord;
  public imperialSingleplayerData: PLTFactionRecord;
  public rebelMultiplayerData: PLTFactionRecord;
  public imperialMultiplayerData: PLTFactionRecord;
  
  constructor(hex: ArrayBuffer, tie?: IMission) {
    super(hex, tie);
    this.beforeConstruct();
    let offset = 0;

    this.PilotName = getChar(hex, 0x0000, 14);
    this.totalScore = getInt(hex, 0x000E);
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
    this.lastTeamNumber = getInt(hex, 0x02C6);
    this.lastSelectedMissionType = getInt(hex, 0x02CA);
    this.lastSelectedTraining = getInt(hex, 0x02CE);
    this.lastSelectedMelee = getInt(hex, 0x02D2);
    this.lastSelectedTournament = getInt(hex, 0x02D6);
    this.lastSelectedCombat = getInt(hex, 0x02DA);
    this.lastSelectedBattle = getInt(hex, 0x02DE);
    this.GameNameString = getChar(hex, 0x02E2, 22);
    this.unknown0x2F8 = [];
    offset = 0x02F8;
    for (let i = 0; i < 10; i++) {
      const t = getByte(hex, offset);
      this.unknown0x2F8.push(t);
      offset += 1;
    }
    this.GameNameString2 = getChar(hex, 0x0302, 22);
    this.unknown0x318 = [];
    offset = 0x0318;
    for (let i = 0; i < 10; i++) {
      const t = getByte(hex, offset);
      this.unknown0x318.push(t);
      offset += 1;
    }
    this.lastMissionWasNonSpecific = getInt(hex, 0x0322);
    this.unknown0x326 = getInt(hex, 0x0326);
    this.PromoPoints = getInt(hex, 0x032A);
    this.WorsePromoPoints = getInt(hex, 0x032E);
    this.RankAdjustmentApplied = getInt(hex, 0x0332);
    this.PercentToNextRank = getInt(hex, 0x0336);
    this.totalCategoryScore = new PLTCategoryTypeRecord(hex.slice(0x033A), this.TIE);
    this.numFlownNonSeries = new PLTCategoryTypeRecord(hex.slice(0x0346), this.TIE);
    this.numFlownSeries = new PLTCategoryTypeRecord(hex.slice(0x0352), this.TIE);
    this.totalKillCount = new PLTCategoryTypeRecord(hex.slice(0x035E), this.TIE);
    this.numVanillaFriendlyKills = new PLTCategoryTypeRecord(hex.slice(0x036A), this.TIE);
    this.totalCraftFullKillsExercise = [];
    offset = 0x0376;
    for (let i = 0; i < 88; i++) {
      const t = getInt(hex, offset);
      this.totalCraftFullKillsExercise.push(t);
      offset += 4;
    }
    this.totalCraftFullKillsMelee = [];
    offset = 0x04D6;
    for (let i = 0; i < 88; i++) {
      const t = getInt(hex, offset);
      this.totalCraftFullKillsMelee.push(t);
      offset += 4;
    }
    this.totalCraftFullKillsCombat = [];
    offset = 0x0636;
    for (let i = 0; i < 88; i++) {
      const t = getInt(hex, offset);
      this.totalCraftFullKillsCombat.push(t);
      offset += 4;
    }
    this.totalCraftSharedKillsExercise = [];
    offset = 0x0796;
    for (let i = 0; i < 88; i++) {
      const t = getInt(hex, offset);
      this.totalCraftSharedKillsExercise.push(t);
      offset += 4;
    }
    this.totalCraftSharedKillsMelee = [];
    offset = 0x08F6;
    for (let i = 0; i < 88; i++) {
      const t = getInt(hex, offset);
      this.totalCraftSharedKillsMelee.push(t);
      offset += 4;
    }
    this.totalCraftSharedKillsCombat = [];
    offset = 0x0A56;
    for (let i = 0; i < 88; i++) {
      const t = getInt(hex, offset);
      this.totalCraftSharedKillsCombat.push(t);
      offset += 4;
    }
    this.totalCraftAssistKillsExercise = [];
    offset = 0x0BB6;
    for (let i = 0; i < 88; i++) {
      const t = getInt(hex, offset);
      this.totalCraftAssistKillsExercise.push(t);
      offset += 4;
    }
    this.totalCraftAssistKillsMelee = [];
    offset = 0x0D16;
    for (let i = 0; i < 88; i++) {
      const t = getInt(hex, offset);
      this.totalCraftAssistKillsMelee.push(t);
      offset += 4;
    }
    this.totalCraftAssistKillsCombat = [];
    offset = 0x0E76;
    for (let i = 0; i < 88; i++) {
      const t = getInt(hex, offset);
      this.totalCraftAssistKillsCombat.push(t);
      offset += 4;
    }
    this.totalFullKillsOnPlayerRank = new PLTPlayerRankCountRecord(hex.slice(0x0FD6), this.TIE);
    this.totalSharedKillsOnPlayerRank = new PLTPlayerRankCountRecord(hex.slice(0x1102), this.TIE);
    this.totalAssistKillsOnPlayerRank = new PLTPlayerRankCountRecord(hex.slice(0x122E), this.TIE);
    this.totalFullKillsOnAIRank = new PLTAIRankCountRecord(hex.slice(0x135A), this.TIE);
    this.totalSharedKillsOnAIRank = new PLTAIRankCountRecord(hex.slice(0x13A2), this.TIE);
    this.totalAssistKillsOnAIRank = new PLTAIRankCountRecord(hex.slice(0x13EA), this.TIE);
    this.totalHiddenCargoFound = new PLTCategoryTypeRecord(hex.slice(0x1432), this.TIE);
    this.totalLaserHit = new PLTCategoryTypeRecord(hex.slice(0x143E), this.TIE);
    this.totalLaserFired = new PLTCategoryTypeRecord(hex.slice(0x144A), this.TIE);
    this.totalWarheadHit = new PLTCategoryTypeRecord(hex.slice(0x1456), this.TIE);
    this.totalWarheadFired = new PLTCategoryTypeRecord(hex.slice(0x1462), this.TIE);
    this.totalCraftLosses = new PLTCategoryTypeRecord(hex.slice(0x146E), this.TIE);
    this.totalLossesFromCollision = new PLTCategoryTypeRecord(hex.slice(0x147A), this.TIE);
    this.totalLossesFromStarships = new PLTCategoryTypeRecord(hex.slice(0x1486), this.TIE);
    this.totalLossesFromMines = new PLTCategoryTypeRecord(hex.slice(0x1492), this.TIE);
    this.totalLossesFromPlayerRank = new PLTPlayerRankCountRecord(hex.slice(0x149E), this.TIE);
    this.totalLossesFromAIRank = new PLTAIRankCountRecord(hex.slice(0x15CA), this.TIE);
    this.unknown0x1612 = [];
    offset = 0x1612;
    for (let i = 0; i < 40; i++) {
      const t = getByte(hex, offset);
      this.unknown0x1612.push(t);
      offset += 1;
    }
    this.unknownPlaqueWon = getInt(hex, 0x163A);
    this.TournTeamRecords = [];
    offset = 0x163E;
    for (let i = 0; i < 10; i++) {
      const t = new PLTTournTeamRecord(hex.slice(offset), this.TIE);
      this.TournTeamRecords.push(t);
      offset += t.getLength();
    }
    this.numHumanPlayersUNK = getInt(hex, 0x1706);
    this.numTeamsUNK = getInt(hex, 0x170A);
    this.unknown0x170E = getInt(hex, 0x170E);
    this.unknown0x1712 = getInt(hex, 0x1712);
    this.numCombatFlownInLastBattle = getInt(hex, 0x1716);
    this.unknown0x171A = [];
    offset = 0x171A;
    for (let i = 0; i < 2052; i++) {
      const t = getByte(hex, offset);
      this.unknown0x171A.push(t);
      offset += 1;
    }
    this.battleCombatMissionID = [];
    offset = 0x1F1E;
    for (let i = 0; i < 4; i++) {
      const t = getInt(hex, offset);
      this.battleCombatMissionID.push(t);
      offset += 4;
    }
    this.unknown0x1F2E = [];
    offset = 0x1F2E;
    for (let i = 0; i < 1012; i++) {
      const t = getByte(hex, offset);
      this.unknown0x1F2E.push(t);
      offset += 1;
    }
    this.totalScoreForCurrentBattleUNK = getInt(hex, 0x2322);
    this.CurrentRank = getInt(hex, 0x2326);
    this.totalCountMissionsFlown = getInt(hex, 0x232A);
    this.RankAchievedOnMissionCount = [];
    offset = 0x232E;
    for (let i = 0; i < 25; i++) {
      const t = getInt(hex, offset);
      this.RankAchievedOnMissionCount.push(t);
      offset += 4;
    }
    this.RankString = getChar(hex, 0x2392, 32);
    this.debriefMissionScore = getInt(hex, 0x23B2);
    this.debriefFullKillsOnPlayer = [];
    offset = 0x23B6;
    for (let i = 0; i < 8; i++) {
      const t = getInt(hex, offset);
      this.debriefFullKillsOnPlayer.push(t);
      offset += 4;
    }
    this.debriefSharedKillsOnPlayer = [];
    offset = 0x23D6;
    for (let i = 0; i < 8; i++) {
      const t = getInt(hex, offset);
      this.debriefSharedKillsOnPlayer.push(t);
      offset += 4;
    }
    this.debriefFullKillsOnFG = [];
    offset = 0x23F6;
    for (let i = 0; i < 48; i++) {
      const t = getInt(hex, offset);
      this.debriefFullKillsOnFG.push(t);
      offset += 4;
    }
    this.debriefSharedKillsOnFG = [];
    offset = 0x24B6;
    for (let i = 0; i < 48; i++) {
      const t = getInt(hex, offset);
      this.debriefSharedKillsOnFG.push(t);
      offset += 4;
    }
    this.debriefFullKillsByPlayer = [];
    offset = 0x2576;
    for (let i = 0; i < 8; i++) {
      const t = getInt(hex, offset);
      this.debriefFullKillsByPlayer.push(t);
      offset += 4;
    }
    this.debriefSharedKillsByPlayer = [];
    offset = 0x2596;
    for (let i = 0; i < 8; i++) {
      const t = getInt(hex, offset);
      this.debriefSharedKillsByPlayer.push(t);
      offset += 4;
    }
    this.debriefFullKillsByFG = [];
    offset = 0x25B6;
    for (let i = 0; i < 48; i++) {
      const t = getInt(hex, offset);
      this.debriefFullKillsByFG.push(t);
      offset += 4;
    }
    this.debriefSharedKillsByFG = [];
    offset = 0x2676;
    for (let i = 0; i < 48; i++) {
      const t = getInt(hex, offset);
      this.debriefSharedKillsByFG.push(t);
      offset += 4;
    }
    this.debriefMeleeAIRankFG = [];
    offset = 0x2736;
    for (let i = 0; i < 48; i++) {
      const t = getInt(hex, offset);
      this.debriefMeleeAIRankFG.push(t);
      offset += 4;
    }
    this.UnknownRecord1 = new PLTCategoryTypeRecord(hex.slice(0x27F6), this.TIE);
    this.UnknownRecord2 = new PLTCategoryTypeRecord(hex.slice(0x2802), this.TIE);
    this.UnknownRecord3 = new PLTCategoryTypeRecord(hex.slice(0x280E), this.TIE);
    this.debriefEnemyKills = new PLTCategoryTypeRecord(hex.slice(0x281A), this.TIE);
    this.debriefFriendlyKills = new PLTCategoryTypeRecord(hex.slice(0x2826), this.TIE);
    this.debriefFullKillsByShipTypeA = [];
    offset = 0x2832;
    for (let i = 0; i < 88; i++) {
      const t = getInt(hex, offset);
      this.debriefFullKillsByShipTypeA.push(t);
      offset += 4;
    }
    this.debriefFullKillsByShipTypeB = [];
    offset = 0x2992;
    for (let i = 0; i < 88; i++) {
      const t = getInt(hex, offset);
      this.debriefFullKillsByShipTypeB.push(t);
      offset += 4;
    }
    this.debriefFullKillsByShipTypeC = [];
    offset = 0x2AF2;
    for (let i = 0; i < 88; i++) {
      const t = getInt(hex, offset);
      this.debriefFullKillsByShipTypeC.push(t);
      offset += 4;
    }
    this.debriefSharedKillsByShipTypeA = [];
    offset = 0x2C52;
    for (let i = 0; i < 88; i++) {
      const t = getInt(hex, offset);
      this.debriefSharedKillsByShipTypeA.push(t);
      offset += 4;
    }
    this.debriefSharedKillsByShipTypeB = [];
    offset = 0x2DB2;
    for (let i = 0; i < 88; i++) {
      const t = getInt(hex, offset);
      this.debriefSharedKillsByShipTypeB.push(t);
      offset += 4;
    }
    this.debriefSharedKillsByShipTypeC = [];
    offset = 0x2F12;
    for (let i = 0; i < 88; i++) {
      const t = getInt(hex, offset);
      this.debriefSharedKillsByShipTypeC.push(t);
      offset += 4;
    }
    this.debriefAssistKillsByShipTypeA = [];
    offset = 0x3072;
    for (let i = 0; i < 88; i++) {
      const t = getInt(hex, offset);
      this.debriefAssistKillsByShipTypeA.push(t);
      offset += 4;
    }
    this.debriefAssistKillsByShipTypeB = [];
    offset = 0x31D2;
    for (let i = 0; i < 88; i++) {
      const t = getInt(hex, offset);
      this.debriefAssistKillsByShipTypeB.push(t);
      offset += 4;
    }
    this.debriefAssistKillsByShipTypeC = [];
    offset = 0x3332;
    for (let i = 0; i < 88; i++) {
      const t = getInt(hex, offset);
      this.debriefAssistKillsByShipTypeC.push(t);
      offset += 4;
    }
    this.debriefFullKillsOnPlayerRank = new PLTPlayerRankCountRecord(hex.slice(0x3492), this.TIE);
    this.debriefSharedKillsOnPlayerRank = new PLTPlayerRankCountRecord(hex.slice(0x35BE), this.TIE);
    this.debriefAssistKillsOnPlayerRank = new PLTPlayerRankCountRecord(hex.slice(0x36EA), this.TIE);
    this.debriefFullKillsOnAIRank = new PLTAIRankCountRecord(hex.slice(0x3816), this.TIE);
    this.debriefSharedKillsOnAIRank = new PLTAIRankCountRecord(hex.slice(0x385E), this.TIE);
    this.debriefAssistKillsOnAIRank = new PLTAIRankCountRecord(hex.slice(0x38A6), this.TIE);
    this.debriefNumHiddenCargoFound = new PLTCategoryTypeRecord(hex.slice(0x38EE), this.TIE);
    this.debriefNumCannonHits = new PLTCategoryTypeRecord(hex.slice(0x38FA), this.TIE);
    this.debriefNumCannonFired = new PLTCategoryTypeRecord(hex.slice(0x3906), this.TIE);
    this.debriefNumWarheadHits = new PLTCategoryTypeRecord(hex.slice(0x3912), this.TIE);
    this.debriefNumWarheadFired = new PLTCategoryTypeRecord(hex.slice(0x391E), this.TIE);
    this.debriefNumCraftLosses = new PLTCategoryTypeRecord(hex.slice(0x392A), this.TIE);
    this.debriefCraftLossesFromCollision = new PLTCategoryTypeRecord(hex.slice(0x3936), this.TIE);
    this.debriefCraftLossesFromStarship = new PLTCategoryTypeRecord(hex.slice(0x3942), this.TIE);
    this.debriefCraftLossesFromMine = new PLTCategoryTypeRecord(hex.slice(0x394E), this.TIE);
    this.debriefLossesFromPlayerRank = new PLTPlayerRankCountRecord(hex.slice(0x395A), this.TIE);
    this.debriefLossesFromAIRank = new PLTAIRankCountRecord(hex.slice(0x3A86), this.TIE);
    this.connectedPlayerData = [];
    offset = 0x3ACE;
    for (let i = 0; i < 8; i++) {
      const t = new PLTConnectedPlayerData(hex.slice(offset), this.TIE);
      this.connectedPlayerData.push(t);
      offset += t.getLength();
    }
    this.debriefTeamResult = [];
    offset = 0x3D8E;
    for (let i = 0; i < 10; i++) {
      const t = new PLTTeamResultRecord(hex.slice(offset), this.TIE);
      this.debriefTeamResult.push(t);
      offset += t.getLength();
    }
    this.lastSelectedFaction = getInt(hex, 0x3EA6);
    this.rebelSingleplayerData = new PLTFactionRecord(hex.slice(0x3EAA), this.TIE);
    this.imperialSingleplayerData = new PLTFactionRecord(hex.slice(0x126CE), this.TIE);
    this.rebelMultiplayerData = new PLTFactionRecord(hex.slice(0x20EF2), this.TIE);
    this.imperialMultiplayerData = new PLTFactionRecord(hex.slice(0x2F716), this.TIE);
    
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
      lastTeamNumber: this.lastTeamNumber,
      lastSelectedMissionType: this.lastSelectedMissionType,
      lastSelectedTraining: this.lastSelectedTraining,
      lastSelectedMelee: this.lastSelectedMelee,
      lastSelectedTournament: this.lastSelectedTournament,
      lastSelectedCombat: this.lastSelectedCombat,
      lastSelectedBattle: this.lastSelectedBattle,
      GameNameString: this.GameNameString,
      unknown0x2F8: this.unknown0x2F8,
      GameNameString2: this.GameNameString2,
      unknown0x318: this.unknown0x318,
      lastMissionWasNonSpecific: this.lastMissionWasNonSpecific,
      unknown0x326: this.unknown0x326,
      PromoPoints: this.PromoPoints,
      WorsePromoPoints: this.WorsePromoPoints,
      RankAdjustmentApplied: this.RankAdjustmentApplied,
      PercentToNextRank: this.PercentToNextRank,
      totalCategoryScore: this.totalCategoryScore,
      numFlownNonSeries: this.numFlownNonSeries,
      numFlownSeries: this.numFlownSeries,
      totalKillCount: this.totalKillCount,
      numVanillaFriendlyKills: this.numVanillaFriendlyKills,
      totalCraftFullKillsExercise: this.totalCraftFullKillsExercise,
      totalCraftFullKillsMelee: this.totalCraftFullKillsMelee,
      totalCraftFullKillsCombat: this.totalCraftFullKillsCombat,
      totalCraftSharedKillsExercise: this.totalCraftSharedKillsExercise,
      totalCraftSharedKillsMelee: this.totalCraftSharedKillsMelee,
      totalCraftSharedKillsCombat: this.totalCraftSharedKillsCombat,
      totalCraftAssistKillsExercise: this.totalCraftAssistKillsExercise,
      totalCraftAssistKillsMelee: this.totalCraftAssistKillsMelee,
      totalCraftAssistKillsCombat: this.totalCraftAssistKillsCombat,
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
      unknown0x1612: this.unknown0x1612,
      unknownPlaqueWon: this.unknownPlaqueWon,
      TournTeamRecords: this.TournTeamRecords,
      numHumanPlayersUNK: this.numHumanPlayersUNK,
      numTeamsUNK: this.numTeamsUNK,
      unknown0x170E: this.unknown0x170E,
      unknown0x1712: this.unknown0x1712,
      numCombatFlownInLastBattle: this.numCombatFlownInLastBattle,
      unknown0x171A: this.unknown0x171A,
      battleCombatMissionID: this.battleCombatMissionID,
      unknown0x1F2E: this.unknown0x1F2E,
      totalScoreForCurrentBattleUNK: this.totalScoreForCurrentBattleUNK,
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
      UnknownRecord1: this.UnknownRecord1,
      UnknownRecord2: this.UnknownRecord2,
      UnknownRecord3: this.UnknownRecord3,
      debriefEnemyKills: this.debriefEnemyKills,
      debriefFriendlyKills: this.debriefFriendlyKills,
      debriefFullKillsByShipTypeA: this.debriefFullKillsByShipTypeA,
      debriefFullKillsByShipTypeB: this.debriefFullKillsByShipTypeB,
      debriefFullKillsByShipTypeC: this.debriefFullKillsByShipTypeC,
      debriefSharedKillsByShipTypeA: this.debriefSharedKillsByShipTypeA,
      debriefSharedKillsByShipTypeB: this.debriefSharedKillsByShipTypeB,
      debriefSharedKillsByShipTypeC: this.debriefSharedKillsByShipTypeC,
      debriefAssistKillsByShipTypeA: this.debriefAssistKillsByShipTypeA,
      debriefAssistKillsByShipTypeB: this.debriefAssistKillsByShipTypeB,
      debriefAssistKillsByShipTypeC: this.debriefAssistKillsByShipTypeC,
      debriefFullKillsOnPlayerRank: this.debriefFullKillsOnPlayerRank,
      debriefSharedKillsOnPlayerRank: this.debriefSharedKillsOnPlayerRank,
      debriefAssistKillsOnPlayerRank: this.debriefAssistKillsOnPlayerRank,
      debriefFullKillsOnAIRank: this.debriefFullKillsOnAIRank,
      debriefSharedKillsOnAIRank: this.debriefSharedKillsOnAIRank,
      debriefAssistKillsOnAIRank: this.debriefAssistKillsOnAIRank,
      debriefNumHiddenCargoFound: this.debriefNumHiddenCargoFound,
      debriefNumCannonHits: this.debriefNumCannonHits,
      debriefNumCannonFired: this.debriefNumCannonFired,
      debriefNumWarheadHits: this.debriefNumWarheadHits,
      debriefNumWarheadFired: this.debriefNumWarheadFired,
      debriefNumCraftLosses: this.debriefNumCraftLosses,
      debriefCraftLossesFromCollision: this.debriefCraftLossesFromCollision,
      debriefCraftLossesFromStarship: this.debriefCraftLossesFromStarship,
      debriefCraftLossesFromMine: this.debriefCraftLossesFromMine,
      debriefLossesFromPlayerRank: this.debriefLossesFromPlayerRank,
      debriefLossesFromAIRank: this.debriefLossesFromAIRank,
      connectedPlayerData: this.connectedPlayerData,
      debriefTeamResult: this.debriefTeamResult,
      lastSelectedFaction: this.lastSelectedFaction,
      rebelSingleplayerData: this.rebelSingleplayerData,
      imperialSingleplayerData: this.imperialSingleplayerData,
      rebelMultiplayerData: this.rebelMultiplayerData,
      imperialMultiplayerData: this.imperialMultiplayerData
    };
  }
  
  public toHexString(): string {
    let hex: string = '';
    let offset = 0;

    writeChar(hex, this.PilotName, 0x0000);
    writeInt(hex, this.totalScore, 0x000E);
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
    writeInt(hex, this.lastTeamNumber, 0x02C6);
    writeInt(hex, this.lastSelectedMissionType, 0x02CA);
    writeInt(hex, this.lastSelectedTraining, 0x02CE);
    writeInt(hex, this.lastSelectedMelee, 0x02D2);
    writeInt(hex, this.lastSelectedTournament, 0x02D6);
    writeInt(hex, this.lastSelectedCombat, 0x02DA);
    writeInt(hex, this.lastSelectedBattle, 0x02DE);
    writeChar(hex, this.GameNameString, 0x02E2);
    offset = 0x02F8;
    for (let i = 0; i < 10; i++) {
      const t = this.unknown0x2F8[i];
      writeByte(hex, t, offset);
      offset += 1;
    }
    writeChar(hex, this.GameNameString2, 0x0302);
    offset = 0x0318;
    for (let i = 0; i < 10; i++) {
      const t = this.unknown0x318[i];
      writeByte(hex, t, offset);
      offset += 1;
    }
    writeInt(hex, this.lastMissionWasNonSpecific, 0x0322);
    writeInt(hex, this.unknown0x326, 0x0326);
    writeInt(hex, this.PromoPoints, 0x032A);
    writeInt(hex, this.WorsePromoPoints, 0x032E);
    writeInt(hex, this.RankAdjustmentApplied, 0x0332);
    writeInt(hex, this.PercentToNextRank, 0x0336);
    writeObject(hex, this.totalCategoryScore, 0x033A);
    writeObject(hex, this.numFlownNonSeries, 0x0346);
    writeObject(hex, this.numFlownSeries, 0x0352);
    writeObject(hex, this.totalKillCount, 0x035E);
    writeObject(hex, this.numVanillaFriendlyKills, 0x036A);
    offset = 0x0376;
    for (let i = 0; i < 88; i++) {
      const t = this.totalCraftFullKillsExercise[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x04D6;
    for (let i = 0; i < 88; i++) {
      const t = this.totalCraftFullKillsMelee[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x0636;
    for (let i = 0; i < 88; i++) {
      const t = this.totalCraftFullKillsCombat[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x0796;
    for (let i = 0; i < 88; i++) {
      const t = this.totalCraftSharedKillsExercise[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x08F6;
    for (let i = 0; i < 88; i++) {
      const t = this.totalCraftSharedKillsMelee[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x0A56;
    for (let i = 0; i < 88; i++) {
      const t = this.totalCraftSharedKillsCombat[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x0BB6;
    for (let i = 0; i < 88; i++) {
      const t = this.totalCraftAssistKillsExercise[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x0D16;
    for (let i = 0; i < 88; i++) {
      const t = this.totalCraftAssistKillsMelee[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x0E76;
    for (let i = 0; i < 88; i++) {
      const t = this.totalCraftAssistKillsCombat[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    writeObject(hex, this.totalFullKillsOnPlayerRank, 0x0FD6);
    writeObject(hex, this.totalSharedKillsOnPlayerRank, 0x1102);
    writeObject(hex, this.totalAssistKillsOnPlayerRank, 0x122E);
    writeObject(hex, this.totalFullKillsOnAIRank, 0x135A);
    writeObject(hex, this.totalSharedKillsOnAIRank, 0x13A2);
    writeObject(hex, this.totalAssistKillsOnAIRank, 0x13EA);
    writeObject(hex, this.totalHiddenCargoFound, 0x1432);
    writeObject(hex, this.totalLaserHit, 0x143E);
    writeObject(hex, this.totalLaserFired, 0x144A);
    writeObject(hex, this.totalWarheadHit, 0x1456);
    writeObject(hex, this.totalWarheadFired, 0x1462);
    writeObject(hex, this.totalCraftLosses, 0x146E);
    writeObject(hex, this.totalLossesFromCollision, 0x147A);
    writeObject(hex, this.totalLossesFromStarships, 0x1486);
    writeObject(hex, this.totalLossesFromMines, 0x1492);
    writeObject(hex, this.totalLossesFromPlayerRank, 0x149E);
    writeObject(hex, this.totalLossesFromAIRank, 0x15CA);
    offset = 0x1612;
    for (let i = 0; i < 40; i++) {
      const t = this.unknown0x1612[i];
      writeByte(hex, t, offset);
      offset += 1;
    }
    writeInt(hex, this.unknownPlaqueWon, 0x163A);
    offset = 0x163E;
    for (let i = 0; i < 10; i++) {
      const t = this.TournTeamRecords[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    writeInt(hex, this.numHumanPlayersUNK, 0x1706);
    writeInt(hex, this.numTeamsUNK, 0x170A);
    writeInt(hex, this.unknown0x170E, 0x170E);
    writeInt(hex, this.unknown0x1712, 0x1712);
    writeInt(hex, this.numCombatFlownInLastBattle, 0x1716);
    offset = 0x171A;
    for (let i = 0; i < 2052; i++) {
      const t = this.unknown0x171A[i];
      writeByte(hex, t, offset);
      offset += 1;
    }
    offset = 0x1F1E;
    for (let i = 0; i < 4; i++) {
      const t = this.battleCombatMissionID[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x1F2E;
    for (let i = 0; i < 1012; i++) {
      const t = this.unknown0x1F2E[i];
      writeByte(hex, t, offset);
      offset += 1;
    }
    writeInt(hex, this.totalScoreForCurrentBattleUNK, 0x2322);
    writeInt(hex, this.CurrentRank, 0x2326);
    writeInt(hex, this.totalCountMissionsFlown, 0x232A);
    offset = 0x232E;
    for (let i = 0; i < 25; i++) {
      const t = this.RankAchievedOnMissionCount[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    writeChar(hex, this.RankString, 0x2392);
    writeInt(hex, this.debriefMissionScore, 0x23B2);
    offset = 0x23B6;
    for (let i = 0; i < 8; i++) {
      const t = this.debriefFullKillsOnPlayer[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x23D6;
    for (let i = 0; i < 8; i++) {
      const t = this.debriefSharedKillsOnPlayer[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x23F6;
    for (let i = 0; i < 48; i++) {
      const t = this.debriefFullKillsOnFG[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x24B6;
    for (let i = 0; i < 48; i++) {
      const t = this.debriefSharedKillsOnFG[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x2576;
    for (let i = 0; i < 8; i++) {
      const t = this.debriefFullKillsByPlayer[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x2596;
    for (let i = 0; i < 8; i++) {
      const t = this.debriefSharedKillsByPlayer[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x25B6;
    for (let i = 0; i < 48; i++) {
      const t = this.debriefFullKillsByFG[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x2676;
    for (let i = 0; i < 48; i++) {
      const t = this.debriefSharedKillsByFG[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x2736;
    for (let i = 0; i < 48; i++) {
      const t = this.debriefMeleeAIRankFG[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    writeObject(hex, this.UnknownRecord1, 0x27F6);
    writeObject(hex, this.UnknownRecord2, 0x2802);
    writeObject(hex, this.UnknownRecord3, 0x280E);
    writeObject(hex, this.debriefEnemyKills, 0x281A);
    writeObject(hex, this.debriefFriendlyKills, 0x2826);
    offset = 0x2832;
    for (let i = 0; i < 88; i++) {
      const t = this.debriefFullKillsByShipTypeA[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x2992;
    for (let i = 0; i < 88; i++) {
      const t = this.debriefFullKillsByShipTypeB[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x2AF2;
    for (let i = 0; i < 88; i++) {
      const t = this.debriefFullKillsByShipTypeC[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x2C52;
    for (let i = 0; i < 88; i++) {
      const t = this.debriefSharedKillsByShipTypeA[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x2DB2;
    for (let i = 0; i < 88; i++) {
      const t = this.debriefSharedKillsByShipTypeB[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x2F12;
    for (let i = 0; i < 88; i++) {
      const t = this.debriefSharedKillsByShipTypeC[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x3072;
    for (let i = 0; i < 88; i++) {
      const t = this.debriefAssistKillsByShipTypeA[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x31D2;
    for (let i = 0; i < 88; i++) {
      const t = this.debriefAssistKillsByShipTypeB[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x3332;
    for (let i = 0; i < 88; i++) {
      const t = this.debriefAssistKillsByShipTypeC[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    writeObject(hex, this.debriefFullKillsOnPlayerRank, 0x3492);
    writeObject(hex, this.debriefSharedKillsOnPlayerRank, 0x35BE);
    writeObject(hex, this.debriefAssistKillsOnPlayerRank, 0x36EA);
    writeObject(hex, this.debriefFullKillsOnAIRank, 0x3816);
    writeObject(hex, this.debriefSharedKillsOnAIRank, 0x385E);
    writeObject(hex, this.debriefAssistKillsOnAIRank, 0x38A6);
    writeObject(hex, this.debriefNumHiddenCargoFound, 0x38EE);
    writeObject(hex, this.debriefNumCannonHits, 0x38FA);
    writeObject(hex, this.debriefNumCannonFired, 0x3906);
    writeObject(hex, this.debriefNumWarheadHits, 0x3912);
    writeObject(hex, this.debriefNumWarheadFired, 0x391E);
    writeObject(hex, this.debriefNumCraftLosses, 0x392A);
    writeObject(hex, this.debriefCraftLossesFromCollision, 0x3936);
    writeObject(hex, this.debriefCraftLossesFromStarship, 0x3942);
    writeObject(hex, this.debriefCraftLossesFromMine, 0x394E);
    writeObject(hex, this.debriefLossesFromPlayerRank, 0x395A);
    writeObject(hex, this.debriefLossesFromAIRank, 0x3A86);
    offset = 0x3ACE;
    for (let i = 0; i < 8; i++) {
      const t = this.connectedPlayerData[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    offset = 0x3D8E;
    for (let i = 0; i < 10; i++) {
      const t = this.debriefTeamResult[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    writeInt(hex, this.lastSelectedFaction, 0x3EA6);
    writeObject(hex, this.rebelSingleplayerData, 0x3EAA);
    writeObject(hex, this.imperialSingleplayerData, 0x126CE);
    writeObject(hex, this.rebelMultiplayerData, 0x20EF2);
    writeObject(hex, this.imperialMultiplayerData, 0x2F716);

    return hex;
  }
  
  
  public getLength(): number {
    return this.PLTFILERECORDLENGTH;
  }
}