import { Byteable } from "../../../core/src/byteable";
import { IMission, PyriteBase } from "../../../core/src/pyrite-base";
import { PL2CampaignRecord } from "../pl-2-campaign-record";
import { PL2CampaignStatusSPRecord } from "../pl-2-campaign-status-sp-record";
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

export abstract class PL2FactionRecordBase extends PyriteBase implements Byteable {
  public readonly PL2FACTIONRECORDLENGTH: number = 68064;
  public totalMissionsFlown: number;
  public lastKnownTeam: number;
  public lastKnownFolderIndex: number;
  public selectedMissionIDNum: number[];
  public unknown0x24: number[];
  public isMissionCategorySeries: number;
  public activeMissionIDNum: number;
  public earnedMedalCount: PLTEarnedMedalRecord;
  public debriefMedalTypeMTEB: number[];
  public UnknownRecord4: number[];
  public totalFactionScore: number;
  public totalScore: PLTCategoryTypeRecord;
  public totalFlownNonSeries: PLTCategoryTypeRecord;
  public totalFlownSeries: PLTCategoryTypeRecord;
  public totalFullKills: PLTCategoryTypeRecord;
  public totalFriendlyFullKills: PLTCategoryTypeRecord;
  public totalFullKillsOnCraftEMC: number[];
  public totalSharedKillsOnCraftEMC: number[];
  public totalAssistKillsOnCraftEMC: number[];
  public totalFullKillsOfPlayerRank: PLTPlayerRankCountRecord;
  public totalSharedKillsOfPlayerRank: PLTPlayerRankCountRecord;
  public totalAssistKillsOfPlayerRank: PLTPlayerRankCountRecord;
  public totalFullKillsOfAIRank: PLTAIRankCountRecord;
  public totalSharedKillsOfAIRank: PLTAIRankCountRecord;
  public totalAssistKillsOfAIRank: PLTAIRankCountRecord;
  public totalHiddenCargoFound: PLTCategoryTypeRecord;
  public totalLaserHit: PLTCategoryTypeRecord;
  public totalLaserFired: PLTCategoryTypeRecord;
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
  public statusSPCampaign: PL2CampaignStatusSPRecord[];
  public statusMPCampaignUNK: PL2CampaignStatusSPRecord[];
  public missionSPCampaign: PL2CampaignRecord[];
  public missionMPCampaign: PL2CampaignRecord[];
  
  constructor(hex: ArrayBuffer, tie?: IMission) {
    super(hex, tie);
    this.beforeConstruct();
    let offset = 0;

    this.totalMissionsFlown = getInt(hex, 0x0000);
    this.lastKnownTeam = getInt(hex, 0x0004);
    this.lastKnownFolderIndex = getInt(hex, 0x0008);
    this.selectedMissionIDNum = [];
    offset = 0x000C;
    for (let i = 0; i < 6; i++) {
      const t = getInt(hex, offset);
      this.selectedMissionIDNum.push(t);
      offset += 4;
    }
    this.unknown0x24 = [];
    offset = 0x0024;
    for (let i = 0; i < 8; i++) {
      const t = getInt(hex, offset);
      this.unknown0x24.push(t);
      offset += 4;
    }
    this.isMissionCategorySeries = getInt(hex, 0x0044);
    this.activeMissionIDNum = getInt(hex, 0x0048);
    this.earnedMedalCount = new PLTEarnedMedalRecord(hex.slice(0x004C), this.TIE);
    this.debriefMedalTypeMTEB = [];
    offset = 0x00AC;
    for (let i = 0; i < 4; i++) {
      const t = getInt(hex, offset);
      this.debriefMedalTypeMTEB.push(t);
      offset += 4;
    }
    this.UnknownRecord4 = [];
    offset = 0x00BC;
    for (let i = 0; i < 4; i++) {
      const t = getInt(hex, offset);
      this.UnknownRecord4.push(t);
      offset += 4;
    }
    this.totalFactionScore = getInt(hex, 0x00CC);
    this.totalScore = new PLTCategoryTypeRecord(hex.slice(0x00D0), this.TIE);
    this.totalFlownNonSeries = new PLTCategoryTypeRecord(hex.slice(0x00DC), this.TIE);
    this.totalFlownSeries = new PLTCategoryTypeRecord(hex.slice(0x00E8), this.TIE);
    this.totalFullKills = new PLTCategoryTypeRecord(hex.slice(0x00F4), this.TIE);
    this.totalFriendlyFullKills = new PLTCategoryTypeRecord(hex.slice(0x0100), this.TIE);
    this.totalFullKillsOnCraftEMC = [];
    offset = 0x010C;
    for (let i = 0; i < 300; i++) {
      const t = getInt(hex, offset);
      this.totalFullKillsOnCraftEMC.push(t);
      offset += 4;
    }
    this.totalSharedKillsOnCraftEMC = [];
    offset = 0x05BC;
    for (let i = 0; i < 300; i++) {
      const t = getInt(hex, offset);
      this.totalSharedKillsOnCraftEMC.push(t);
      offset += 4;
    }
    this.totalAssistKillsOnCraftEMC = [];
    offset = 0x0A6C;
    for (let i = 0; i < 300; i++) {
      const t = getInt(hex, offset);
      this.totalAssistKillsOnCraftEMC.push(t);
      offset += 4;
    }
    this.totalFullKillsOfPlayerRank = new PLTPlayerRankCountRecord(hex.slice(0x0F1C), this.TIE);
    this.totalSharedKillsOfPlayerRank = new PLTPlayerRankCountRecord(hex.slice(0x1048), this.TIE);
    this.totalAssistKillsOfPlayerRank = new PLTPlayerRankCountRecord(hex.slice(0x1174), this.TIE);
    this.totalFullKillsOfAIRank = new PLTAIRankCountRecord(hex.slice(0x12A0), this.TIE);
    this.totalSharedKillsOfAIRank = new PLTAIRankCountRecord(hex.slice(0x12E8), this.TIE);
    this.totalAssistKillsOfAIRank = new PLTAIRankCountRecord(hex.slice(0x1330), this.TIE);
    this.totalHiddenCargoFound = new PLTCategoryTypeRecord(hex.slice(0x1378), this.TIE);
    this.totalLaserHit = new PLTCategoryTypeRecord(hex.slice(0x1384), this.TIE);
    this.totalLaserFired = new PLTCategoryTypeRecord(hex.slice(0x1390), this.TIE);
    this.totalWarheadHit = new PLTCategoryTypeRecord(hex.slice(0x139C), this.TIE);
    this.totalWarheadFired = new PLTCategoryTypeRecord(hex.slice(0x13A8), this.TIE);
    this.totalLosses = new PLTCategoryTypeRecord(hex.slice(0x13B4), this.TIE);
    this.totalLossesByCollision = new PLTCategoryTypeRecord(hex.slice(0x13C0), this.TIE);
    this.totalLossesByStarship = new PLTCategoryTypeRecord(hex.slice(0x13CC), this.TIE);
    this.totalLossesByMines = new PLTCategoryTypeRecord(hex.slice(0x13D8), this.TIE);
    this.totalLossesByPlayerRank = new PLTPlayerRankCountRecord(hex.slice(0x13E4), this.TIE);
    this.totalLossesByAIRank = new PLTAIRankCountRecord(hex.slice(0x1510), this.TIE);
    this.missionSPExercise = [];
    offset = 0x1558;
    for (let i = 0; i < 100; i++) {
      const t = new PLTMissionSPRecord(hex.slice(offset), this.TIE);
      this.missionSPExercise.push(t);
      offset += t.getLength();
    }
    this.missionSPMelee = [];
    offset = 0x2368;
    for (let i = 0; i < 250; i++) {
      const t = new PLTMissionSPRecord(hex.slice(offset), this.TIE);
      this.missionSPMelee.push(t);
      offset += t.getLength();
    }
    this.missionSPCombat = [];
    offset = 0x4690;
    for (let i = 0; i < 250; i++) {
      const t = new PLTMissionSPRecord(hex.slice(offset), this.TIE);
      this.missionSPCombat.push(t);
      offset += t.getLength();
    }
    this.missionMPExercise = [];
    offset = 0x69B8;
    for (let i = 0; i < 100; i++) {
      const t = new PLTMissionMPRecord(hex.slice(offset), this.TIE);
      this.missionMPExercise.push(t);
      offset += t.getLength();
    }
    this.missionMPMelee = [];
    offset = 0x7C78;
    for (let i = 0; i < 250; i++) {
      const t = new PLTMissionMPRecord(hex.slice(offset), this.TIE);
      this.missionMPMelee.push(t);
      offset += t.getLength();
    }
    this.missionMPCombat = [];
    offset = 0xAB58;
    for (let i = 0; i < 250; i++) {
      const t = new PLTMissionMPRecord(hex.slice(offset), this.TIE);
      this.missionMPCombat.push(t);
      offset += t.getLength();
    }
    this.missionSPTourn = [];
    offset = 0xDA38;
    for (let i = 0; i < 25; i++) {
      const t = new PLTTournSPRecord(hex.slice(offset), this.TIE);
      this.missionSPTourn.push(t);
      offset += t.getLength();
    }
    this.missionMPTourn = [];
    offset = 0xDE20;
    for (let i = 0; i < 25; i++) {
      const t = new PLTTournMPRecord(hex.slice(offset), this.TIE);
      this.missionMPTourn.push(t);
      offset += t.getLength();
    }
    this.missionSPBattle = [];
    offset = 0xE26C;
    for (let i = 0; i < 25; i++) {
      const t = new PLTBattleSPRecord(hex.slice(offset), this.TIE);
      this.missionSPBattle.push(t);
      offset += t.getLength();
    }
    this.missionMPBattle = [];
    offset = 0xE5F0;
    for (let i = 0; i < 25; i++) {
      const t = new PLTBattleMPRecord(hex.slice(offset), this.TIE);
      this.missionMPBattle.push(t);
      offset += t.getLength();
    }
    this.statusSPCampaign = [];
    offset = 0xE9D8;
    for (let i = 0; i < 25; i++) {
      const t = new PL2CampaignStatusSPRecord(hex.slice(offset), this.TIE);
      this.statusSPCampaign.push(t);
      offset += t.getLength();
    }
    this.statusMPCampaignUNK = [];
    offset = 0xED5C;
    for (let i = 0; i < 25; i++) {
      const t = new PL2CampaignStatusSPRecord(hex.slice(offset), this.TIE);
      this.statusMPCampaignUNK.push(t);
      offset += t.getLength();
    }
    this.missionSPCampaign = [];
    offset = 0xF0E0;
    for (let i = 0; i < 100; i++) {
      const t = new PL2CampaignRecord(hex.slice(offset), this.TIE);
      this.missionSPCampaign.push(t);
      offset += t.getLength();
    }
    this.missionMPCampaign = [];
    offset = 0xFD60;
    for (let i = 0; i < 100; i++) {
      const t = new PL2CampaignRecord(hex.slice(offset), this.TIE);
      this.missionMPCampaign.push(t);
      offset += t.getLength();
    }
    
  }
  
  public toJSON(): object {
    return {
      totalMissionsFlown: this.totalMissionsFlown,
      lastKnownTeam: this.lastKnownTeam,
      lastKnownFolderIndex: this.lastKnownFolderIndex,
      selectedMissionIDNum: this.selectedMissionIDNum,
      unknown0x24: this.unknown0x24,
      isMissionCategorySeries: this.isMissionCategorySeries,
      activeMissionIDNum: this.activeMissionIDNum,
      earnedMedalCount: this.earnedMedalCount,
      debriefMedalTypeMTEB: this.debriefMedalTypeMTEB,
      UnknownRecord4: this.UnknownRecord4,
      totalFactionScore: this.totalFactionScore,
      totalScore: this.totalScore,
      totalFlownNonSeries: this.totalFlownNonSeries,
      totalFlownSeries: this.totalFlownSeries,
      totalFullKills: this.totalFullKills,
      totalFriendlyFullKills: this.totalFriendlyFullKills,
      totalFullKillsOnCraftEMC: this.totalFullKillsOnCraftEMC,
      totalSharedKillsOnCraftEMC: this.totalSharedKillsOnCraftEMC,
      totalAssistKillsOnCraftEMC: this.totalAssistKillsOnCraftEMC,
      totalFullKillsOfPlayerRank: this.totalFullKillsOfPlayerRank,
      totalSharedKillsOfPlayerRank: this.totalSharedKillsOfPlayerRank,
      totalAssistKillsOfPlayerRank: this.totalAssistKillsOfPlayerRank,
      totalFullKillsOfAIRank: this.totalFullKillsOfAIRank,
      totalSharedKillsOfAIRank: this.totalSharedKillsOfAIRank,
      totalAssistKillsOfAIRank: this.totalAssistKillsOfAIRank,
      totalHiddenCargoFound: this.totalHiddenCargoFound,
      totalLaserHit: this.totalLaserHit,
      totalLaserFired: this.totalLaserFired,
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
      missionMPBattle: this.missionMPBattle,
      statusSPCampaign: this.statusSPCampaign,
      statusMPCampaignUNK: this.statusMPCampaignUNK,
      missionSPCampaign: this.missionSPCampaign,
      missionMPCampaign: this.missionMPCampaign
    };
  }
  
  public toHexString(): string {
    let hex: string = '';
    let offset = 0;

    writeInt(hex, this.totalMissionsFlown, 0x0000);
    writeInt(hex, this.lastKnownTeam, 0x0004);
    writeInt(hex, this.lastKnownFolderIndex, 0x0008);
    offset = 0x000C;
    for (let i = 0; i < 6; i++) {
      const t = this.selectedMissionIDNum[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x0024;
    for (let i = 0; i < 8; i++) {
      const t = this.unknown0x24[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    writeInt(hex, this.isMissionCategorySeries, 0x0044);
    writeInt(hex, this.activeMissionIDNum, 0x0048);
    writeObject(hex, this.earnedMedalCount, 0x004C);
    offset = 0x00AC;
    for (let i = 0; i < 4; i++) {
      const t = this.debriefMedalTypeMTEB[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x00BC;
    for (let i = 0; i < 4; i++) {
      const t = this.UnknownRecord4[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    writeInt(hex, this.totalFactionScore, 0x00CC);
    writeObject(hex, this.totalScore, 0x00D0);
    writeObject(hex, this.totalFlownNonSeries, 0x00DC);
    writeObject(hex, this.totalFlownSeries, 0x00E8);
    writeObject(hex, this.totalFullKills, 0x00F4);
    writeObject(hex, this.totalFriendlyFullKills, 0x0100);
    offset = 0x010C;
    for (let i = 0; i < 300; i++) {
      const t = this.totalFullKillsOnCraftEMC[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x05BC;
    for (let i = 0; i < 300; i++) {
      const t = this.totalSharedKillsOnCraftEMC[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x0A6C;
    for (let i = 0; i < 300; i++) {
      const t = this.totalAssistKillsOnCraftEMC[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    writeObject(hex, this.totalFullKillsOfPlayerRank, 0x0F1C);
    writeObject(hex, this.totalSharedKillsOfPlayerRank, 0x1048);
    writeObject(hex, this.totalAssistKillsOfPlayerRank, 0x1174);
    writeObject(hex, this.totalFullKillsOfAIRank, 0x12A0);
    writeObject(hex, this.totalSharedKillsOfAIRank, 0x12E8);
    writeObject(hex, this.totalAssistKillsOfAIRank, 0x1330);
    writeObject(hex, this.totalHiddenCargoFound, 0x1378);
    writeObject(hex, this.totalLaserHit, 0x1384);
    writeObject(hex, this.totalLaserFired, 0x1390);
    writeObject(hex, this.totalWarheadHit, 0x139C);
    writeObject(hex, this.totalWarheadFired, 0x13A8);
    writeObject(hex, this.totalLosses, 0x13B4);
    writeObject(hex, this.totalLossesByCollision, 0x13C0);
    writeObject(hex, this.totalLossesByStarship, 0x13CC);
    writeObject(hex, this.totalLossesByMines, 0x13D8);
    writeObject(hex, this.totalLossesByPlayerRank, 0x13E4);
    writeObject(hex, this.totalLossesByAIRank, 0x1510);
    offset = 0x1558;
    for (let i = 0; i < 100; i++) {
      const t = this.missionSPExercise[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    offset = 0x2368;
    for (let i = 0; i < 250; i++) {
      const t = this.missionSPMelee[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    offset = 0x4690;
    for (let i = 0; i < 250; i++) {
      const t = this.missionSPCombat[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    offset = 0x69B8;
    for (let i = 0; i < 100; i++) {
      const t = this.missionMPExercise[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    offset = 0x7C78;
    for (let i = 0; i < 250; i++) {
      const t = this.missionMPMelee[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    offset = 0xAB58;
    for (let i = 0; i < 250; i++) {
      const t = this.missionMPCombat[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    offset = 0xDA38;
    for (let i = 0; i < 25; i++) {
      const t = this.missionSPTourn[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    offset = 0xDE20;
    for (let i = 0; i < 25; i++) {
      const t = this.missionMPTourn[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    offset = 0xE26C;
    for (let i = 0; i < 25; i++) {
      const t = this.missionSPBattle[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    offset = 0xE5F0;
    for (let i = 0; i < 25; i++) {
      const t = this.missionMPBattle[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    offset = 0xE9D8;
    for (let i = 0; i < 25; i++) {
      const t = this.statusSPCampaign[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    offset = 0xED5C;
    for (let i = 0; i < 25; i++) {
      const t = this.statusMPCampaignUNK[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    offset = 0xF0E0;
    for (let i = 0; i < 100; i++) {
      const t = this.missionSPCampaign[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    offset = 0xFD60;
    for (let i = 0; i < 100; i++) {
      const t = this.missionMPCampaign[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }

    return hex;
  }
  
  
  public getLength(): number {
    return this.PL2FACTIONRECORDLENGTH;
  }
}