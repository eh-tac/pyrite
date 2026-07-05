import type { Byteable, IMission} from '@pyrite/core';
import { PyriteBase } from '@pyrite/core';
import { getInt, writeInt, writeObject } from '@pyrite/core';

import { PLTBattleMPRecord } from '../plt-battle-mp-record';
import { PLTBattleSPRecord } from '../plt-battle-sp-record';
import { PLTCategoryTypeRecord } from '../plt-category-type-record';
import { PLTEarnedMedalRecord } from '../plt-earned-medal-record';
import { PLTMissionMPRecord } from '../plt-mission-mp-record';
import { PLTMissionSPRecord } from '../plt-mission-sp-record';
import { PLTPlayerRankCountRecord } from '../plt-player-rank-count-record';
import { PLTTournMPRecord } from '../plt-tourn-mp-record';
import { PLTTournSPRecord } from '../plt-tourn-sp-record';
import { PLTAIRankCountRecord } from '../pltai-rank-count-record';
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

  constructor(hex: ArrayBuffer, TIE?: IMission) {
    super(hex, TIE!);
    this.beforeConstruct();
    let offset = 0;

    this.totalMissionsFlown = getInt(hex, 0x0000);
    this.lastMissionTeam = getInt(hex, 0x0004);
    this.lastMissionType = getInt(hex, 0x0008);
    this.lastMissionTrainingSelected = getInt(hex, 0x000c);
    this.lastMissionMeleeSelected = getInt(hex, 0x0010);
    this.lastMissionTournamentSelected = getInt(hex, 0x0014);
    this.lastMissionCombatSelected = getInt(hex, 0x0018);
    this.lastMissionBattleSelected = getInt(hex, 0x001c);
    this.unknown0x20 = [];
    offset = 0x0020;
    for (let i = 0; i < 10; i++) {
      const t = getInt(hex, offset);
      this.unknown0x20.push(t);
      offset += 4;
    }
    this.earnedMedalCount = new PLTEarnedMedalRecord(hex.slice(0x0048), this.TIE);
    this.debriefMeleePlaqueType = getInt(hex, 0x00a8);
    this.debriefTournamentTrophyType = getInt(hex, 0x00ac);
    this.debriefMissionBadgeType = getInt(hex, 0x00b0);
    this.debriefBattleMedalType = getInt(hex, 0x00b4);
    this.UnknownRecord4 = [];
    offset = 0x00b8;
    for (let i = 0; i < 4; i++) {
      const t = getInt(hex, offset);
      this.UnknownRecord4.push(t);
      offset += 4;
    }
    this.totalFactionScore = getInt(hex, 0x00c8);
    this.totalCategoryScore = new PLTCategoryTypeRecord(hex.slice(0x00cc), this.TIE);
    this.totalCategoryFlown = new PLTCategoryTypeRecord(hex.slice(0x00d8), this.TIE);
    this.totalCampaignExerciseFlown = getInt(hex, 0x00e4);
    this.totalTournamentMeleeFlown = getInt(hex, 0x00e8);
    this.totalBattleCombatFlown = getInt(hex, 0x00ec);
    this.totalFullKills = new PLTCategoryTypeRecord(hex.slice(0x00f0), this.TIE);
    this.totalFriendlyFullKills = new PLTCategoryTypeRecord(hex.slice(0x00fc), this.TIE);
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
    offset = 0x03c8;
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
    offset = 0x07e8;
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
    offset = 0x0aa8;
    for (let i = 0; i < 88; i++) {
      const t = getInt(hex, offset);
      this.totalAssistKillsOfShipMelee.push(t);
      offset += 4;
    }
    this.totalAssistKillsOfShipCombat = [];
    offset = 0x0c08;
    for (let i = 0; i < 88; i++) {
      const t = getInt(hex, offset);
      this.totalAssistKillsOfShipCombat.push(t);
      offset += 4;
    }
    this.totalFullKillsOfPlayerRank = new PLTPlayerRankCountRecord(hex.slice(0x0d68), this.TIE);
    this.totalSharedKillsOfPlayerRank = new PLTPlayerRankCountRecord(hex.slice(0x0e94), this.TIE);
    this.totalAssistKillsOfPlayerRank = new PLTPlayerRankCountRecord(hex.slice(0x0fc0), this.TIE);
    this.totalFullKillsOfAIRank = new PLTAIRankCountRecord(hex.slice(0x10ec), this.TIE);
    this.totalSharedKillsOfAIRank = new PLTAIRankCountRecord(hex.slice(0x1134), this.TIE);
    this.totalAssistKillsOfAIRank = new PLTAIRankCountRecord(hex.slice(0x117c), this.TIE);
    this.totalHiddenCargoFound = new PLTCategoryTypeRecord(hex.slice(0x11c4), this.TIE);
    this.totalCannonHit = new PLTCategoryTypeRecord(hex.slice(0x11d0), this.TIE);
    this.totalCannonFired = new PLTCategoryTypeRecord(hex.slice(0x11dc), this.TIE);
    this.totalWarheadHit = new PLTCategoryTypeRecord(hex.slice(0x11e8), this.TIE);
    this.totalWarheadFired = new PLTCategoryTypeRecord(hex.slice(0x11f4), this.TIE);
    this.totalLosses = new PLTCategoryTypeRecord(hex.slice(0x1200), this.TIE);
    this.totalLossesByCollision = new PLTCategoryTypeRecord(hex.slice(0x120c), this.TIE);
    this.totalLossesByStarship = new PLTCategoryTypeRecord(hex.slice(0x1218), this.TIE);
    this.totalLossesByMines = new PLTCategoryTypeRecord(hex.slice(0x1224), this.TIE);
    this.totalLossesByPlayerRank = new PLTPlayerRankCountRecord(hex.slice(0x1230), this.TIE);
    this.totalLossesByAIRank = new PLTAIRankCountRecord(hex.slice(0x135c), this.TIE);
    this.missionSPExercise = [];
    offset = 0x13a4;
    for (let i = 0; i < 100; i++) {
      const t = new PLTMissionSPRecord(hex.slice(offset), this.TIE);
      this.missionSPExercise.push(t);
      offset += t.getLength();
    }
    this.missionSPMelee = [];
    offset = 0x21b4;
    for (let i = 0; i < 250; i++) {
      const t = new PLTMissionSPRecord(hex.slice(offset), this.TIE);
      this.missionSPMelee.push(t);
      offset += t.getLength();
    }
    this.missionSPCombat = [];
    offset = 0x44dc;
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
    offset = 0x7ac4;
    for (let i = 0; i < 250; i++) {
      const t = new PLTMissionMPRecord(hex.slice(offset), this.TIE);
      this.missionMPMelee.push(t);
      offset += t.getLength();
    }
    this.missionMPCombat = [];
    offset = 0xa9a4;
    for (let i = 0; i < 250; i++) {
      const t = new PLTMissionMPRecord(hex.slice(offset), this.TIE);
      this.missionMPCombat.push(t);
      offset += t.getLength();
    }
    this.missionSPTourn = [];
    offset = 0xd884;
    for (let i = 0; i < 25; i++) {
      const t = new PLTTournSPRecord(hex.slice(offset), this.TIE);
      this.missionSPTourn.push(t);
      offset += t.getLength();
    }
    this.missionMPTourn = [];
    offset = 0xdc6c;
    for (let i = 0; i < 25; i++) {
      const t = new PLTTournMPRecord(hex.slice(offset), this.TIE);
      this.missionMPTourn.push(t);
      offset += t.getLength();
    }
    this.missionSPBattle = [];
    offset = 0xe0b8;
    for (let i = 0; i < 25; i++) {
      const t = new PLTBattleSPRecord(hex.slice(offset), this.TIE);
      this.missionSPBattle.push(t);
      offset += t.getLength();
    }
    this.missionMPBattle = [];
    offset = 0xe43c;
    for (let i = 0; i < 25; i++) {
      const t = new PLTBattleMPRecord(hex.slice(offset), this.TIE);
      this.missionMPBattle.push(t);
      offset += t.getLength();
    }
  }

  public toJSON(): Record<string, unknown> | string {
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
      earnedMedalCount: this.earnedMedalCount.toJSON(),
      debriefMeleePlaqueType: this.debriefMeleePlaqueType,
      debriefTournamentTrophyType: this.debriefTournamentTrophyType,
      debriefMissionBadgeType: this.debriefMissionBadgeType,
      debriefBattleMedalType: this.debriefBattleMedalType,
      UnknownRecord4: this.UnknownRecord4,
      totalFactionScore: this.totalFactionScore,
      totalCategoryScore: this.totalCategoryScore.toJSON(),
      totalCategoryFlown: this.totalCategoryFlown.toJSON(),
      totalCampaignExerciseFlown: this.totalCampaignExerciseFlown,
      totalTournamentMeleeFlown: this.totalTournamentMeleeFlown,
      totalBattleCombatFlown: this.totalBattleCombatFlown,
      totalFullKills: this.totalFullKills.toJSON(),
      totalFriendlyFullKills: this.totalFriendlyFullKills.toJSON(),
      totalFullKillsByShipExercise: this.totalFullKillsByShipExercise,
      totalFullKillsByShipMelee: this.totalFullKillsByShipMelee,
      totalFullKillsByShipCombat: this.totalFullKillsByShipCombat,
      totalSharedKillsOfShipExercise: this.totalSharedKillsOfShipExercise,
      totalSharedKillsOfShipMelee: this.totalSharedKillsOfShipMelee,
      totalSharedKillsOfShipCombat: this.totalSharedKillsOfShipCombat,
      totalAssistKillsOfShipExercise: this.totalAssistKillsOfShipExercise,
      totalAssistKillsOfShipMelee: this.totalAssistKillsOfShipMelee,
      totalAssistKillsOfShipCombat: this.totalAssistKillsOfShipCombat,
      totalFullKillsOfPlayerRank: this.totalFullKillsOfPlayerRank.toJSON(),
      totalSharedKillsOfPlayerRank: this.totalSharedKillsOfPlayerRank.toJSON(),
      totalAssistKillsOfPlayerRank: this.totalAssistKillsOfPlayerRank.toJSON(),
      totalFullKillsOfAIRank: this.totalFullKillsOfAIRank.toJSON(),
      totalSharedKillsOfAIRank: this.totalSharedKillsOfAIRank.toJSON(),
      totalAssistKillsOfAIRank: this.totalAssistKillsOfAIRank.toJSON(),
      totalHiddenCargoFound: this.totalHiddenCargoFound.toJSON(),
      totalCannonHit: this.totalCannonHit.toJSON(),
      totalCannonFired: this.totalCannonFired.toJSON(),
      totalWarheadHit: this.totalWarheadHit.toJSON(),
      totalWarheadFired: this.totalWarheadFired.toJSON(),
      totalLosses: this.totalLosses.toJSON(),
      totalLossesByCollision: this.totalLossesByCollision.toJSON(),
      totalLossesByStarship: this.totalLossesByStarship.toJSON(),
      totalLossesByMines: this.totalLossesByMines.toJSON(),
      totalLossesByPlayerRank: this.totalLossesByPlayerRank.toJSON(),
      totalLossesByAIRank: this.totalLossesByAIRank.toJSON(),
      missionSPExercise: this.missionSPExercise.map((t) => t.toJSON()),
      missionSPMelee: this.missionSPMelee.map((t) => t.toJSON()),
      missionSPCombat: this.missionSPCombat.map((t) => t.toJSON()),
      missionMPExercise: this.missionMPExercise.map((t) => t.toJSON()),
      missionMPMelee: this.missionMPMelee.map((t) => t.toJSON()),
      missionMPCombat: this.missionMPCombat.map((t) => t.toJSON()),
      missionSPTourn: this.missionSPTourn.map((t) => t.toJSON()),
      missionMPTourn: this.missionMPTourn.map((t) => t.toJSON()),
      missionSPBattle: this.missionSPBattle.map((t) => t.toJSON()),
      missionMPBattle: this.missionMPBattle.map((t) => t.toJSON())
    };
  }

  public toHexBuffer(): ArrayBuffer {
    const hex: ArrayBuffer = new ArrayBuffer(this.getLength());
    let offset = 0;

    writeInt(hex, this.totalMissionsFlown, 0x0000);
    writeInt(hex, this.lastMissionTeam, 0x0004);
    writeInt(hex, this.lastMissionType, 0x0008);
    writeInt(hex, this.lastMissionTrainingSelected, 0x000c);
    writeInt(hex, this.lastMissionMeleeSelected, 0x0010);
    writeInt(hex, this.lastMissionTournamentSelected, 0x0014);
    writeInt(hex, this.lastMissionCombatSelected, 0x0018);
    writeInt(hex, this.lastMissionBattleSelected, 0x001c);
    offset = 0x0020;
    for (let i = 0; i < this.unknown0x20.length; i++) {
      const t = this.unknown0x20[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    writeObject(hex, this.earnedMedalCount, 0x0048);
    writeInt(hex, this.debriefMeleePlaqueType, 0x00a8);
    writeInt(hex, this.debriefTournamentTrophyType, 0x00ac);
    writeInt(hex, this.debriefMissionBadgeType, 0x00b0);
    writeInt(hex, this.debriefBattleMedalType, 0x00b4);
    offset = 0x00b8;
    for (let i = 0; i < this.UnknownRecord4.length; i++) {
      const t = this.UnknownRecord4[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    writeInt(hex, this.totalFactionScore, 0x00c8);
    writeObject(hex, this.totalCategoryScore, 0x00cc);
    writeObject(hex, this.totalCategoryFlown, 0x00d8);
    writeInt(hex, this.totalCampaignExerciseFlown, 0x00e4);
    writeInt(hex, this.totalTournamentMeleeFlown, 0x00e8);
    writeInt(hex, this.totalBattleCombatFlown, 0x00ec);
    writeObject(hex, this.totalFullKills, 0x00f0);
    writeObject(hex, this.totalFriendlyFullKills, 0x00fc);
    offset = 0x0108;
    for (let i = 0; i < this.totalFullKillsByShipExercise.length; i++) {
      const t = this.totalFullKillsByShipExercise[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x0268;
    for (let i = 0; i < this.totalFullKillsByShipMelee.length; i++) {
      const t = this.totalFullKillsByShipMelee[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x03c8;
    for (let i = 0; i < this.totalFullKillsByShipCombat.length; i++) {
      const t = this.totalFullKillsByShipCombat[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x0528;
    for (let i = 0; i < this.totalSharedKillsOfShipExercise.length; i++) {
      const t = this.totalSharedKillsOfShipExercise[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x0688;
    for (let i = 0; i < this.totalSharedKillsOfShipMelee.length; i++) {
      const t = this.totalSharedKillsOfShipMelee[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x07e8;
    for (let i = 0; i < this.totalSharedKillsOfShipCombat.length; i++) {
      const t = this.totalSharedKillsOfShipCombat[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x0948;
    for (let i = 0; i < this.totalAssistKillsOfShipExercise.length; i++) {
      const t = this.totalAssistKillsOfShipExercise[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x0aa8;
    for (let i = 0; i < this.totalAssistKillsOfShipMelee.length; i++) {
      const t = this.totalAssistKillsOfShipMelee[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x0c08;
    for (let i = 0; i < this.totalAssistKillsOfShipCombat.length; i++) {
      const t = this.totalAssistKillsOfShipCombat[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    writeObject(hex, this.totalFullKillsOfPlayerRank, 0x0d68);
    writeObject(hex, this.totalSharedKillsOfPlayerRank, 0x0e94);
    writeObject(hex, this.totalAssistKillsOfPlayerRank, 0x0fc0);
    writeObject(hex, this.totalFullKillsOfAIRank, 0x10ec);
    writeObject(hex, this.totalSharedKillsOfAIRank, 0x1134);
    writeObject(hex, this.totalAssistKillsOfAIRank, 0x117c);
    writeObject(hex, this.totalHiddenCargoFound, 0x11c4);
    writeObject(hex, this.totalCannonHit, 0x11d0);
    writeObject(hex, this.totalCannonFired, 0x11dc);
    writeObject(hex, this.totalWarheadHit, 0x11e8);
    writeObject(hex, this.totalWarheadFired, 0x11f4);
    writeObject(hex, this.totalLosses, 0x1200);
    writeObject(hex, this.totalLossesByCollision, 0x120c);
    writeObject(hex, this.totalLossesByStarship, 0x1218);
    writeObject(hex, this.totalLossesByMines, 0x1224);
    writeObject(hex, this.totalLossesByPlayerRank, 0x1230);
    writeObject(hex, this.totalLossesByAIRank, 0x135c);
    offset = 0x13a4;
    for (let i = 0; i < this.missionSPExercise.length; i++) {
      const t = this.missionSPExercise[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    offset = 0x21b4;
    for (let i = 0; i < this.missionSPMelee.length; i++) {
      const t = this.missionSPMelee[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    offset = 0x44dc;
    for (let i = 0; i < this.missionSPCombat.length; i++) {
      const t = this.missionSPCombat[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    offset = 0x6804;
    for (let i = 0; i < this.missionMPExercise.length; i++) {
      const t = this.missionMPExercise[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    offset = 0x7ac4;
    for (let i = 0; i < this.missionMPMelee.length; i++) {
      const t = this.missionMPMelee[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    offset = 0xa9a4;
    for (let i = 0; i < this.missionMPCombat.length; i++) {
      const t = this.missionMPCombat[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    offset = 0xd884;
    for (let i = 0; i < this.missionSPTourn.length; i++) {
      const t = this.missionSPTourn[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    offset = 0xdc6c;
    for (let i = 0; i < this.missionMPTourn.length; i++) {
      const t = this.missionMPTourn[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    offset = 0xe0b8;
    for (let i = 0; i < this.missionSPBattle.length; i++) {
      const t = this.missionSPBattle[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    offset = 0xe43c;
    for (let i = 0; i < this.missionMPBattle.length; i++) {
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
