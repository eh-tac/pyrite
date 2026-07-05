import { Byteable, IMission, PyriteBase } from '@pyrite/core';
import { PL2CampaignRecord } from '../pl-2-campaign-record';
import { PL2CampaignStatusSPRecord } from '../pl-2-campaign-status-sp-record';
import { PLTAIRankCountRecord } from '../pltai-rank-count-record';
import { PLTBattleMPRecord } from '../plt-battle-mp-record';
import { PLTBattleSPRecord } from '../plt-battle-sp-record';
import { PLTCategoryTypeRecord } from '../plt-category-type-record';
import { PLTEarnedMedalRecord } from '../plt-earned-medal-record';
import { PLTMissionMPRecord } from '../plt-mission-mp-record';
import { PLTMissionSPRecord } from '../plt-mission-sp-record';
import { PLTPlayerRankCountRecord } from '../plt-player-rank-count-record';
import { PLTTournMPRecord } from '../plt-tourn-mp-record';
import { PLTTournSPRecord } from '../plt-tourn-sp-record';
import { getInt, writeInt, writeObject } from '@pyrite/core';
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

  constructor(
    public hex: ArrayBuffer,
    public TIE?: IMission
  ) {
    super(hex, TIE!);
    this.beforeConstruct();
    let offset = 0;

    this.totalMissionsFlown = getInt(hex, 0x0000);
    this.lastKnownTeam = getInt(hex, 0x0004);
    this.lastKnownFolderIndex = getInt(hex, 0x0008);
    this.selectedMissionIDNum = [];
    offset = 0x000c;
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
    this.earnedMedalCount = new PLTEarnedMedalRecord(hex.slice(0x004c), this.TIE);
    this.debriefMedalTypeMTEB = [];
    offset = 0x00ac;
    for (let i = 0; i < 4; i++) {
      const t = getInt(hex, offset);
      this.debriefMedalTypeMTEB.push(t);
      offset += 4;
    }
    this.UnknownRecord4 = [];
    offset = 0x00bc;
    for (let i = 0; i < 4; i++) {
      const t = getInt(hex, offset);
      this.UnknownRecord4.push(t);
      offset += 4;
    }
    this.totalFactionScore = getInt(hex, 0x00cc);
    this.totalScore = new PLTCategoryTypeRecord(hex.slice(0x00d0), this.TIE);
    this.totalFlownNonSeries = new PLTCategoryTypeRecord(hex.slice(0x00dc), this.TIE);
    this.totalFlownSeries = new PLTCategoryTypeRecord(hex.slice(0x00e8), this.TIE);
    this.totalFullKills = new PLTCategoryTypeRecord(hex.slice(0x00f4), this.TIE);
    this.totalFriendlyFullKills = new PLTCategoryTypeRecord(hex.slice(0x0100), this.TIE);
    this.totalFullKillsOnCraftEMC = [];
    offset = 0x010c;
    for (let i = 0; i < 300; i++) {
      const t = getInt(hex, offset);
      this.totalFullKillsOnCraftEMC.push(t);
      offset += 4;
    }
    this.totalSharedKillsOnCraftEMC = [];
    offset = 0x05bc;
    for (let i = 0; i < 300; i++) {
      const t = getInt(hex, offset);
      this.totalSharedKillsOnCraftEMC.push(t);
      offset += 4;
    }
    this.totalAssistKillsOnCraftEMC = [];
    offset = 0x0a6c;
    for (let i = 0; i < 300; i++) {
      const t = getInt(hex, offset);
      this.totalAssistKillsOnCraftEMC.push(t);
      offset += 4;
    }
    this.totalFullKillsOfPlayerRank = new PLTPlayerRankCountRecord(hex.slice(0x0f1c), this.TIE);
    this.totalSharedKillsOfPlayerRank = new PLTPlayerRankCountRecord(hex.slice(0x1048), this.TIE);
    this.totalAssistKillsOfPlayerRank = new PLTPlayerRankCountRecord(hex.slice(0x1174), this.TIE);
    this.totalFullKillsOfAIRank = new PLTAIRankCountRecord(hex.slice(0x12a0), this.TIE);
    this.totalSharedKillsOfAIRank = new PLTAIRankCountRecord(hex.slice(0x12e8), this.TIE);
    this.totalAssistKillsOfAIRank = new PLTAIRankCountRecord(hex.slice(0x1330), this.TIE);
    this.totalHiddenCargoFound = new PLTCategoryTypeRecord(hex.slice(0x1378), this.TIE);
    this.totalLaserHit = new PLTCategoryTypeRecord(hex.slice(0x1384), this.TIE);
    this.totalLaserFired = new PLTCategoryTypeRecord(hex.slice(0x1390), this.TIE);
    this.totalWarheadHit = new PLTCategoryTypeRecord(hex.slice(0x139c), this.TIE);
    this.totalWarheadFired = new PLTCategoryTypeRecord(hex.slice(0x13a8), this.TIE);
    this.totalLosses = new PLTCategoryTypeRecord(hex.slice(0x13b4), this.TIE);
    this.totalLossesByCollision = new PLTCategoryTypeRecord(hex.slice(0x13c0), this.TIE);
    this.totalLossesByStarship = new PLTCategoryTypeRecord(hex.slice(0x13cc), this.TIE);
    this.totalLossesByMines = new PLTCategoryTypeRecord(hex.slice(0x13d8), this.TIE);
    this.totalLossesByPlayerRank = new PLTPlayerRankCountRecord(hex.slice(0x13e4), this.TIE);
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
    offset = 0x69b8;
    for (let i = 0; i < 100; i++) {
      const t = new PLTMissionMPRecord(hex.slice(offset), this.TIE);
      this.missionMPExercise.push(t);
      offset += t.getLength();
    }
    this.missionMPMelee = [];
    offset = 0x7c78;
    for (let i = 0; i < 250; i++) {
      const t = new PLTMissionMPRecord(hex.slice(offset), this.TIE);
      this.missionMPMelee.push(t);
      offset += t.getLength();
    }
    this.missionMPCombat = [];
    offset = 0xab58;
    for (let i = 0; i < 250; i++) {
      const t = new PLTMissionMPRecord(hex.slice(offset), this.TIE);
      this.missionMPCombat.push(t);
      offset += t.getLength();
    }
    this.missionSPTourn = [];
    offset = 0xda38;
    for (let i = 0; i < 25; i++) {
      const t = new PLTTournSPRecord(hex.slice(offset), this.TIE);
      this.missionSPTourn.push(t);
      offset += t.getLength();
    }
    this.missionMPTourn = [];
    offset = 0xde20;
    for (let i = 0; i < 25; i++) {
      const t = new PLTTournMPRecord(hex.slice(offset), this.TIE);
      this.missionMPTourn.push(t);
      offset += t.getLength();
    }
    this.missionSPBattle = [];
    offset = 0xe26c;
    for (let i = 0; i < 25; i++) {
      const t = new PLTBattleSPRecord(hex.slice(offset), this.TIE);
      this.missionSPBattle.push(t);
      offset += t.getLength();
    }
    this.missionMPBattle = [];
    offset = 0xe5f0;
    for (let i = 0; i < 25; i++) {
      const t = new PLTBattleMPRecord(hex.slice(offset), this.TIE);
      this.missionMPBattle.push(t);
      offset += t.getLength();
    }
    this.statusSPCampaign = [];
    offset = 0xe9d8;
    for (let i = 0; i < 25; i++) {
      const t = new PL2CampaignStatusSPRecord(hex.slice(offset), this.TIE);
      this.statusSPCampaign.push(t);
      offset += t.getLength();
    }
    this.statusMPCampaignUNK = [];
    offset = 0xed5c;
    for (let i = 0; i < 25; i++) {
      const t = new PL2CampaignStatusSPRecord(hex.slice(offset), this.TIE);
      this.statusMPCampaignUNK.push(t);
      offset += t.getLength();
    }
    this.missionSPCampaign = [];
    offset = 0xf0e0;
    for (let i = 0; i < 100; i++) {
      const t = new PL2CampaignRecord(hex.slice(offset), this.TIE);
      this.missionSPCampaign.push(t);
      offset += t.getLength();
    }
    this.missionMPCampaign = [];
    offset = 0xfd60;
    for (let i = 0; i < 100; i++) {
      const t = new PL2CampaignRecord(hex.slice(offset), this.TIE);
      this.missionMPCampaign.push(t);
      offset += t.getLength();
    }
  }

  public toJSON(): Record<string, unknown> | string {
    return {
      totalMissionsFlown: this.totalMissionsFlown,
      lastKnownTeam: this.lastKnownTeam,
      lastKnownFolderIndex: this.lastKnownFolderIndex,
      selectedMissionIDNum: this.selectedMissionIDNum,
      unknown0x24: this.unknown0x24,
      isMissionCategorySeries: this.isMissionCategorySeries,
      activeMissionIDNum: this.activeMissionIDNum,
      earnedMedalCount: this.earnedMedalCount.toJSON(),
      debriefMedalTypeMTEB: this.debriefMedalTypeMTEB,
      UnknownRecord4: this.UnknownRecord4,
      totalFactionScore: this.totalFactionScore,
      totalScore: this.totalScore.toJSON(),
      totalFlownNonSeries: this.totalFlownNonSeries.toJSON(),
      totalFlownSeries: this.totalFlownSeries.toJSON(),
      totalFullKills: this.totalFullKills.toJSON(),
      totalFriendlyFullKills: this.totalFriendlyFullKills.toJSON(),
      totalFullKillsOnCraftEMC: this.totalFullKillsOnCraftEMC,
      totalSharedKillsOnCraftEMC: this.totalSharedKillsOnCraftEMC,
      totalAssistKillsOnCraftEMC: this.totalAssistKillsOnCraftEMC,
      totalFullKillsOfPlayerRank: this.totalFullKillsOfPlayerRank.toJSON(),
      totalSharedKillsOfPlayerRank: this.totalSharedKillsOfPlayerRank.toJSON(),
      totalAssistKillsOfPlayerRank: this.totalAssistKillsOfPlayerRank.toJSON(),
      totalFullKillsOfAIRank: this.totalFullKillsOfAIRank.toJSON(),
      totalSharedKillsOfAIRank: this.totalSharedKillsOfAIRank.toJSON(),
      totalAssistKillsOfAIRank: this.totalAssistKillsOfAIRank.toJSON(),
      totalHiddenCargoFound: this.totalHiddenCargoFound.toJSON(),
      totalLaserHit: this.totalLaserHit.toJSON(),
      totalLaserFired: this.totalLaserFired.toJSON(),
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
      missionMPBattle: this.missionMPBattle.map((t) => t.toJSON()),
      statusSPCampaign: this.statusSPCampaign.map((t) => t.toJSON()),
      statusMPCampaignUNK: this.statusMPCampaignUNK.map((t) => t.toJSON()),
      missionSPCampaign: this.missionSPCampaign.map((t) => t.toJSON()),
      missionMPCampaign: this.missionMPCampaign.map((t) => t.toJSON())
    };
  }

  public toHexBuffer(): ArrayBuffer {
    const hex: ArrayBuffer = new ArrayBuffer(this.getLength());
    let offset = 0;

    writeInt(hex, this.totalMissionsFlown, 0x0000);
    writeInt(hex, this.lastKnownTeam, 0x0004);
    writeInt(hex, this.lastKnownFolderIndex, 0x0008);
    offset = 0x000c;
    for (let i = 0; i < this.selectedMissionIDNum.length; i++) {
      const t = this.selectedMissionIDNum[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x0024;
    for (let i = 0; i < this.unknown0x24.length; i++) {
      const t = this.unknown0x24[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    writeInt(hex, this.isMissionCategorySeries, 0x0044);
    writeInt(hex, this.activeMissionIDNum, 0x0048);
    writeObject(hex, this.earnedMedalCount, 0x004c);
    offset = 0x00ac;
    for (let i = 0; i < this.debriefMedalTypeMTEB.length; i++) {
      const t = this.debriefMedalTypeMTEB[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x00bc;
    for (let i = 0; i < this.UnknownRecord4.length; i++) {
      const t = this.UnknownRecord4[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    writeInt(hex, this.totalFactionScore, 0x00cc);
    writeObject(hex, this.totalScore, 0x00d0);
    writeObject(hex, this.totalFlownNonSeries, 0x00dc);
    writeObject(hex, this.totalFlownSeries, 0x00e8);
    writeObject(hex, this.totalFullKills, 0x00f4);
    writeObject(hex, this.totalFriendlyFullKills, 0x0100);
    offset = 0x010c;
    for (let i = 0; i < this.totalFullKillsOnCraftEMC.length; i++) {
      const t = this.totalFullKillsOnCraftEMC[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x05bc;
    for (let i = 0; i < this.totalSharedKillsOnCraftEMC.length; i++) {
      const t = this.totalSharedKillsOnCraftEMC[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x0a6c;
    for (let i = 0; i < this.totalAssistKillsOnCraftEMC.length; i++) {
      const t = this.totalAssistKillsOnCraftEMC[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    writeObject(hex, this.totalFullKillsOfPlayerRank, 0x0f1c);
    writeObject(hex, this.totalSharedKillsOfPlayerRank, 0x1048);
    writeObject(hex, this.totalAssistKillsOfPlayerRank, 0x1174);
    writeObject(hex, this.totalFullKillsOfAIRank, 0x12a0);
    writeObject(hex, this.totalSharedKillsOfAIRank, 0x12e8);
    writeObject(hex, this.totalAssistKillsOfAIRank, 0x1330);
    writeObject(hex, this.totalHiddenCargoFound, 0x1378);
    writeObject(hex, this.totalLaserHit, 0x1384);
    writeObject(hex, this.totalLaserFired, 0x1390);
    writeObject(hex, this.totalWarheadHit, 0x139c);
    writeObject(hex, this.totalWarheadFired, 0x13a8);
    writeObject(hex, this.totalLosses, 0x13b4);
    writeObject(hex, this.totalLossesByCollision, 0x13c0);
    writeObject(hex, this.totalLossesByStarship, 0x13cc);
    writeObject(hex, this.totalLossesByMines, 0x13d8);
    writeObject(hex, this.totalLossesByPlayerRank, 0x13e4);
    writeObject(hex, this.totalLossesByAIRank, 0x1510);
    offset = 0x1558;
    for (let i = 0; i < this.missionSPExercise.length; i++) {
      const t = this.missionSPExercise[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    offset = 0x2368;
    for (let i = 0; i < this.missionSPMelee.length; i++) {
      const t = this.missionSPMelee[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    offset = 0x4690;
    for (let i = 0; i < this.missionSPCombat.length; i++) {
      const t = this.missionSPCombat[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    offset = 0x69b8;
    for (let i = 0; i < this.missionMPExercise.length; i++) {
      const t = this.missionMPExercise[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    offset = 0x7c78;
    for (let i = 0; i < this.missionMPMelee.length; i++) {
      const t = this.missionMPMelee[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    offset = 0xab58;
    for (let i = 0; i < this.missionMPCombat.length; i++) {
      const t = this.missionMPCombat[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    offset = 0xda38;
    for (let i = 0; i < this.missionSPTourn.length; i++) {
      const t = this.missionSPTourn[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    offset = 0xde20;
    for (let i = 0; i < this.missionMPTourn.length; i++) {
      const t = this.missionMPTourn[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    offset = 0xe26c;
    for (let i = 0; i < this.missionSPBattle.length; i++) {
      const t = this.missionSPBattle[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    offset = 0xe5f0;
    for (let i = 0; i < this.missionMPBattle.length; i++) {
      const t = this.missionMPBattle[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    offset = 0xe9d8;
    for (let i = 0; i < this.statusSPCampaign.length; i++) {
      const t = this.statusSPCampaign[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    offset = 0xed5c;
    for (let i = 0; i < this.statusMPCampaignUNK.length; i++) {
      const t = this.statusMPCampaignUNK[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    offset = 0xf0e0;
    for (let i = 0; i < this.missionSPCampaign.length; i++) {
      const t = this.missionSPCampaign[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    offset = 0xfd60;
    for (let i = 0; i < this.missionMPCampaign.length; i++) {
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
