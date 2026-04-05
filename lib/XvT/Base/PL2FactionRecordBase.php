<?php

namespace Pyrite\XvT\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;
use Pyrite\XvT\PL2CampaignRecord;
use Pyrite\XvT\PL2CampaignStatusSPRecord;
use Pyrite\XvT\PLTAIRankCountRecord;
use Pyrite\XvT\PLTBattleMPRecord;
use Pyrite\XvT\PLTBattleSPRecord;
use Pyrite\XvT\PLTCategoryTypeRecord;
use Pyrite\XvT\PLTEarnedMedalRecord;
use Pyrite\XvT\PLTMissionMPRecord;
use Pyrite\XvT\PLTMissionSPRecord;
use Pyrite\XvT\PLTPlayerRankCountRecord;
use Pyrite\XvT\PLTTournMPRecord;
use Pyrite\XvT\PLTTournSPRecord;

abstract class PL2FactionRecordBase extends PyriteBase implements Byteable
{
    use HexDecoder;
    use HexEncoder;

    /** @var integer  PL2FACTIONRECORDLENGTH INT */
    public const PL2FACTIONRECORDLENGTH = 68064;
    /** @var integer 0x0000 totalMissionsFlown INT */
    public $totalMissionsFlown;
    /** @var integer 0x0004 lastKnownTeam INT */
    public $lastKnownTeam;
    /** @var integer 0x0008 lastKnownFolderIndex INT */
    public $lastKnownFolderIndex;
    /** @var integer[] 0x000C selectedMissionIDNum INT */
    public $selectedMissionIDNum;
    /** @var integer[] 0x0024 unknown0x24 INT */
    public $unknown0x24;
    /** @var integer 0x0044 isMissionCategorySeries INT */
    public $isMissionCategorySeries;
    /** @var integer 0x0048 activeMissionIDNum INT */
    public $activeMissionIDNum;
    /** @var PLTEarnedMedalRecord 0x004C earnedMedalCount PLTEarnedMedalRecord */
    public $earnedMedalCount;
    /** @var integer[] 0x00AC debriefMedalTypeMTEB INT */
    public $debriefMedalTypeMTEB;
    /** @var integer[] 0x00BC UnknownRecord4 INT */
    public $UnknownRecord4;
    /** @var integer 0x00CC totalFactionScore INT */
    public $totalFactionScore;
    /** @var PLTCategoryTypeRecord 0x00D0 totalScore PLTCategoryTypeRecord */
    public $totalScore;
    /** @var PLTCategoryTypeRecord 0x00DC totalFlownNonSeries PLTCategoryTypeRecord */
    public $totalFlownNonSeries;
    /** @var PLTCategoryTypeRecord 0x00E8 totalFlownSeries PLTCategoryTypeRecord */
    public $totalFlownSeries;
    /** @var PLTCategoryTypeRecord 0x00F4 totalFullKills PLTCategoryTypeRecord */
    public $totalFullKills;
    /** @var PLTCategoryTypeRecord 0x0100 totalFriendlyFullKills PLTCategoryTypeRecord */
    public $totalFriendlyFullKills;
    /** @var integer[] 0x010C totalFullKillsOnCraftEMC INT */
    public $totalFullKillsOnCraftEMC;
    /** @var integer[] 0x05BC totalSharedKillsOnCraftEMC INT */
    public $totalSharedKillsOnCraftEMC;
    /** @var integer[] 0x0A6C totalAssistKillsOnCraftEMC INT */
    public $totalAssistKillsOnCraftEMC;
    /** @var PLTPlayerRankCountRecord 0x0F1C totalFullKillsOfPlayerRank PLTPlayerRankCountRecord */
    public $totalFullKillsOfPlayerRank;
    /** @var PLTPlayerRankCountRecord 0x1048 totalSharedKillsOfPlayerRank PLTPlayerRankCountRecord */
    public $totalSharedKillsOfPlayerRank;
    /** @var PLTPlayerRankCountRecord 0x1174 totalAssistKillsOfPlayerRank PLTPlayerRankCountRecord */
    public $totalAssistKillsOfPlayerRank;
    /** @var PLTAIRankCountRecord 0x12A0 totalFullKillsOfAIRank PLTAIRankCountRecord */
    public $totalFullKillsOfAIRank;
    /** @var PLTAIRankCountRecord 0x12E8 totalSharedKillsOfAIRank PLTAIRankCountRecord */
    public $totalSharedKillsOfAIRank;
    /** @var PLTAIRankCountRecord 0x1330 totalAssistKillsOfAIRank PLTAIRankCountRecord */
    public $totalAssistKillsOfAIRank;
    /** @var PLTCategoryTypeRecord 0x1378 totalHiddenCargoFound PLTCategoryTypeRecord */
    public $totalHiddenCargoFound;
    /** @var PLTCategoryTypeRecord 0x1384 totalLaserHit PLTCategoryTypeRecord */
    public $totalLaserHit;
    /** @var PLTCategoryTypeRecord 0x1390 totalLaserFired PLTCategoryTypeRecord */
    public $totalLaserFired;
    /** @var PLTCategoryTypeRecord 0x139C totalWarheadHit PLTCategoryTypeRecord */
    public $totalWarheadHit;
    /** @var PLTCategoryTypeRecord 0x13A8 totalWarheadFired PLTCategoryTypeRecord */
    public $totalWarheadFired;
    /** @var PLTCategoryTypeRecord 0x13B4 totalLosses PLTCategoryTypeRecord */
    public $totalLosses;
    /** @var PLTCategoryTypeRecord 0x13C0 totalLossesByCollision PLTCategoryTypeRecord */
    public $totalLossesByCollision;
    /** @var PLTCategoryTypeRecord 0x13CC totalLossesByStarship PLTCategoryTypeRecord */
    public $totalLossesByStarship;
    /** @var PLTCategoryTypeRecord 0x13D8 totalLossesByMines PLTCategoryTypeRecord */
    public $totalLossesByMines;
    /** @var PLTPlayerRankCountRecord 0x13E4 totalLossesByPlayerRank PLTPlayerRankCountRecord */
    public $totalLossesByPlayerRank;
    /** @var PLTAIRankCountRecord 0x1510 totalLossesByAIRank PLTAIRankCountRecord */
    public $totalLossesByAIRank;
    /** @var PLTMissionSPRecord[] 0x1558 missionSPExercise PLTMissionSPRecord */
    public $missionSPExercise;
    /** @var PLTMissionSPRecord[] 0x2368 missionSPMelee PLTMissionSPRecord */
    public $missionSPMelee;
    /** @var PLTMissionSPRecord[] 0x4690 missionSPCombat PLTMissionSPRecord */
    public $missionSPCombat;
    /** @var PLTMissionMPRecord[] 0x69B8 missionMPExercise PLTMissionMPRecord */
    public $missionMPExercise;
    /** @var PLTMissionMPRecord[] 0x7C78 missionMPMelee PLTMissionMPRecord */
    public $missionMPMelee;
    /** @var PLTMissionMPRecord[] 0xAB58 missionMPCombat PLTMissionMPRecord */
    public $missionMPCombat;
    /** @var PLTTournSPRecord[] 0xDA38 missionSPTourn PLTTournSPRecord */
    public $missionSPTourn;
    /** @var PLTTournMPRecord[] 0xDE20 missionMPTourn PLTTournMPRecord */
    public $missionMPTourn;
    /** @var PLTBattleSPRecord[] 0xE26C missionSPBattle PLTBattleSPRecord */
    public $missionSPBattle;
    /** @var PLTBattleMPRecord[] 0xE5F0 missionMPBattle PLTBattleMPRecord */
    public $missionMPBattle;
    /** @var PL2CampaignStatusSPRecord[] 0xE9D8 statusSPCampaign PL2CampaignStatusSPRecord */
    public $statusSPCampaign;
    /** @var PL2CampaignStatusSPRecord[] 0xED5C statusMPCampaignUNK PL2CampaignStatusSPRecord */
    public $statusMPCampaignUNK;
    /** @var PL2CampaignRecord[] 0xF0E0 missionSPCampaign PL2CampaignRecord */
    public $missionSPCampaign;
    /** @var PL2CampaignRecord[] 0xFD60 missionMPCampaign PL2CampaignRecord */
    public $missionMPCampaign;
    
    public function __construct($hex = null, $tie = null)
    {
        parent::__construct($hex, $tie);
    }

    /**
     * Process the $hex string provided in the constructor.
     * Separating the constructor and loading allows for the objects to be made from scratch.
     * @return $this 
     */
    public function loadHex()
    {
        $hex = $this->hex;
        $offset = 0;

        $this->totalMissionsFlown = $this->getInt($hex, 0x0000);
        $this->lastKnownTeam = $this->getInt($hex, 0x0004);
        $this->lastKnownFolderIndex = $this->getInt($hex, 0x0008);
        $this->selectedMissionIDNum = [];
        $offset = 0x000C;
        for ($i = 0; $i < 6; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->selectedMissionIDNum[] = $t;
            $offset += 4;
        }
        $this->unknown0x24 = [];
        $offset = 0x0024;
        for ($i = 0; $i < 8; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->unknown0x24[] = $t;
            $offset += 4;
        }
        $this->isMissionCategorySeries = $this->getInt($hex, 0x0044);
        $this->activeMissionIDNum = $this->getInt($hex, 0x0048);
        $this->earnedMedalCount = (new PLTEarnedMedalRecord(substr($hex, 0x004C), $this->TIE))->loadHex();
        $this->debriefMedalTypeMTEB = [];
        $offset = 0x00AC;
        for ($i = 0; $i < 4; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->debriefMedalTypeMTEB[] = $t;
            $offset += 4;
        }
        $this->UnknownRecord4 = [];
        $offset = 0x00BC;
        for ($i = 0; $i < 4; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->UnknownRecord4[] = $t;
            $offset += 4;
        }
        $this->totalFactionScore = $this->getInt($hex, 0x00CC);
        $this->totalScore = (new PLTCategoryTypeRecord(substr($hex, 0x00D0), $this->TIE))->loadHex();
        $this->totalFlownNonSeries = (new PLTCategoryTypeRecord(substr($hex, 0x00DC), $this->TIE))->loadHex();
        $this->totalFlownSeries = (new PLTCategoryTypeRecord(substr($hex, 0x00E8), $this->TIE))->loadHex();
        $this->totalFullKills = (new PLTCategoryTypeRecord(substr($hex, 0x00F4), $this->TIE))->loadHex();
        $this->totalFriendlyFullKills = (new PLTCategoryTypeRecord(substr($hex, 0x0100), $this->TIE))->loadHex();
        $this->totalFullKillsOnCraftEMC = [];
        $offset = 0x010C;
        for ($i = 0; $i < 300; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->totalFullKillsOnCraftEMC[] = $t;
            $offset += 4;
        }
        $this->totalSharedKillsOnCraftEMC = [];
        $offset = 0x05BC;
        for ($i = 0; $i < 300; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->totalSharedKillsOnCraftEMC[] = $t;
            $offset += 4;
        }
        $this->totalAssistKillsOnCraftEMC = [];
        $offset = 0x0A6C;
        for ($i = 0; $i < 300; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->totalAssistKillsOnCraftEMC[] = $t;
            $offset += 4;
        }
        $this->totalFullKillsOfPlayerRank = (new PLTPlayerRankCountRecord(substr($hex, 0x0F1C), $this->TIE))->loadHex();
        $this->totalSharedKillsOfPlayerRank = (new PLTPlayerRankCountRecord(substr($hex, 0x1048), $this->TIE))->loadHex();
        $this->totalAssistKillsOfPlayerRank = (new PLTPlayerRankCountRecord(substr($hex, 0x1174), $this->TIE))->loadHex();
        $this->totalFullKillsOfAIRank = (new PLTAIRankCountRecord(substr($hex, 0x12A0), $this->TIE))->loadHex();
        $this->totalSharedKillsOfAIRank = (new PLTAIRankCountRecord(substr($hex, 0x12E8), $this->TIE))->loadHex();
        $this->totalAssistKillsOfAIRank = (new PLTAIRankCountRecord(substr($hex, 0x1330), $this->TIE))->loadHex();
        $this->totalHiddenCargoFound = (new PLTCategoryTypeRecord(substr($hex, 0x1378), $this->TIE))->loadHex();
        $this->totalLaserHit = (new PLTCategoryTypeRecord(substr($hex, 0x1384), $this->TIE))->loadHex();
        $this->totalLaserFired = (new PLTCategoryTypeRecord(substr($hex, 0x1390), $this->TIE))->loadHex();
        $this->totalWarheadHit = (new PLTCategoryTypeRecord(substr($hex, 0x139C), $this->TIE))->loadHex();
        $this->totalWarheadFired = (new PLTCategoryTypeRecord(substr($hex, 0x13A8), $this->TIE))->loadHex();
        $this->totalLosses = (new PLTCategoryTypeRecord(substr($hex, 0x13B4), $this->TIE))->loadHex();
        $this->totalLossesByCollision = (new PLTCategoryTypeRecord(substr($hex, 0x13C0), $this->TIE))->loadHex();
        $this->totalLossesByStarship = (new PLTCategoryTypeRecord(substr($hex, 0x13CC), $this->TIE))->loadHex();
        $this->totalLossesByMines = (new PLTCategoryTypeRecord(substr($hex, 0x13D8), $this->TIE))->loadHex();
        $this->totalLossesByPlayerRank = (new PLTPlayerRankCountRecord(substr($hex, 0x13E4), $this->TIE))->loadHex();
        $this->totalLossesByAIRank = (new PLTAIRankCountRecord(substr($hex, 0x1510), $this->TIE))->loadHex();
        $this->missionSPExercise = [];
        $offset = 0x1558;
        for ($i = 0; $i < 100; $i++) {
            $t = (new PLTMissionSPRecord(substr($hex, $offset), $this->TIE))->loadHex();
            $this->missionSPExercise[] = $t;
            $offset += $t->getLength();
        }
        $this->missionSPMelee = [];
        $offset = 0x2368;
        for ($i = 0; $i < 250; $i++) {
            $t = (new PLTMissionSPRecord(substr($hex, $offset), $this->TIE))->loadHex();
            $this->missionSPMelee[] = $t;
            $offset += $t->getLength();
        }
        $this->missionSPCombat = [];
        $offset = 0x4690;
        for ($i = 0; $i < 250; $i++) {
            $t = (new PLTMissionSPRecord(substr($hex, $offset), $this->TIE))->loadHex();
            $this->missionSPCombat[] = $t;
            $offset += $t->getLength();
        }
        $this->missionMPExercise = [];
        $offset = 0x69B8;
        for ($i = 0; $i < 100; $i++) {
            $t = (new PLTMissionMPRecord(substr($hex, $offset), $this->TIE))->loadHex();
            $this->missionMPExercise[] = $t;
            $offset += $t->getLength();
        }
        $this->missionMPMelee = [];
        $offset = 0x7C78;
        for ($i = 0; $i < 250; $i++) {
            $t = (new PLTMissionMPRecord(substr($hex, $offset), $this->TIE))->loadHex();
            $this->missionMPMelee[] = $t;
            $offset += $t->getLength();
        }
        $this->missionMPCombat = [];
        $offset = 0xAB58;
        for ($i = 0; $i < 250; $i++) {
            $t = (new PLTMissionMPRecord(substr($hex, $offset), $this->TIE))->loadHex();
            $this->missionMPCombat[] = $t;
            $offset += $t->getLength();
        }
        $this->missionSPTourn = [];
        $offset = 0xDA38;
        for ($i = 0; $i < 25; $i++) {
            $t = (new PLTTournSPRecord(substr($hex, $offset), $this->TIE))->loadHex();
            $this->missionSPTourn[] = $t;
            $offset += $t->getLength();
        }
        $this->missionMPTourn = [];
        $offset = 0xDE20;
        for ($i = 0; $i < 25; $i++) {
            $t = (new PLTTournMPRecord(substr($hex, $offset), $this->TIE))->loadHex();
            $this->missionMPTourn[] = $t;
            $offset += $t->getLength();
        }
        $this->missionSPBattle = [];
        $offset = 0xE26C;
        for ($i = 0; $i < 25; $i++) {
            $t = (new PLTBattleSPRecord(substr($hex, $offset), $this->TIE))->loadHex();
            $this->missionSPBattle[] = $t;
            $offset += $t->getLength();
        }
        $this->missionMPBattle = [];
        $offset = 0xE5F0;
        for ($i = 0; $i < 25; $i++) {
            $t = (new PLTBattleMPRecord(substr($hex, $offset), $this->TIE))->loadHex();
            $this->missionMPBattle[] = $t;
            $offset += $t->getLength();
        }
        $this->statusSPCampaign = [];
        $offset = 0xE9D8;
        for ($i = 0; $i < 25; $i++) {
            $t = (new PL2CampaignStatusSPRecord(substr($hex, $offset), $this->TIE))->loadHex();
            $this->statusSPCampaign[] = $t;
            $offset += $t->getLength();
        }
        $this->statusMPCampaignUNK = [];
        $offset = 0xED5C;
        for ($i = 0; $i < 25; $i++) {
            $t = (new PL2CampaignStatusSPRecord(substr($hex, $offset), $this->TIE))->loadHex();
            $this->statusMPCampaignUNK[] = $t;
            $offset += $t->getLength();
        }
        $this->missionSPCampaign = [];
        $offset = 0xF0E0;
        for ($i = 0; $i < 100; $i++) {
            $t = (new PL2CampaignRecord(substr($hex, $offset), $this->TIE))->loadHex();
            $this->missionSPCampaign[] = $t;
            $offset += $t->getLength();
        }
        $this->missionMPCampaign = [];
        $offset = 0xFD60;
        for ($i = 0; $i < 100; $i++) {
            $t = (new PL2CampaignRecord(substr($hex, $offset), $this->TIE))->loadHex();
            $this->missionMPCampaign[] = $t;
            $offset += $t->getLength();
        }
        

        $this->hex = substr($this->hex, 0, $this->getLength());
        return $this;
    }
    
    public function __debugInfo()
    {
        return [
            "totalMissionsFlown" => $this->totalMissionsFlown,
            "lastKnownTeam" => $this->lastKnownTeam,
            "lastKnownFolderIndex" => $this->lastKnownFolderIndex,
            "selectedMissionIDNum" => $this->selectedMissionIDNum,
            "unknown0x24" => $this->unknown0x24,
            "isMissionCategorySeries" => $this->isMissionCategorySeries,
            "activeMissionIDNum" => $this->activeMissionIDNum,
            "earnedMedalCount" => $this->earnedMedalCount,
            "debriefMedalTypeMTEB" => $this->debriefMedalTypeMTEB,
            "UnknownRecord4" => $this->UnknownRecord4,
            "totalFactionScore" => $this->totalFactionScore,
            "totalScore" => $this->totalScore,
            "totalFlownNonSeries" => $this->totalFlownNonSeries,
            "totalFlownSeries" => $this->totalFlownSeries,
            "totalFullKills" => $this->totalFullKills,
            "totalFriendlyFullKills" => $this->totalFriendlyFullKills,
            "totalFullKillsOnCraftEMC" => $this->totalFullKillsOnCraftEMC,
            "totalSharedKillsOnCraftEMC" => $this->totalSharedKillsOnCraftEMC,
            "totalAssistKillsOnCraftEMC" => $this->totalAssistKillsOnCraftEMC,
            "totalFullKillsOfPlayerRank" => $this->totalFullKillsOfPlayerRank,
            "totalSharedKillsOfPlayerRank" => $this->totalSharedKillsOfPlayerRank,
            "totalAssistKillsOfPlayerRank" => $this->totalAssistKillsOfPlayerRank,
            "totalFullKillsOfAIRank" => $this->totalFullKillsOfAIRank,
            "totalSharedKillsOfAIRank" => $this->totalSharedKillsOfAIRank,
            "totalAssistKillsOfAIRank" => $this->totalAssistKillsOfAIRank,
            "totalHiddenCargoFound" => $this->totalHiddenCargoFound,
            "totalLaserHit" => $this->totalLaserHit,
            "totalLaserFired" => $this->totalLaserFired,
            "totalWarheadHit" => $this->totalWarheadHit,
            "totalWarheadFired" => $this->totalWarheadFired,
            "totalLosses" => $this->totalLosses,
            "totalLossesByCollision" => $this->totalLossesByCollision,
            "totalLossesByStarship" => $this->totalLossesByStarship,
            "totalLossesByMines" => $this->totalLossesByMines,
            "totalLossesByPlayerRank" => $this->totalLossesByPlayerRank,
            "totalLossesByAIRank" => $this->totalLossesByAIRank,
            "missionSPExercise" => $this->missionSPExercise,
            "missionSPMelee" => $this->missionSPMelee,
            "missionSPCombat" => $this->missionSPCombat,
            "missionMPExercise" => $this->missionMPExercise,
            "missionMPMelee" => $this->missionMPMelee,
            "missionMPCombat" => $this->missionMPCombat,
            "missionSPTourn" => $this->missionSPTourn,
            "missionMPTourn" => $this->missionMPTourn,
            "missionSPBattle" => $this->missionSPBattle,
            "missionMPBattle" => $this->missionMPBattle,
            "statusSPCampaign" => $this->statusSPCampaign,
            "statusMPCampaignUNK" => $this->statusMPCampaignUNK,
            "missionSPCampaign" => $this->missionSPCampaign,
            "missionMPCampaign" => $this->missionMPCampaign
        ];
    }
    
    public function toHexString($hex = null)
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $hex = $this->writeInt($this->totalMissionsFlown, $hex, 0x0000);
        $hex = $this->writeInt($this->lastKnownTeam, $hex, 0x0004);
        $hex = $this->writeInt($this->lastKnownFolderIndex, $hex, 0x0008);
        $offset = 0x000C;
        for ($i = 0; $i < 6; $i++) {
            $t = $this->selectedMissionIDNum[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $offset = 0x0024;
        for ($i = 0; $i < 8; $i++) {
            $t = $this->unknown0x24[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $hex = $this->writeInt($this->isMissionCategorySeries, $hex, 0x0044);
        $hex = $this->writeInt($this->activeMissionIDNum, $hex, 0x0048);
        $hex = $this->writeObject($this->earnedMedalCount, $hex, 0x004C);
        $offset = 0x00AC;
        for ($i = 0; $i < 4; $i++) {
            $t = $this->debriefMedalTypeMTEB[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $offset = 0x00BC;
        for ($i = 0; $i < 4; $i++) {
            $t = $this->UnknownRecord4[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $hex = $this->writeInt($this->totalFactionScore, $hex, 0x00CC);
        $hex = $this->writeObject($this->totalScore, $hex, 0x00D0);
        $hex = $this->writeObject($this->totalFlownNonSeries, $hex, 0x00DC);
        $hex = $this->writeObject($this->totalFlownSeries, $hex, 0x00E8);
        $hex = $this->writeObject($this->totalFullKills, $hex, 0x00F4);
        $hex = $this->writeObject($this->totalFriendlyFullKills, $hex, 0x0100);
        $offset = 0x010C;
        for ($i = 0; $i < 300; $i++) {
            $t = $this->totalFullKillsOnCraftEMC[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $offset = 0x05BC;
        for ($i = 0; $i < 300; $i++) {
            $t = $this->totalSharedKillsOnCraftEMC[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $offset = 0x0A6C;
        for ($i = 0; $i < 300; $i++) {
            $t = $this->totalAssistKillsOnCraftEMC[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $hex = $this->writeObject($this->totalFullKillsOfPlayerRank, $hex, 0x0F1C);
        $hex = $this->writeObject($this->totalSharedKillsOfPlayerRank, $hex, 0x1048);
        $hex = $this->writeObject($this->totalAssistKillsOfPlayerRank, $hex, 0x1174);
        $hex = $this->writeObject($this->totalFullKillsOfAIRank, $hex, 0x12A0);
        $hex = $this->writeObject($this->totalSharedKillsOfAIRank, $hex, 0x12E8);
        $hex = $this->writeObject($this->totalAssistKillsOfAIRank, $hex, 0x1330);
        $hex = $this->writeObject($this->totalHiddenCargoFound, $hex, 0x1378);
        $hex = $this->writeObject($this->totalLaserHit, $hex, 0x1384);
        $hex = $this->writeObject($this->totalLaserFired, $hex, 0x1390);
        $hex = $this->writeObject($this->totalWarheadHit, $hex, 0x139C);
        $hex = $this->writeObject($this->totalWarheadFired, $hex, 0x13A8);
        $hex = $this->writeObject($this->totalLosses, $hex, 0x13B4);
        $hex = $this->writeObject($this->totalLossesByCollision, $hex, 0x13C0);
        $hex = $this->writeObject($this->totalLossesByStarship, $hex, 0x13CC);
        $hex = $this->writeObject($this->totalLossesByMines, $hex, 0x13D8);
        $hex = $this->writeObject($this->totalLossesByPlayerRank, $hex, 0x13E4);
        $hex = $this->writeObject($this->totalLossesByAIRank, $hex, 0x1510);
        $offset = 0x1558;
        for ($i = 0; $i < 100; $i++) {
            $t = $this->missionSPExercise[$i];
            $hex = $this->writeObject($t, $hex, $offset);
            $offset += $t->getLength();
        }
        $offset = 0x2368;
        for ($i = 0; $i < 250; $i++) {
            $t = $this->missionSPMelee[$i];
            $hex = $this->writeObject($t, $hex, $offset);
            $offset += $t->getLength();
        }
        $offset = 0x4690;
        for ($i = 0; $i < 250; $i++) {
            $t = $this->missionSPCombat[$i];
            $hex = $this->writeObject($t, $hex, $offset);
            $offset += $t->getLength();
        }
        $offset = 0x69B8;
        for ($i = 0; $i < 100; $i++) {
            $t = $this->missionMPExercise[$i];
            $hex = $this->writeObject($t, $hex, $offset);
            $offset += $t->getLength();
        }
        $offset = 0x7C78;
        for ($i = 0; $i < 250; $i++) {
            $t = $this->missionMPMelee[$i];
            $hex = $this->writeObject($t, $hex, $offset);
            $offset += $t->getLength();
        }
        $offset = 0xAB58;
        for ($i = 0; $i < 250; $i++) {
            $t = $this->missionMPCombat[$i];
            $hex = $this->writeObject($t, $hex, $offset);
            $offset += $t->getLength();
        }
        $offset = 0xDA38;
        for ($i = 0; $i < 25; $i++) {
            $t = $this->missionSPTourn[$i];
            $hex = $this->writeObject($t, $hex, $offset);
            $offset += $t->getLength();
        }
        $offset = 0xDE20;
        for ($i = 0; $i < 25; $i++) {
            $t = $this->missionMPTourn[$i];
            $hex = $this->writeObject($t, $hex, $offset);
            $offset += $t->getLength();
        }
        $offset = 0xE26C;
        for ($i = 0; $i < 25; $i++) {
            $t = $this->missionSPBattle[$i];
            $hex = $this->writeObject($t, $hex, $offset);
            $offset += $t->getLength();
        }
        $offset = 0xE5F0;
        for ($i = 0; $i < 25; $i++) {
            $t = $this->missionMPBattle[$i];
            $hex = $this->writeObject($t, $hex, $offset);
            $offset += $t->getLength();
        }
        $offset = 0xE9D8;
        for ($i = 0; $i < 25; $i++) {
            $t = $this->statusSPCampaign[$i];
            $hex = $this->writeObject($t, $hex, $offset);
            $offset += $t->getLength();
        }
        $offset = 0xED5C;
        for ($i = 0; $i < 25; $i++) {
            $t = $this->statusMPCampaignUNK[$i];
            $hex = $this->writeObject($t, $hex, $offset);
            $offset += $t->getLength();
        }
        $offset = 0xF0E0;
        for ($i = 0; $i < 100; $i++) {
            $t = $this->missionSPCampaign[$i];
            $hex = $this->writeObject($t, $hex, $offset);
            $offset += $t->getLength();
        }
        $offset = 0xFD60;
        for ($i = 0; $i < 100; $i++) {
            $t = $this->missionMPCampaign[$i];
            $hex = $this->writeObject($t, $hex, $offset);
            $offset += $t->getLength();
        }

        return $hex;
    }
    
    
    public function getLength()
    {
        return self::PL2FACTIONRECORDLENGTH;
    }
}