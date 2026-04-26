import { Byteable } from "../../../core/src/byteable";
import { IMission, PyriteBase } from "../../../core/src/pyrite-base";
import { PLTAIRankCountRecord } from "../pltai-rank-count-record";
import { PLTBattleMPRecord } from "../plt-battle-mp-record";
import { PLTBattleSPRecord } from "../plt-battle-sp-record";
import { PLTCategoryTypeRecord } from "../plt-category-type-record";
import { PLTEarnedMedalRecord } from "../plt-earned-medal-record";
import { PLTMissionMPRecord } from "../plt-mission-mp-record";
import { PLTMissionSPRecord } from "../plt-mission-sp-record";
import { PLTPlayerRankCountRecord } from "../plt-player-rank-count-record";
import { PLTTournMPRecord } from "../plt-tourn-mp-record";
import { PLTTournSPRecord } from "../plt-tourn-sp-record";
import { getInt, writeInt, writeObject } from "../../../core/src/hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class PLTFactionRecordBase extends PyriteBase implements Byteable {
  public readonly PLTFACTIONRECORDLENGTH: number = 59428;
  public totalMissionsFlown: number;
  public lastMissionTeam: number;
  public lastMissionType: number;
  public lastMissionTrainingSelected: number;
  public lastMissionMeleeSelected: number;
  public lastMissionTournamentSelected: number;
  public lastMissionCombatSelected: number;
  public lastMissionBattleSelected: number;
  public unknown0x20: number[];
  public earnedMedalCount: PLTEarnedMedalRecord;
  public debriefMeleePlaqueType: number;
  public debriefTournamentTrophyType: number;
  public debriefMissionBadgeType: number;
  public debriefBattleMedalType: number;
  public UnknownRecord4: number[];
  public totalFactionScore: number;
  public totalCategoryScore: PLTCategoryTypeRecord;
  public totalCategoryFlown: PLTCategoryTypeRecord;
  public totalCampaignExerciseFlown: number;
  public totalTournamentMeleeFlown: number;
  public totalBattleCombatFlown: number;
  public totalFullKills: PLTCategoryTypeRecord;
  public totalFriendlyFullKills: PLTCategoryTypeRecord;
  public totalFullKillsByShipExercise: number[];
  public totalFullKillsByShipMelee: number[];
  public totalFullKillsByShipCombat: number[];
  public totalSharedKillsOfShipExercise: number[];
  public totalSharedKillsOfShipMelee: number[];
  public totalSharedKillsOfShipCombat: number[];
  public totalAssistKillsOfShipExercise: number[];
  public totalAssistKillsOfShipMelee: number[];
  public totalAssistKillsOfShipCombat: number[];
  public totalFullKillsOfPlayerRank: PLTPlayerRankCountRecord;
  public totalSharedKillsOfPlayerRank: PLTPlayerRankCountRecord;
  public totalAssistKillsOfPlayerRank: PLTPlayerRankCountRecord;
  public totalFullKillsOfAIRank: PLTAIRankCountRecord;
  public totalSharedKillsOfAIRank: PLTAIRankCountRecord;
  public totalAssistKillsOfAIRank: PLTAIRankCountRecord;
  public totalHiddenCargoFound: PLTCategoryTypeRecord;
  public totalCannonHit: PLTCategoryTypeRecord;
  public totalCannonFired: PLTCategoryTypeRecord;
  public totalWarheadHit: PLTCategoryTypeRecord;
  public totalWarheadFired: PLTCategoryTypeRecord;
  public totalLosses: PLTCategoryTypeRecord;
  public totalLossesByCollision: PLTCategoryTypeRecord;
  public totalLossesByStarship: PLTCategoryTypeRecord;
  public totalLossesByMines: PLTCategoryTypeRecord;
  public totalLossesByPlayerRank: PLTPlayerRankCountRecord;
  public totalLossesByAIRank: PLTAIRankCountRecord;
  public missionSPExercise: PLTMissionSPRecord[];
  public missionSPMelee: PLTMissionSPRecord[];
  public missionSPCombat: PLTMissionSPRecord[];
  public missionMPExercise: PLTMissionMPRecord[];
  public missionMPMelee: PLTMissionMPRecord[];
  public missionMPCombat: PLTMissionMPRecord[];
  public missionSPTourn: PLTTournSPRecord[];
  public missionMPTourn: PLTTournMPRecord[];
  public missionSPBattle: PLTBattleSPRecord[];
  public missionMPBattle: PLTBattleMPRecord[];
  
  constructor(hex: ArrayBuffer, tie?: IMission) {
    super(hex, tie);
    this.beforeConstruct();
    let offset = 0;

    this.totalMissionsFlown = getInt(hex, 0x0000);
    this.lastMissionTeam = getInt(hex, 0x0004);
    this.lastMissionType = getInt(hex, 0x0008);
    this.lastMissionTrainingSelected = getInt(hex, 0x000C);
    this.lastMissionMeleeSelected = getInt(hex, 0x0010);
    this.lastMissionTournamentSelected = getInt(hex, 0x0014);
    this.lastMissionCombatSelected = getInt(hex, 0x0018);
    this.lastMissionBattleSelected = getInt(hex, 0x001C);
    this.unknown0x20 = [];
    offset = 0x0020;
    for (let i = 0; i < 10; i++) {
      const t = getInt(hex, offset);
      this.unknown0x20.push(t);
      offset += 4;
    }
    this.earnedMedalCount = new PLTEarnedMedalRecord(hex.slice(0x0048), this.TIE);
    this.debriefMeleePlaqueType = getInt(hex, 0x00A8);
    this.debriefTournamentTrophyType = getInt(hex, 0x00AC);
    this.debriefMissionBadgeType = getInt(hex, 0x00B0);
    this.debriefBattleMedalType = getInt(hex, 0x00B4);
    this.UnknownRecord4 = [];
    offset = 0x00B8;
    for (let i = 0; i < 4; i++) {
      const t = getInt(hex, offset);
      this.UnknownRecord4.push(t);
      offset += 4;
    }
    this.totalFactionScore = getInt(hex, 0x00C8);
    this.totalCategoryScore = new PLTCategoryTypeRecord(hex.slice(0x00CC), this.TIE);
    this.totalCategoryFlown = new PLTCategoryTypeRecord(hex.slice(0x00D8), this.TIE);
    this.totalCampaignExerciseFlown = getInt(hex, 0x00E4);
    this.totalTournamentMeleeFlown = getInt(hex, 0x00E8);
    this.totalBattleCombatFlown = getInt(hex, 0x00EC);
    this.totalFullKills = new PLTCategoryTypeRecord(hex.slice(0x00F0), this.TIE);
    this.totalFriendlyFullKills = new PLTCategoryTypeRecord(hex.slice(0x00FC), this.TIE);
    this.totalFullKillsByShipExercise = [];
    offset = 0x0108;
    for (let i = 0; i < 88; i++) {
      const t = getInt(hex, offset);
      this.totalFullKillsByShipExercise.push(t);
      offset += 4;
    }
    this.totalFullKillsByShipMelee = [];
    offset = 0x0268;
    for (let i = 0; i < 88; i++) {
      const t = getInt(hex, offset);
      this.totalFullKillsByShipMelee.push(t);
      offset += 4;
    }
    this.totalFullKillsByShipCombat = [];
    offset = 0x03C8;
    for (let i = 0; i < 88; i++) {
      const t = getInt(hex, offset);
      this.totalFullKillsByShipCombat.push(t);
      offset += 4;
    }
    this.totalSharedKillsOfShipExercise = [];
    offset = 0x0528;
    for (let i = 0; i < 88; i++) {
      const t = getInt(hex, offset);
      this.totalSharedKillsOfShipExercise.push(t);
      offset += 4;
    }
    this.totalSharedKillsOfShipMelee = [];
    offset = 0x0688;
    for (let i = 0; i < 88; i++) {
      const t = getInt(hex, offset);
      this.totalSharedKillsOfShipMelee.push(t);
      offset += 4;
    }
    this.totalSharedKillsOfShipCombat = [];
    offset = 0x07E8;
    for (let i = 0; i < 88; i++) {
      const t = getInt(hex, offset);
      this.totalSharedKillsOfShipCombat.push(t);
      offset += 4;
    }
    this.totalAssistKillsOfShipExercise = [];
    offset = 0x0948;
    for (let i = 0; i < 88; i++) {
      const t = getInt(hex, offset);
      this.totalAssistKillsOfShipExercise.push(t);
      offset += 4;
    }
    this.totalAssistKillsOfShipMelee = [];
    offset = 0x0AA8;
    for (let i = 0; i < 88; i++) {
      const t = getInt(hex, offset);
      this.totalAssistKillsOfShipMelee.push(t);
      offset += 4;
    }
    this.totalAssistKillsOfShipCombat = [];
    offset = 0x0C08;
    for (let i = 0; i < 88; i++) {
      const t = getInt(hex, offset);
      this.totalAssistKillsOfShipCombat.push(t);
      offset += 4;
    }
    this.totalFullKillsOfPlayerRank = new PLTPlayerRankCountRecord(hex.slice(0x0D68), this.TIE);
    this.totalSharedKillsOfPlayerRank = new PLTPlayerRankCountRecord(hex.slice(0x0E94), this.TIE);
    this.totalAssistKillsOfPlayerRank = new PLTPlayerRankCountRecord(hex.slice(0x0FC0), this.TIE);
    this.totalFullKillsOfAIRank = new PLTAIRankCountRecord(hex.slice(0x10EC), this.TIE);
    this.totalSharedKillsOfAIRank = new PLTAIRankCountRecord(hex.slice(0x1134), this.TIE);
    this.totalAssistKillsOfAIRank = new PLTAIRankCountRecord(hex.slice(0x117C), this.TIE);
    this.totalHiddenCargoFound = new PLTCategoryTypeRecord(hex.slice(0x11C4), this.TIE);
    this.totalCannonHit = new PLTCategoryTypeRecord(hex.slice(0x11D0), this.TIE);
    this.totalCannonFired = new PLTCategoryTypeRecord(hex.slice(0x11DC), this.TIE);
    this.totalWarheadHit = new PLTCategoryTypeRecord(hex.slice(0x11E8), this.TIE);
    this.totalWarheadFired = new PLTCategoryTypeRecord(hex.slice(0x11F4), this.TIE);
    this.totalLosses = new PLTCategoryTypeRecord(hex.slice(0x1200), this.TIE);
    this.totalLossesByCollision = new PLTCategoryTypeRecord(hex.slice(0x120C), this.TIE);
    this.totalLossesByStarship = new PLTCategoryTypeRecord(hex.slice(0x1218), this.TIE);
    this.totalLossesByMines = new PLTCategoryTypeRecord(hex.slice(0x1224), this.TIE);
    this.totalLossesByPlayerRank = new PLTPlayerRankCountRecord(hex.slice(0x1230), this.TIE);
    this.totalLossesByAIRank = new PLTAIRankCountRecord(hex.slice(0x135C), this.TIE);
    this.missionSPExercise = [];
    offset = 0x13A4;
    for (let i = 0; i < 100; i++) {
      const t = new PLTMissionSPRecord(hex.slice(offset), this.TIE);
      this.missionSPExercise.push(t);
      offset += t.getLength();
    }
    this.missionSPMelee = [];
    offset = 0x21B4;
    for (let i = 0; i < 250; i++) {
      const t = new PLTMissionSPRecord(hex.slice(offset), this.TIE);
      this.missionSPMelee.push(t);
      offset += t.getLength();
    }
    this.missionSPCombat = [];
    offset = 0x44DC;
    for (let i = 0; i < 250; i++) {
      const t = new PLTMissionSPRecord(hex.slice(offset), this.TIE);
      this.missionSPCombat.push(t);
      offset += t.getLength();
    }
    this.missionMPExercise = [];
    offset = 0x6804;
    for (let i = 0; i < 100; i++) {
      const t = new PLTMissionMPRecord(hex.slice(offset), this.TIE);
      this.missionMPExercise.push(t);
      offset += t.getLength();
    }
    this.missionMPMelee = [];
    offset = 0x7AC4;
    for (let i = 0; i < 250; i++) {
      const t = new PLTMissionMPRecord(hex.slice(offset), this.TIE);
      this.missionMPMelee.push(t);
      offset += t.getLength();
    }
    this.missionMPCombat = [];
    offset = 0xA9A4;
    for (let i = 0; i < 250; i++) {
      const t = new PLTMissionMPRecord(hex.slice(offset), this.TIE);
      this.missionMPCombat.push(t);
      offset += t.getLength();
    }
    this.missionSPTourn = [];
    offset = 0xD884;
    for (let i = 0; i < 25; i++) {
      const t = new PLTTournSPRecord(hex.slice(offset), this.TIE);
      this.missionSPTourn.push(t);
      offset += t.getLength();
    }
    this.missionMPTourn = [];
    offset = 0xDC6C;
    for (let i = 0; i < 25; i++) {
      const t = new PLTTournMPRecord(hex.slice(offset), this.TIE);
      this.missionMPTourn.push(t);
      offset += t.getLength();
    }
    this.missionSPBattle = [];
    offset = 0xE0B8;
    for (let i = 0; i < 25; i++) {
      const t = new PLTBattleSPRecord(hex.slice(offset), this.TIE);
      this.missionSPBattle.push(t);
      offset += t.getLength();
    }
    this.missionMPBattle = [];
    offset = 0xE43C;
    for (let i = 0; i < 25; i++) {
      const t = new PLTBattleMPRecord(hex.slice(offset), this.TIE);
      this.missionMPBattle.push(t);
      offset += t.getLength();
    }
    
  }
  
  public toJSON(): object {
    return {
      totalMissionsFlown: this.totalMissionsFlown,
      lastMissionTeam: this.lastMissionTeam,
      lastMissionType: this.lastMissionType,
      lastMissionTrainingSelected: this.lastMissionTrainingSelected,
      lastMissionMeleeSelected: this.lastMissionMeleeSelected,
      lastMissionTournamentSelected: this.lastMissionTournamentSelected,
      lastMissionCombatSelected: this.lastMissionCombatSelected,
      lastMissionBattleSelected: this.lastMissionBattleSelected,
      unknown0x20: this.unknown0x20,
      earnedMedalCount: this.earnedMedalCount,
      debriefMeleePlaqueType: this.debriefMeleePlaqueType,
      debriefTournamentTrophyType: this.debriefTournamentTrophyType,
      debriefMissionBadgeType: this.debriefMissionBadgeType,
      debriefBattleMedalType: this.debriefBattleMedalType,
      UnknownRecord4: this.UnknownRecord4,
      totalFactionScore: this.totalFactionScore,
      totalCategoryScore: this.totalCategoryScore,
      totalCategoryFlown: this.totalCategoryFlown,
      totalCampaignExerciseFlown: this.totalCampaignExerciseFlown,
      totalTournamentMeleeFlown: this.totalTournamentMeleeFlown,
      totalBattleCombatFlown: this.totalBattleCombatFlown,
      totalFullKills: this.totalFullKills,
      totalFriendlyFullKills: this.totalFriendlyFullKills,
      totalFullKillsByShipExercise: this.totalFullKillsByShipExercise,
      totalFullKillsByShipMelee: this.totalFullKillsByShipMelee,
      totalFullKillsByShipCombat: this.totalFullKillsByShipCombat,
      totalSharedKillsOfShipExercise: this.totalSharedKillsOfShipExercise,
      totalSharedKillsOfShipMelee: this.totalSharedKillsOfShipMelee,
      totalSharedKillsOfShipCombat: this.totalSharedKillsOfShipCombat,
      totalAssistKillsOfShipExercise: this.totalAssistKillsOfShipExercise,
      totalAssistKillsOfShipMelee: this.totalAssistKillsOfShipMelee,
      totalAssistKillsOfShipCombat: this.totalAssistKillsOfShipCombat,
      totalFullKillsOfPlayerRank: this.totalFullKillsOfPlayerRank,
      totalSharedKillsOfPlayerRank: this.totalSharedKillsOfPlayerRank,
      totalAssistKillsOfPlayerRank: this.totalAssistKillsOfPlayerRank,
      totalFullKillsOfAIRank: this.totalFullKillsOfAIRank,
      totalSharedKillsOfAIRank: this.totalSharedKillsOfAIRank,
      totalAssistKillsOfAIRank: this.totalAssistKillsOfAIRank,
      totalHiddenCargoFound: this.totalHiddenCargoFound,
      totalCannonHit: this.totalCannonHit,
      totalCannonFired: this.totalCannonFired,
      totalWarheadHit: this.totalWarheadHit,
      totalWarheadFired: this.totalWarheadFired,
      totalLosses: this.totalLosses,
      totalLossesByCollision: this.totalLossesByCollision,
      totalLossesByStarship: this.totalLossesByStarship,
      totalLossesByMines: this.totalLossesByMines,
      totalLossesByPlayerRank: this.totalLossesByPlayerRank,
      totalLossesByAIRank: this.totalLossesByAIRank,
      missionSPExercise: this.missionSPExercise,
      missionSPMelee: this.missionSPMelee,
      missionSPCombat: this.missionSPCombat,
      missionMPExercise: this.missionMPExercise,
      missionMPMelee: this.missionMPMelee,
      missionMPCombat: this.missionMPCombat,
      missionSPTourn: this.missionSPTourn,
      missionMPTourn: this.missionMPTourn,
      missionSPBattle: this.missionSPBattle,
      missionMPBattle: this.missionMPBattle
    };
  }
  
  public toHexString(): string {
    let hex: string = '';
    let offset = 0;

    writeInt(hex, this.totalMissionsFlown, 0x0000);
    writeInt(hex, this.lastMissionTeam, 0x0004);
    writeInt(hex, this.lastMissionType, 0x0008);
    writeInt(hex, this.lastMissionTrainingSelected, 0x000C);
    writeInt(hex, this.lastMissionMeleeSelected, 0x0010);
    writeInt(hex, this.lastMissionTournamentSelected, 0x0014);
    writeInt(hex, this.lastMissionCombatSelected, 0x0018);
    writeInt(hex, this.lastMissionBattleSelected, 0x001C);
    offset = 0x0020;
    for (let i = 0; i < 10; i++) {
      const t = this.unknown0x20[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    writeObject(hex, this.earnedMedalCount, 0x0048);
    writeInt(hex, this.debriefMeleePlaqueType, 0x00A8);
    writeInt(hex, this.debriefTournamentTrophyType, 0x00AC);
    writeInt(hex, this.debriefMissionBadgeType, 0x00B0);
    writeInt(hex, this.debriefBattleMedalType, 0x00B4);
    offset = 0x00B8;
    for (let i = 0; i < 4; i++) {
      const t = this.UnknownRecord4[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    writeInt(hex, this.totalFactionScore, 0x00C8);
    writeObject(hex, this.totalCategoryScore, 0x00CC);
    writeObject(hex, this.totalCategoryFlown, 0x00D8);
    writeInt(hex, this.totalCampaignExerciseFlown, 0x00E4);
    writeInt(hex, this.totalTournamentMeleeFlown, 0x00E8);
    writeInt(hex, this.totalBattleCombatFlown, 0x00EC);
    writeObject(hex, this.totalFullKills, 0x00F0);
    writeObject(hex, this.totalFriendlyFullKills, 0x00FC);
    offset = 0x0108;
    for (let i = 0; i < 88; i++) {
      const t = this.totalFullKillsByShipExercise[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x0268;
    for (let i = 0; i < 88; i++) {
      const t = this.totalFullKillsByShipMelee[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x03C8;
    for (let i = 0; i < 88; i++) {
      const t = this.totalFullKillsByShipCombat[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x0528;
    for (let i = 0; i < 88; i++) {
      const t = this.totalSharedKillsOfShipExercise[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x0688;
    for (let i = 0; i < 88; i++) {
      const t = this.totalSharedKillsOfShipMelee[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x07E8;
    for (let i = 0; i < 88; i++) {
      const t = this.totalSharedKillsOfShipCombat[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x0948;
    for (let i = 0; i < 88; i++) {
      const t = this.totalAssistKillsOfShipExercise[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x0AA8;
    for (let i = 0; i < 88; i++) {
      const t = this.totalAssistKillsOfShipMelee[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x0C08;
    for (let i = 0; i < 88; i++) {
      const t = this.totalAssistKillsOfShipCombat[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    writeObject(hex, this.totalFullKillsOfPlayerRank, 0x0D68);
    writeObject(hex, this.totalSharedKillsOfPlayerRank, 0x0E94);
    writeObject(hex, this.totalAssistKillsOfPlayerRank, 0x0FC0);
    writeObject(hex, this.totalFullKillsOfAIRank, 0x10EC);
    writeObject(hex, this.totalSharedKillsOfAIRank, 0x1134);
    writeObject(hex, this.totalAssistKillsOfAIRank, 0x117C);
    writeObject(hex, this.totalHiddenCargoFound, 0x11C4);
    writeObject(hex, this.totalCannonHit, 0x11D0);
    writeObject(hex, this.totalCannonFired, 0x11DC);
    writeObject(hex, this.totalWarheadHit, 0x11E8);
    writeObject(hex, this.totalWarheadFired, 0x11F4);
    writeObject(hex, this.totalLosses, 0x1200);
    writeObject(hex, this.totalLossesByCollision, 0x120C);
    writeObject(hex, this.totalLossesByStarship, 0x1218);
    writeObject(hex, this.totalLossesByMines, 0x1224);
    writeObject(hex, this.totalLossesByPlayerRank, 0x1230);
    writeObject(hex, this.totalLossesByAIRank, 0x135C);
    offset = 0x13A4;
    for (let i = 0; i < 100; i++) {
      const t = this.missionSPExercise[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    offset = 0x21B4;
    for (let i = 0; i < 250; i++) {
      const t = this.missionSPMelee[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    offset = 0x44DC;
    for (let i = 0; i < 250; i++) {
      const t = this.missionSPCombat[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    offset = 0x6804;
    for (let i = 0; i < 100; i++) {
      const t = this.missionMPExercise[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    offset = 0x7AC4;
    for (let i = 0; i < 250; i++) {
      const t = this.missionMPMelee[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    offset = 0xA9A4;
    for (let i = 0; i < 250; i++) {
      const t = this.missionMPCombat[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    offset = 0xD884;
    for (let i = 0; i < 25; i++) {
      const t = this.missionSPTourn[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    offset = 0xDC6C;
    for (let i = 0; i < 25; i++) {
      const t = this.missionMPTourn[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    offset = 0xE0B8;
    for (let i = 0; i < 25; i++) {
      const t = this.missionSPBattle[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    offset = 0xE43C;
    for (let i = 0; i < 25; i++) {
      const t = this.missionMPBattle[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }

    return hex;
  }
  
  
  public getLength(): number {
    return this.PLTFACTIONRECORDLENGTH;
  }
}