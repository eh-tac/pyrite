<?php

namespace Pyrite\XvT\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;
use Pyrite\XvT\PL2CampaignProgressState;
use Pyrite\XvT\PL2CampaignState;
use Pyrite\XvT\PL2DebriefRecord;
use Pyrite\XvT\PL2FactionRecord;
use Pyrite\XvT\PLTAIRankCountRecord;
use Pyrite\XvT\PLTBattleProgressState;
use Pyrite\XvT\PLTBattleState;
use Pyrite\XvT\PLTCategoryTypeRecord;
use Pyrite\XvT\PLTConnectedPlayerData;
use Pyrite\XvT\PLTPlayerRankCountRecord;
use Pyrite\XvT\PLTTeamResultRecord;
use Pyrite\XvT\PLTTournamentProgressState;

abstract class PL2FileRecordBase extends PyriteBase implements Byteable
{
    use HexDecoder;
    use HexEncoder;

    /** @var integer  PL2FILERECORDLENGTH INT */
    public const PL2FILERECORDLENGTH = 296238;
    /** @var string 0x0000 PilotName CHAR */
    public $PilotName;
    /** @var PLTCategoryTypeRecord 0x033E totalScore PLTCategoryTypeRecord */
    public $totalScore;
    /** @var integer 0x0012 PlayerID INT */
    public $PlayerID;
    /** @var integer 0x0016 continuedOrReflownMission INT */
    public $continuedOrReflownMission;
    /** @var integer 0x001A isHosting INT */
    public $isHosting;
    /** @var integer 0x001E numHumanPlayersInMission INT */
    public $numHumanPlayersInMission;
    /** @var integer 0x0022 frontFlyMode INT */
    public $frontFlyMode;
    /** @var integer[] 0x0026 unknown0x26 INT */
    public $unknown0x26;
    /** @var integer[] 0x0166 unknown0x166 INT */
    public $unknown0x166;
    /** @var integer[] 0x0186 unknown0x186 INT */
    public $unknown0x186;
    /** @var integer 0x02C6 activeMissionTeam INT */
    public $activeMissionTeam;
    /** @var integer 0x02CA MissionFolderIndex INT */
    public $MissionFolderIndex;
    /** @var integer[] 0x02CE SelectedIDNumOfMissionCategory INT */
    public $SelectedIDNumOfMissionCategory;
    /** @var string 0x02E6 GameName CHAR */
    public $GameName;
    /** @var string 0x0306 LastGameName CHAR */
    public $LastGameName;
    /** @var integer 0x0326 isMissionCategorySeries INT */
    public $isMissionCategorySeries;
    /** @var integer 0x032A activeMissionIDNum INT */
    public $activeMissionIDNum;
    /** @var integer 0x032E PromoPoints INT */
    public $PromoPoints;
    /** @var integer 0x0332 WorsePromoPoints INT */
    public $WorsePromoPoints;
    /** @var integer 0x0336 RankAdjustmentApplied INT */
    public $RankAdjustmentApplied;
    /** @var integer 0x033A PercentToNextRank INT */
    public $PercentToNextRank;
    /** @var PLTCategoryTypeRecord 0x034A numFlownNonSeries PLTCategoryTypeRecord */
    public $numFlownNonSeries;
    /** @var PLTCategoryTypeRecord 0x0356 numFlownSeries PLTCategoryTypeRecord */
    public $numFlownSeries;
    /** @var PLTCategoryTypeRecord 0x0362 totalKillCount PLTCategoryTypeRecord */
    public $totalKillCount;
    /** @var PLTCategoryTypeRecord 0x036E totalFriendlyKillCount PLTCategoryTypeRecord */
    public $totalFriendlyKillCount;
    /** @var integer[] 0x037A totalKillCountByCraftType INT */
    public $totalKillCountByCraftType;
    /** @var PLTPlayerRankCountRecord 0x118A totalFullKillsOnPlayerRank PLTPlayerRankCountRecord */
    public $totalFullKillsOnPlayerRank;
    /** @var PLTPlayerRankCountRecord 0x12B6 totalSharedKillsOnPlayerRank PLTPlayerRankCountRecord */
    public $totalSharedKillsOnPlayerRank;
    /** @var PLTPlayerRankCountRecord 0x13E2 totalAssistKillsOnPlayerRank PLTPlayerRankCountRecord */
    public $totalAssistKillsOnPlayerRank;
    /** @var PLTAIRankCountRecord 0x150E totalFullKillsOnAIRank PLTAIRankCountRecord */
    public $totalFullKillsOnAIRank;
    /** @var PLTAIRankCountRecord 0x1556 totalSharedKillsOnAIRank PLTAIRankCountRecord */
    public $totalSharedKillsOnAIRank;
    /** @var PLTAIRankCountRecord 0x159E totalAssistKillsOnAIRank PLTAIRankCountRecord */
    public $totalAssistKillsOnAIRank;
    /** @var PLTCategoryTypeRecord 0x15E6 totalHiddenCargoFound PLTCategoryTypeRecord */
    public $totalHiddenCargoFound;
    /** @var PLTCategoryTypeRecord 0x15F2 totalLaserHit PLTCategoryTypeRecord */
    public $totalLaserHit;
    /** @var PLTCategoryTypeRecord 0x15FE totalLaserFired PLTCategoryTypeRecord */
    public $totalLaserFired;
    /** @var PLTCategoryTypeRecord 0x160A totalWarheadHit PLTCategoryTypeRecord */
    public $totalWarheadHit;
    /** @var PLTCategoryTypeRecord 0x1616 totalWarheadFired PLTCategoryTypeRecord */
    public $totalWarheadFired;
    /** @var PLTCategoryTypeRecord 0x1622 totalCraftLosses PLTCategoryTypeRecord */
    public $totalCraftLosses;
    /** @var PLTCategoryTypeRecord 0x162E totalLossesFromCollision PLTCategoryTypeRecord */
    public $totalLossesFromCollision;
    /** @var PLTCategoryTypeRecord 0x163A totalLossesFromStarships PLTCategoryTypeRecord */
    public $totalLossesFromStarships;
    /** @var PLTCategoryTypeRecord 0x1646 totalLossesFromMines PLTCategoryTypeRecord */
    public $totalLossesFromMines;
    /** @var PLTPlayerRankCountRecord 0x1652 totalLossesFromPlayerRank PLTPlayerRankCountRecord */
    public $totalLossesFromPlayerRank;
    /** @var PLTAIRankCountRecord 0x177E totalLossesFromAIRank PLTAIRankCountRecord */
    public $totalLossesFromAIRank;
    /** @var PLTTournamentProgressState 0x17C6 activeTournament PLTTournamentProgressState */
    public $activeTournament;
    /** @var PLTBattleProgressState 0x18C6 activeBattle PLTBattleProgressState */
    public $activeBattle;
    /** @var integer 0x1952 CurrentRank INT */
    public $CurrentRank;
    /** @var integer 0x1956 totalCountMissionsFlown INT */
    public $totalCountMissionsFlown;
    /** @var integer[] 0x195A RankAchievedOnMissionCount INT */
    public $RankAchievedOnMissionCount;
    /** @var string 0x19BE RankString CHAR */
    public $RankString;
    /** @var integer 0x19DE debriefMissionScore INT */
    public $debriefMissionScore;
    /** @var integer[] 0x19E2 debriefFullKillsOnPlayer INT */
    public $debriefFullKillsOnPlayer;
    /** @var integer[] 0x1A02 debriefSharedKillsOnPlayer INT */
    public $debriefSharedKillsOnPlayer;
    /** @var integer[] 0x1A22 debriefFullKillsOnFG INT */
    public $debriefFullKillsOnFG;
    /** @var integer[] 0x1AE2 debriefSharedKillsOnFG INT */
    public $debriefSharedKillsOnFG;
    /** @var integer[] 0x1BA2 debriefFullKillsByPlayer INT */
    public $debriefFullKillsByPlayer;
    /** @var integer[] 0x1BC2 debriefSharedKillsByPlayer INT */
    public $debriefSharedKillsByPlayer;
    /** @var integer[] 0x1BE2 debriefFullKillsByFG INT */
    public $debriefFullKillsByFG;
    /** @var integer[] 0x1CA2 debriefSharedKillsByFG INT */
    public $debriefSharedKillsByFG;
    /** @var integer[] 0x1D62 debriefMeleeAIRankFG INT */
    public $debriefMeleeAIRankFG;
    /** @var PL2DebriefRecord 0x1E22 debrief PL2DebriefRecord */
    public $debrief;
    /** @var PLTConnectedPlayerData[] 0x32AA connectedPlayerData PLTConnectedPlayerData */
    public $connectedPlayerData;
    /** @var PLTTeamResultRecord[] 0x356A debriefTeamResult PLTTeamResultRecord */
    public $debriefTeamResult;
    /** @var integer 0x3682 SelectedFaction INT */
    public $SelectedFaction;
    /** @var PL2FactionRecord[] 0x3686 faction PL2FactionRecord */
    public $faction;
    /** @var PL2CampaignProgressState 0x45E06 activeCampaign PL2CampaignProgressState */
    public $activeCampaign;
    /** @var integer[] 0x45E1E gap45E1E BYTE */
    public $gap45E1E;
    /** @var PLTBattleState[] 0x45E22 spBattleState PLTBattleState */
    public $spBattleState;
    /** @var PLTBattleState[] 0x46DC2 mpBattleState PLTBattleState */
    public $mpBattleState;
    /** @var PL2CampaignState[] 0x47D62 spCampaignState PL2CampaignState */
    public $spCampaignState;
    /** @var PL2CampaignState[] 0x4814A mpCampaignHostState PL2CampaignState */
    public $mpCampaignHostState;
    /** @var PL2CampaignState[] 0x4832A mpCampaignClientState PL2CampaignState */
    public $mpCampaignClientState;
    /** @var integer[] 0x4850A anonymous_259 INT */
    public $anonymous_259;
    /** @var integer 0x4852A anonymous_260 SHORT */
    public $anonymous_260;
    /** @var integer 0x4852C anonymous_261 SHORT */
    public $anonymous_261;
    
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

        $this->PilotName = $this->getChar($hex, 0x0000, 14);
        $this->totalScore = (new PLTCategoryTypeRecord(substr($hex, 0x033E), $this->TIE))->loadHex();
        $this->PlayerID = $this->getInt($hex, 0x0012);
        $this->continuedOrReflownMission = $this->getInt($hex, 0x0016);
        $this->isHosting = $this->getInt($hex, 0x001A);
        $this->numHumanPlayersInMission = $this->getInt($hex, 0x001E);
        $this->frontFlyMode = $this->getInt($hex, 0x0022);
        $this->unknown0x26 = [];
        $offset = 0x0026;
        for ($i = 0; $i < 80; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->unknown0x26[] = $t;
            $offset += 4;
        }
        $this->unknown0x166 = [];
        $offset = 0x0166;
        for ($i = 0; $i < 8; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->unknown0x166[] = $t;
            $offset += 4;
        }
        $this->unknown0x186 = [];
        $offset = 0x0186;
        for ($i = 0; $i < 80; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->unknown0x186[] = $t;
            $offset += 4;
        }
        $this->activeMissionTeam = $this->getInt($hex, 0x02C6);
        $this->MissionFolderIndex = $this->getInt($hex, 0x02CA);
        $this->SelectedIDNumOfMissionCategory = [];
        $offset = 0x02CE;
        for ($i = 0; $i < 6; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->SelectedIDNumOfMissionCategory[] = $t;
            $offset += 4;
        }
        $this->GameName = $this->getChar($hex, 0x02E6, 32);
        $this->LastGameName = $this->getChar($hex, 0x0306, 32);
        $this->isMissionCategorySeries = $this->getInt($hex, 0x0326);
        $this->activeMissionIDNum = $this->getInt($hex, 0x032A);
        $this->PromoPoints = $this->getInt($hex, 0x032E);
        $this->WorsePromoPoints = $this->getInt($hex, 0x0332);
        $this->RankAdjustmentApplied = $this->getInt($hex, 0x0336);
        $this->PercentToNextRank = $this->getInt($hex, 0x033A);
        $this->numFlownNonSeries = (new PLTCategoryTypeRecord(substr($hex, 0x034A), $this->TIE))->loadHex();
        $this->numFlownSeries = (new PLTCategoryTypeRecord(substr($hex, 0x0356), $this->TIE))->loadHex();
        $this->totalKillCount = (new PLTCategoryTypeRecord(substr($hex, 0x0362), $this->TIE))->loadHex();
        $this->totalFriendlyKillCount = (new PLTCategoryTypeRecord(substr($hex, 0x036E), $this->TIE))->loadHex();
        $this->totalKillCountByCraftType = [];
        $offset = 0x037A;
        for ($i = 0; $i < 900; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->totalKillCountByCraftType[] = $t;
            $offset += 4;
        }
        $this->totalFullKillsOnPlayerRank = (new PLTPlayerRankCountRecord(substr($hex, 0x118A), $this->TIE))->loadHex();
        $this->totalSharedKillsOnPlayerRank = (new PLTPlayerRankCountRecord(substr($hex, 0x12B6), $this->TIE))->loadHex();
        $this->totalAssistKillsOnPlayerRank = (new PLTPlayerRankCountRecord(substr($hex, 0x13E2), $this->TIE))->loadHex();
        $this->totalFullKillsOnAIRank = (new PLTAIRankCountRecord(substr($hex, 0x150E), $this->TIE))->loadHex();
        $this->totalSharedKillsOnAIRank = (new PLTAIRankCountRecord(substr($hex, 0x1556), $this->TIE))->loadHex();
        $this->totalAssistKillsOnAIRank = (new PLTAIRankCountRecord(substr($hex, 0x159E), $this->TIE))->loadHex();
        $this->totalHiddenCargoFound = (new PLTCategoryTypeRecord(substr($hex, 0x15E6), $this->TIE))->loadHex();
        $this->totalLaserHit = (new PLTCategoryTypeRecord(substr($hex, 0x15F2), $this->TIE))->loadHex();
        $this->totalLaserFired = (new PLTCategoryTypeRecord(substr($hex, 0x15FE), $this->TIE))->loadHex();
        $this->totalWarheadHit = (new PLTCategoryTypeRecord(substr($hex, 0x160A), $this->TIE))->loadHex();
        $this->totalWarheadFired = (new PLTCategoryTypeRecord(substr($hex, 0x1616), $this->TIE))->loadHex();
        $this->totalCraftLosses = (new PLTCategoryTypeRecord(substr($hex, 0x1622), $this->TIE))->loadHex();
        $this->totalLossesFromCollision = (new PLTCategoryTypeRecord(substr($hex, 0x162E), $this->TIE))->loadHex();
        $this->totalLossesFromStarships = (new PLTCategoryTypeRecord(substr($hex, 0x163A), $this->TIE))->loadHex();
        $this->totalLossesFromMines = (new PLTCategoryTypeRecord(substr($hex, 0x1646), $this->TIE))->loadHex();
        $this->totalLossesFromPlayerRank = (new PLTPlayerRankCountRecord(substr($hex, 0x1652), $this->TIE))->loadHex();
        $this->totalLossesFromAIRank = (new PLTAIRankCountRecord(substr($hex, 0x177E), $this->TIE))->loadHex();
        $this->activeTournament = (new PLTTournamentProgressState(substr($hex, 0x17C6), $this->TIE))->loadHex();
        $this->activeBattle = (new PLTBattleProgressState(substr($hex, 0x18C6), $this->TIE))->loadHex();
        $this->CurrentRank = $this->getInt($hex, 0x1952);
        $this->totalCountMissionsFlown = $this->getInt($hex, 0x1956);
        $this->RankAchievedOnMissionCount = [];
        $offset = 0x195A;
        for ($i = 0; $i < 25; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->RankAchievedOnMissionCount[] = $t;
            $offset += 4;
        }
        $this->RankString = $this->getChar($hex, 0x19BE, 32);
        $this->debriefMissionScore = $this->getInt($hex, 0x19DE);
        $this->debriefFullKillsOnPlayer = [];
        $offset = 0x19E2;
        for ($i = 0; $i < 8; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->debriefFullKillsOnPlayer[] = $t;
            $offset += 4;
        }
        $this->debriefSharedKillsOnPlayer = [];
        $offset = 0x1A02;
        for ($i = 0; $i < 8; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->debriefSharedKillsOnPlayer[] = $t;
            $offset += 4;
        }
        $this->debriefFullKillsOnFG = [];
        $offset = 0x1A22;
        for ($i = 0; $i < 48; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->debriefFullKillsOnFG[] = $t;
            $offset += 4;
        }
        $this->debriefSharedKillsOnFG = [];
        $offset = 0x1AE2;
        for ($i = 0; $i < 48; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->debriefSharedKillsOnFG[] = $t;
            $offset += 4;
        }
        $this->debriefFullKillsByPlayer = [];
        $offset = 0x1BA2;
        for ($i = 0; $i < 8; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->debriefFullKillsByPlayer[] = $t;
            $offset += 4;
        }
        $this->debriefSharedKillsByPlayer = [];
        $offset = 0x1BC2;
        for ($i = 0; $i < 8; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->debriefSharedKillsByPlayer[] = $t;
            $offset += 4;
        }
        $this->debriefFullKillsByFG = [];
        $offset = 0x1BE2;
        for ($i = 0; $i < 48; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->debriefFullKillsByFG[] = $t;
            $offset += 4;
        }
        $this->debriefSharedKillsByFG = [];
        $offset = 0x1CA2;
        for ($i = 0; $i < 48; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->debriefSharedKillsByFG[] = $t;
            $offset += 4;
        }
        $this->debriefMeleeAIRankFG = [];
        $offset = 0x1D62;
        for ($i = 0; $i < 48; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->debriefMeleeAIRankFG[] = $t;
            $offset += 4;
        }
        $this->debrief = (new PL2DebriefRecord(substr($hex, 0x1E22), $this->TIE))->loadHex();
        $this->connectedPlayerData = [];
        $offset = 0x32AA;
        for ($i = 0; $i < 8; $i++) {
            $t = (new PLTConnectedPlayerData(substr($hex, $offset), $this->TIE))->loadHex();
            $this->connectedPlayerData[] = $t;
            $offset += $t->getLength();
        }
        $this->debriefTeamResult = [];
        $offset = 0x356A;
        for ($i = 0; $i < 10; $i++) {
            $t = (new PLTTeamResultRecord(substr($hex, $offset), $this->TIE))->loadHex();
            $this->debriefTeamResult[] = $t;
            $offset += $t->getLength();
        }
        $this->SelectedFaction = $this->getInt($hex, 0x3682);
        $this->faction = [];
        $offset = 0x3686;
        for ($i = 0; $i < 4; $i++) {
            $t = (new PL2FactionRecord(substr($hex, $offset), $this->TIE))->loadHex();
            $this->faction[] = $t;
            $offset += $t->getLength();
        }
        $this->activeCampaign = (new PL2CampaignProgressState(substr($hex, 0x45E06), $this->TIE))->loadHex();
        $this->gap45E1E = [];
        $offset = 0x45E1E;
        for ($i = 0; $i < 4; $i++) {
            $t = $this->getByte($hex, $offset);
            $this->gap45E1E[] = $t;
            $offset += 1;
        }
        $this->spBattleState = [];
        $offset = 0x45E22;
        for ($i = 0; $i < 25; $i++) {
            $t = (new PLTBattleState(substr($hex, $offset), $this->TIE))->loadHex();
            $this->spBattleState[] = $t;
            $offset += $t->getLength();
        }
        $this->mpBattleState = [];
        $offset = 0x46DC2;
        for ($i = 0; $i < 25; $i++) {
            $t = (new PLTBattleState(substr($hex, $offset), $this->TIE))->loadHex();
            $this->mpBattleState[] = $t;
            $offset += $t->getLength();
        }
        $this->spCampaignState = [];
        $offset = 0x47D62;
        for ($i = 0; $i < 25; $i++) {
            $t = (new PL2CampaignState(substr($hex, $offset), $this->TIE))->loadHex();
            $this->spCampaignState[] = $t;
            $offset += $t->getLength();
        }
        $this->mpCampaignHostState = [];
        $offset = 0x4814A;
        for ($i = 0; $i < 12; $i++) {
            $t = (new PL2CampaignState(substr($hex, $offset), $this->TIE))->loadHex();
            $this->mpCampaignHostState[] = $t;
            $offset += $t->getLength();
        }
        $this->mpCampaignClientState = [];
        $offset = 0x4832A;
        for ($i = 0; $i < 12; $i++) {
            $t = (new PL2CampaignState(substr($hex, $offset), $this->TIE))->loadHex();
            $this->mpCampaignClientState[] = $t;
            $offset += $t->getLength();
        }
        $this->anonymous_259 = [];
        $offset = 0x4850A;
        for ($i = 0; $i < 8; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->anonymous_259[] = $t;
            $offset += 4;
        }
        $this->anonymous_260 = $this->getShort($hex, 0x4852A);
        $this->anonymous_261 = $this->getShort($hex, 0x4852C);
        

        $this->hex = substr($this->hex, 0, $this->getLength());
        return $this;
    }
    
    public function __debugInfo()
    {
        return [
            "PilotName" => $this->PilotName,
            "totalScore" => $this->totalScore,
            "PlayerID" => $this->PlayerID,
            "continuedOrReflownMission" => $this->continuedOrReflownMission,
            "isHosting" => $this->isHosting,
            "numHumanPlayersInMission" => $this->numHumanPlayersInMission,
            "frontFlyMode" => $this->frontFlyMode,
            "unknown0x26" => $this->unknown0x26,
            "unknown0x166" => $this->unknown0x166,
            "unknown0x186" => $this->unknown0x186,
            "activeMissionTeam" => $this->activeMissionTeam,
            "MissionFolderIndex" => $this->MissionFolderIndex,
            "SelectedIDNumOfMissionCategory" => $this->SelectedIDNumOfMissionCategory,
            "GameName" => $this->GameName,
            "LastGameName" => $this->LastGameName,
            "isMissionCategorySeries" => $this->isMissionCategorySeries,
            "activeMissionIDNum" => $this->activeMissionIDNum,
            "PromoPoints" => $this->PromoPoints,
            "WorsePromoPoints" => $this->WorsePromoPoints,
            "RankAdjustmentApplied" => $this->RankAdjustmentApplied,
            "PercentToNextRank" => $this->PercentToNextRank,
            "numFlownNonSeries" => $this->numFlownNonSeries,
            "numFlownSeries" => $this->numFlownSeries,
            "totalKillCount" => $this->totalKillCount,
            "totalFriendlyKillCount" => $this->totalFriendlyKillCount,
            "totalKillCountByCraftType" => $this->totalKillCountByCraftType,
            "totalFullKillsOnPlayerRank" => $this->totalFullKillsOnPlayerRank,
            "totalSharedKillsOnPlayerRank" => $this->totalSharedKillsOnPlayerRank,
            "totalAssistKillsOnPlayerRank" => $this->totalAssistKillsOnPlayerRank,
            "totalFullKillsOnAIRank" => $this->totalFullKillsOnAIRank,
            "totalSharedKillsOnAIRank" => $this->totalSharedKillsOnAIRank,
            "totalAssistKillsOnAIRank" => $this->totalAssistKillsOnAIRank,
            "totalHiddenCargoFound" => $this->totalHiddenCargoFound,
            "totalLaserHit" => $this->totalLaserHit,
            "totalLaserFired" => $this->totalLaserFired,
            "totalWarheadHit" => $this->totalWarheadHit,
            "totalWarheadFired" => $this->totalWarheadFired,
            "totalCraftLosses" => $this->totalCraftLosses,
            "totalLossesFromCollision" => $this->totalLossesFromCollision,
            "totalLossesFromStarships" => $this->totalLossesFromStarships,
            "totalLossesFromMines" => $this->totalLossesFromMines,
            "totalLossesFromPlayerRank" => $this->totalLossesFromPlayerRank,
            "totalLossesFromAIRank" => $this->totalLossesFromAIRank,
            "activeTournament" => $this->activeTournament,
            "activeBattle" => $this->activeBattle,
            "CurrentRank" => $this->CurrentRank,
            "totalCountMissionsFlown" => $this->totalCountMissionsFlown,
            "RankAchievedOnMissionCount" => $this->RankAchievedOnMissionCount,
            "RankString" => $this->RankString,
            "debriefMissionScore" => $this->debriefMissionScore,
            "debriefFullKillsOnPlayer" => $this->debriefFullKillsOnPlayer,
            "debriefSharedKillsOnPlayer" => $this->debriefSharedKillsOnPlayer,
            "debriefFullKillsOnFG" => $this->debriefFullKillsOnFG,
            "debriefSharedKillsOnFG" => $this->debriefSharedKillsOnFG,
            "debriefFullKillsByPlayer" => $this->debriefFullKillsByPlayer,
            "debriefSharedKillsByPlayer" => $this->debriefSharedKillsByPlayer,
            "debriefFullKillsByFG" => $this->debriefFullKillsByFG,
            "debriefSharedKillsByFG" => $this->debriefSharedKillsByFG,
            "debriefMeleeAIRankFG" => $this->debriefMeleeAIRankFG,
            "debrief" => $this->debrief,
            "connectedPlayerData" => $this->connectedPlayerData,
            "debriefTeamResult" => $this->debriefTeamResult,
            "SelectedFaction" => $this->SelectedFaction,
            "faction" => $this->faction,
            "activeCampaign" => $this->activeCampaign,
            "gap45E1E" => $this->gap45E1E,
            "spBattleState" => $this->spBattleState,
            "mpBattleState" => $this->mpBattleState,
            "spCampaignState" => $this->spCampaignState,
            "mpCampaignHostState" => $this->mpCampaignHostState,
            "mpCampaignClientState" => $this->mpCampaignClientState,
            "anonymous_259" => $this->anonymous_259,
            "anonymous_260" => $this->anonymous_260,
            "anonymous_261" => $this->anonymous_261
        ];
    }
    
    public function toHexString($hex = null)
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $hex = $this->writeChar($this->PilotName, $hex, 0x0000);
        $hex = $this->writeObject($this->totalScore, $hex, 0x033E);
        $hex = $this->writeInt($this->PlayerID, $hex, 0x0012);
        $hex = $this->writeInt($this->continuedOrReflownMission, $hex, 0x0016);
        $hex = $this->writeInt($this->isHosting, $hex, 0x001A);
        $hex = $this->writeInt($this->numHumanPlayersInMission, $hex, 0x001E);
        $hex = $this->writeInt($this->frontFlyMode, $hex, 0x0022);
        $offset = 0x0026;
        for ($i = 0; $i < 80; $i++) {
            $t = $this->unknown0x26[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $offset = 0x0166;
        for ($i = 0; $i < 8; $i++) {
            $t = $this->unknown0x166[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $offset = 0x0186;
        for ($i = 0; $i < 80; $i++) {
            $t = $this->unknown0x186[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $hex = $this->writeInt($this->activeMissionTeam, $hex, 0x02C6);
        $hex = $this->writeInt($this->MissionFolderIndex, $hex, 0x02CA);
        $offset = 0x02CE;
        for ($i = 0; $i < 6; $i++) {
            $t = $this->SelectedIDNumOfMissionCategory[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $hex = $this->writeChar($this->GameName, $hex, 0x02E6);
        $hex = $this->writeChar($this->LastGameName, $hex, 0x0306);
        $hex = $this->writeInt($this->isMissionCategorySeries, $hex, 0x0326);
        $hex = $this->writeInt($this->activeMissionIDNum, $hex, 0x032A);
        $hex = $this->writeInt($this->PromoPoints, $hex, 0x032E);
        $hex = $this->writeInt($this->WorsePromoPoints, $hex, 0x0332);
        $hex = $this->writeInt($this->RankAdjustmentApplied, $hex, 0x0336);
        $hex = $this->writeInt($this->PercentToNextRank, $hex, 0x033A);
        $hex = $this->writeObject($this->numFlownNonSeries, $hex, 0x034A);
        $hex = $this->writeObject($this->numFlownSeries, $hex, 0x0356);
        $hex = $this->writeObject($this->totalKillCount, $hex, 0x0362);
        $hex = $this->writeObject($this->totalFriendlyKillCount, $hex, 0x036E);
        $offset = 0x037A;
        for ($i = 0; $i < 900; $i++) {
            $t = $this->totalKillCountByCraftType[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $hex = $this->writeObject($this->totalFullKillsOnPlayerRank, $hex, 0x118A);
        $hex = $this->writeObject($this->totalSharedKillsOnPlayerRank, $hex, 0x12B6);
        $hex = $this->writeObject($this->totalAssistKillsOnPlayerRank, $hex, 0x13E2);
        $hex = $this->writeObject($this->totalFullKillsOnAIRank, $hex, 0x150E);
        $hex = $this->writeObject($this->totalSharedKillsOnAIRank, $hex, 0x1556);
        $hex = $this->writeObject($this->totalAssistKillsOnAIRank, $hex, 0x159E);
        $hex = $this->writeObject($this->totalHiddenCargoFound, $hex, 0x15E6);
        $hex = $this->writeObject($this->totalLaserHit, $hex, 0x15F2);
        $hex = $this->writeObject($this->totalLaserFired, $hex, 0x15FE);
        $hex = $this->writeObject($this->totalWarheadHit, $hex, 0x160A);
        $hex = $this->writeObject($this->totalWarheadFired, $hex, 0x1616);
        $hex = $this->writeObject($this->totalCraftLosses, $hex, 0x1622);
        $hex = $this->writeObject($this->totalLossesFromCollision, $hex, 0x162E);
        $hex = $this->writeObject($this->totalLossesFromStarships, $hex, 0x163A);
        $hex = $this->writeObject($this->totalLossesFromMines, $hex, 0x1646);
        $hex = $this->writeObject($this->totalLossesFromPlayerRank, $hex, 0x1652);
        $hex = $this->writeObject($this->totalLossesFromAIRank, $hex, 0x177E);
        $hex = $this->writeObject($this->activeTournament, $hex, 0x17C6);
        $hex = $this->writeObject($this->activeBattle, $hex, 0x18C6);
        $hex = $this->writeInt($this->CurrentRank, $hex, 0x1952);
        $hex = $this->writeInt($this->totalCountMissionsFlown, $hex, 0x1956);
        $offset = 0x195A;
        for ($i = 0; $i < 25; $i++) {
            $t = $this->RankAchievedOnMissionCount[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $hex = $this->writeChar($this->RankString, $hex, 0x19BE);
        $hex = $this->writeInt($this->debriefMissionScore, $hex, 0x19DE);
        $offset = 0x19E2;
        for ($i = 0; $i < 8; $i++) {
            $t = $this->debriefFullKillsOnPlayer[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $offset = 0x1A02;
        for ($i = 0; $i < 8; $i++) {
            $t = $this->debriefSharedKillsOnPlayer[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $offset = 0x1A22;
        for ($i = 0; $i < 48; $i++) {
            $t = $this->debriefFullKillsOnFG[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $offset = 0x1AE2;
        for ($i = 0; $i < 48; $i++) {
            $t = $this->debriefSharedKillsOnFG[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $offset = 0x1BA2;
        for ($i = 0; $i < 8; $i++) {
            $t = $this->debriefFullKillsByPlayer[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $offset = 0x1BC2;
        for ($i = 0; $i < 8; $i++) {
            $t = $this->debriefSharedKillsByPlayer[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $offset = 0x1BE2;
        for ($i = 0; $i < 48; $i++) {
            $t = $this->debriefFullKillsByFG[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $offset = 0x1CA2;
        for ($i = 0; $i < 48; $i++) {
            $t = $this->debriefSharedKillsByFG[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $offset = 0x1D62;
        for ($i = 0; $i < 48; $i++) {
            $t = $this->debriefMeleeAIRankFG[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $hex = $this->writeObject($this->debrief, $hex, 0x1E22);
        $offset = 0x32AA;
        for ($i = 0; $i < 8; $i++) {
            $t = $this->connectedPlayerData[$i];
            $hex = $this->writeObject($t, $hex, $offset);
            $offset += $t->getLength();
        }
        $offset = 0x356A;
        for ($i = 0; $i < 10; $i++) {
            $t = $this->debriefTeamResult[$i];
            $hex = $this->writeObject($t, $hex, $offset);
            $offset += $t->getLength();
        }
        $hex = $this->writeInt($this->SelectedFaction, $hex, 0x3682);
        $offset = 0x3686;
        for ($i = 0; $i < 4; $i++) {
            $t = $this->faction[$i];
            $hex = $this->writeObject($t, $hex, $offset);
            $offset += $t->getLength();
        }
        $hex = $this->writeObject($this->activeCampaign, $hex, 0x45E06);
        $offset = 0x45E1E;
        for ($i = 0; $i < 4; $i++) {
            $t = $this->gap45E1E[$i];
            $hex = $this->writeByte($t, $hex, $offset);
            $offset += 1;
        }
        $offset = 0x45E22;
        for ($i = 0; $i < 25; $i++) {
            $t = $this->spBattleState[$i];
            $hex = $this->writeObject($t, $hex, $offset);
            $offset += $t->getLength();
        }
        $offset = 0x46DC2;
        for ($i = 0; $i < 25; $i++) {
            $t = $this->mpBattleState[$i];
            $hex = $this->writeObject($t, $hex, $offset);
            $offset += $t->getLength();
        }
        $offset = 0x47D62;
        for ($i = 0; $i < 25; $i++) {
            $t = $this->spCampaignState[$i];
            $hex = $this->writeObject($t, $hex, $offset);
            $offset += $t->getLength();
        }
        $offset = 0x4814A;
        for ($i = 0; $i < 12; $i++) {
            $t = $this->mpCampaignHostState[$i];
            $hex = $this->writeObject($t, $hex, $offset);
            $offset += $t->getLength();
        }
        $offset = 0x4832A;
        for ($i = 0; $i < 12; $i++) {
            $t = $this->mpCampaignClientState[$i];
            $hex = $this->writeObject($t, $hex, $offset);
            $offset += $t->getLength();
        }
        $offset = 0x4850A;
        for ($i = 0; $i < 8; $i++) {
            $t = $this->anonymous_259[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $hex = $this->writeShort($this->anonymous_260, $hex, 0x4852A);
        $hex = $this->writeShort($this->anonymous_261, $hex, 0x4852C);

        return $hex;
    }
    
    
    public function getLength()
    {
        return self::PL2FILERECORDLENGTH;
    }
}