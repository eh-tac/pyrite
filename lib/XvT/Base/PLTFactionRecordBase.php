<?php

namespace Pyrite\XvT\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;
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

abstract class PLTFactionRecordBase extends PyriteBase implements Byteable
{
    use HexDecoder;
    use HexEncoder;

    /** @var integer  PLTFACTIONRECORDLENGTH INT */
    public const PLTFACTIONRECORDLENGTH = 59428;
    /** @var integer 0x0000 totalMissionsFlown INT */
    public $totalMissionsFlown;
    /** @var integer 0x0004 lastMissionTeam INT */
    public $lastMissionTeam;
    /** @var integer 0x0008 lastMissionType INT */
    public $lastMissionType;
    /** @var integer 0x000C lastMissionTrainingSelected INT */
    public $lastMissionTrainingSelected;
    /** @var integer 0x0010 lastMissionMeleeSelected INT */
    public $lastMissionMeleeSelected;
    /** @var integer 0x0014 lastMissionTournamentSelected INT */
    public $lastMissionTournamentSelected;
    /** @var integer 0x0018 lastMissionCombatSelected INT */
    public $lastMissionCombatSelected;
    /** @var integer 0x001C lastMissionBattleSelected INT */
    public $lastMissionBattleSelected;
    /** @var integer[] 0x0020 unknown0x20 INT */
    public $unknown0x20;
    /** @var PLTEarnedMedalRecord 0x0048 earnedMedalCount PLTEarnedMedalRecord */
    public $earnedMedalCount;
    /** @var integer 0x00A8 debriefMeleePlaqueType INT */
    public $debriefMeleePlaqueType;
    /** @var integer 0x00AC debriefTournamentTrophyType INT */
    public $debriefTournamentTrophyType;
    /** @var integer 0x00B0 debriefMissionBadgeType INT */
    public $debriefMissionBadgeType;
    /** @var integer 0x00B4 debriefBattleMedalType INT */
    public $debriefBattleMedalType;
    /** @var integer[] 0x00B8 UnknownRecord4 INT */
    public $UnknownRecord4;
    /** @var integer 0x00C8 totalFactionScore INT */
    public $totalFactionScore;
    /** @var PLTCategoryTypeRecord 0x00CC totalCategoryScore PLTCategoryTypeRecord */
    public $totalCategoryScore;
    /** @var PLTCategoryTypeRecord 0x00D8 totalCategoryFlown PLTCategoryTypeRecord */
    public $totalCategoryFlown;
    /** @var integer 0x00E4 totalCampaignExerciseFlown INT */
    public $totalCampaignExerciseFlown;
    /** @var integer 0x00E8 totalTournamentMeleeFlown INT */
    public $totalTournamentMeleeFlown;
    /** @var integer 0x00EC totalBattleCombatFlown INT */
    public $totalBattleCombatFlown;
    /** @var PLTCategoryTypeRecord 0x00F0 totalFullKills PLTCategoryTypeRecord */
    public $totalFullKills;
    /** @var PLTCategoryTypeRecord 0x00FC totalFriendlyFullKills PLTCategoryTypeRecord */
    public $totalFriendlyFullKills;
    /** @var integer[] 0x0108 totalFullKillsByShipExercise INT */
    public $totalFullKillsByShipExercise;
    /** @var integer[] 0x0268 totalFullKillsByShipMelee INT */
    public $totalFullKillsByShipMelee;
    /** @var integer[] 0x03C8 totalFullKillsByShipCombat INT */
    public $totalFullKillsByShipCombat;
    /** @var integer[] 0x0528 totalSharedKillsOfShipExercise INT */
    public $totalSharedKillsOfShipExercise;
    /** @var integer[] 0x0688 totalSharedKillsOfShipMelee INT */
    public $totalSharedKillsOfShipMelee;
    /** @var integer[] 0x07E8 totalSharedKillsOfShipCombat INT */
    public $totalSharedKillsOfShipCombat;
    /** @var integer[] 0x0948 totalAssistKillsOfShipExercise INT */
    public $totalAssistKillsOfShipExercise;
    /** @var integer[] 0x0AA8 totalAssistKillsOfShipMelee INT */
    public $totalAssistKillsOfShipMelee;
    /** @var integer[] 0x0C08 totalAssistKillsOfShipCombat INT */
    public $totalAssistKillsOfShipCombat;
    /** @var PLTPlayerRankCountRecord 0x0D68 totalFullKillsOfPlayerRank PLTPlayerRankCountRecord */
    public $totalFullKillsOfPlayerRank;
    /** @var PLTPlayerRankCountRecord 0x0E94 totalSharedKillsOfPlayerRank PLTPlayerRankCountRecord */
    public $totalSharedKillsOfPlayerRank;
    /** @var PLTPlayerRankCountRecord 0x0FC0 totalAssistKillsOfPlayerRank PLTPlayerRankCountRecord */
    public $totalAssistKillsOfPlayerRank;
    /** @var PLTAIRankCountRecord 0x10EC totalFullKillsOfAIRank PLTAIRankCountRecord */
    public $totalFullKillsOfAIRank;
    /** @var PLTAIRankCountRecord 0x1134 totalSharedKillsOfAIRank PLTAIRankCountRecord */
    public $totalSharedKillsOfAIRank;
    /** @var PLTAIRankCountRecord 0x117C totalAssistKillsOfAIRank PLTAIRankCountRecord */
    public $totalAssistKillsOfAIRank;
    /** @var PLTCategoryTypeRecord 0x11C4 totalHiddenCargoFound PLTCategoryTypeRecord */
    public $totalHiddenCargoFound;
    /** @var PLTCategoryTypeRecord 0x11D0 totalCannonHit PLTCategoryTypeRecord */
    public $totalCannonHit;
    /** @var PLTCategoryTypeRecord 0x11DC totalCannonFired PLTCategoryTypeRecord */
    public $totalCannonFired;
    /** @var PLTCategoryTypeRecord 0x11E8 totalWarheadHit PLTCategoryTypeRecord */
    public $totalWarheadHit;
    /** @var PLTCategoryTypeRecord 0x11F4 totalWarheadFired PLTCategoryTypeRecord */
    public $totalWarheadFired;
    /** @var PLTCategoryTypeRecord 0x1200 totalLosses PLTCategoryTypeRecord */
    public $totalLosses;
    /** @var PLTCategoryTypeRecord 0x120C totalLossesByCollision PLTCategoryTypeRecord */
    public $totalLossesByCollision;
    /** @var PLTCategoryTypeRecord 0x1218 totalLossesByStarship PLTCategoryTypeRecord */
    public $totalLossesByStarship;
    /** @var PLTCategoryTypeRecord 0x1224 totalLossesByMines PLTCategoryTypeRecord */
    public $totalLossesByMines;
    /** @var PLTPlayerRankCountRecord 0x1230 totalLossesByPlayerRank PLTPlayerRankCountRecord */
    public $totalLossesByPlayerRank;
    /** @var PLTAIRankCountRecord 0x135C totalLossesByAIRank PLTAIRankCountRecord */
    public $totalLossesByAIRank;
    /** @var PLTMissionSPRecord[] 0x13A4 missionSPExercise PLTMissionSPRecord */
    public $missionSPExercise;
    /** @var PLTMissionSPRecord[] 0x21B4 missionSPMelee PLTMissionSPRecord */
    public $missionSPMelee;
    /** @var PLTMissionSPRecord[] 0x44DC missionSPCombat PLTMissionSPRecord */
    public $missionSPCombat;
    /** @var PLTMissionMPRecord[] 0x6804 missionMPExercise PLTMissionMPRecord */
    public $missionMPExercise;
    /** @var PLTMissionMPRecord[] 0x7AC4 missionMPMelee PLTMissionMPRecord */
    public $missionMPMelee;
    /** @var PLTMissionMPRecord[] 0xA9A4 missionMPCombat PLTMissionMPRecord */
    public $missionMPCombat;
    /** @var PLTTournSPRecord[] 0xD884 missionSPTourn PLTTournSPRecord */
    public $missionSPTourn;
    /** @var PLTTournMPRecord[] 0xDC6C missionMPTourn PLTTournMPRecord */
    public $missionMPTourn;
    /** @var PLTBattleSPRecord[] 0xE0B8 missionSPBattle PLTBattleSPRecord */
    public $missionSPBattle;
    /** @var PLTBattleMPRecord[] 0xE43C missionMPBattle PLTBattleMPRecord */
    public $missionMPBattle;
    
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
        $this->lastMissionTeam = $this->getInt($hex, 0x0004);
        $this->lastMissionType = $this->getInt($hex, 0x0008);
        $this->lastMissionTrainingSelected = $this->getInt($hex, 0x000C);
        $this->lastMissionMeleeSelected = $this->getInt($hex, 0x0010);
        $this->lastMissionTournamentSelected = $this->getInt($hex, 0x0014);
        $this->lastMissionCombatSelected = $this->getInt($hex, 0x0018);
        $this->lastMissionBattleSelected = $this->getInt($hex, 0x001C);
        $this->unknown0x20 = [];
        $offset = 0x0020;
        for ($i = 0; $i < 10; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->unknown0x20[] = $t;
            $offset += 4;
        }
        $this->earnedMedalCount = (new PLTEarnedMedalRecord(substr($hex, 0x0048), $this->TIE))->loadHex();
        $this->debriefMeleePlaqueType = $this->getInt($hex, 0x00A8);
        $this->debriefTournamentTrophyType = $this->getInt($hex, 0x00AC);
        $this->debriefMissionBadgeType = $this->getInt($hex, 0x00B0);
        $this->debriefBattleMedalType = $this->getInt($hex, 0x00B4);
        $this->UnknownRecord4 = [];
        $offset = 0x00B8;
        for ($i = 0; $i < 4; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->UnknownRecord4[] = $t;
            $offset += 4;
        }
        $this->totalFactionScore = $this->getInt($hex, 0x00C8);
        $this->totalCategoryScore = (new PLTCategoryTypeRecord(substr($hex, 0x00CC), $this->TIE))->loadHex();
        $this->totalCategoryFlown = (new PLTCategoryTypeRecord(substr($hex, 0x00D8), $this->TIE))->loadHex();
        $this->totalCampaignExerciseFlown = $this->getInt($hex, 0x00E4);
        $this->totalTournamentMeleeFlown = $this->getInt($hex, 0x00E8);
        $this->totalBattleCombatFlown = $this->getInt($hex, 0x00EC);
        $this->totalFullKills = (new PLTCategoryTypeRecord(substr($hex, 0x00F0), $this->TIE))->loadHex();
        $this->totalFriendlyFullKills = (new PLTCategoryTypeRecord(substr($hex, 0x00FC), $this->TIE))->loadHex();
        $this->totalFullKillsByShipExercise = [];
        $offset = 0x0108;
        for ($i = 0; $i < 88; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->totalFullKillsByShipExercise[] = $t;
            $offset += 4;
        }
        $this->totalFullKillsByShipMelee = [];
        $offset = 0x0268;
        for ($i = 0; $i < 88; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->totalFullKillsByShipMelee[] = $t;
            $offset += 4;
        }
        $this->totalFullKillsByShipCombat = [];
        $offset = 0x03C8;
        for ($i = 0; $i < 88; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->totalFullKillsByShipCombat[] = $t;
            $offset += 4;
        }
        $this->totalSharedKillsOfShipExercise = [];
        $offset = 0x0528;
        for ($i = 0; $i < 88; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->totalSharedKillsOfShipExercise[] = $t;
            $offset += 4;
        }
        $this->totalSharedKillsOfShipMelee = [];
        $offset = 0x0688;
        for ($i = 0; $i < 88; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->totalSharedKillsOfShipMelee[] = $t;
            $offset += 4;
        }
        $this->totalSharedKillsOfShipCombat = [];
        $offset = 0x07E8;
        for ($i = 0; $i < 88; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->totalSharedKillsOfShipCombat[] = $t;
            $offset += 4;
        }
        $this->totalAssistKillsOfShipExercise = [];
        $offset = 0x0948;
        for ($i = 0; $i < 88; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->totalAssistKillsOfShipExercise[] = $t;
            $offset += 4;
        }
        $this->totalAssistKillsOfShipMelee = [];
        $offset = 0x0AA8;
        for ($i = 0; $i < 88; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->totalAssistKillsOfShipMelee[] = $t;
            $offset += 4;
        }
        $this->totalAssistKillsOfShipCombat = [];
        $offset = 0x0C08;
        for ($i = 0; $i < 88; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->totalAssistKillsOfShipCombat[] = $t;
            $offset += 4;
        }
        $this->totalFullKillsOfPlayerRank = (new PLTPlayerRankCountRecord(substr($hex, 0x0D68), $this->TIE))->loadHex();
        $this->totalSharedKillsOfPlayerRank = (new PLTPlayerRankCountRecord(substr($hex, 0x0E94), $this->TIE))->loadHex();
        $this->totalAssistKillsOfPlayerRank = (new PLTPlayerRankCountRecord(substr($hex, 0x0FC0), $this->TIE))->loadHex();
        $this->totalFullKillsOfAIRank = (new PLTAIRankCountRecord(substr($hex, 0x10EC), $this->TIE))->loadHex();
        $this->totalSharedKillsOfAIRank = (new PLTAIRankCountRecord(substr($hex, 0x1134), $this->TIE))->loadHex();
        $this->totalAssistKillsOfAIRank = (new PLTAIRankCountRecord(substr($hex, 0x117C), $this->TIE))->loadHex();
        $this->totalHiddenCargoFound = (new PLTCategoryTypeRecord(substr($hex, 0x11C4), $this->TIE))->loadHex();
        $this->totalCannonHit = (new PLTCategoryTypeRecord(substr($hex, 0x11D0), $this->TIE))->loadHex();
        $this->totalCannonFired = (new PLTCategoryTypeRecord(substr($hex, 0x11DC), $this->TIE))->loadHex();
        $this->totalWarheadHit = (new PLTCategoryTypeRecord(substr($hex, 0x11E8), $this->TIE))->loadHex();
        $this->totalWarheadFired = (new PLTCategoryTypeRecord(substr($hex, 0x11F4), $this->TIE))->loadHex();
        $this->totalLosses = (new PLTCategoryTypeRecord(substr($hex, 0x1200), $this->TIE))->loadHex();
        $this->totalLossesByCollision = (new PLTCategoryTypeRecord(substr($hex, 0x120C), $this->TIE))->loadHex();
        $this->totalLossesByStarship = (new PLTCategoryTypeRecord(substr($hex, 0x1218), $this->TIE))->loadHex();
        $this->totalLossesByMines = (new PLTCategoryTypeRecord(substr($hex, 0x1224), $this->TIE))->loadHex();
        $this->totalLossesByPlayerRank = (new PLTPlayerRankCountRecord(substr($hex, 0x1230), $this->TIE))->loadHex();
        $this->totalLossesByAIRank = (new PLTAIRankCountRecord(substr($hex, 0x135C), $this->TIE))->loadHex();
        $this->missionSPExercise = [];
        $offset = 0x13A4;
        for ($i = 0; $i < 100; $i++) {
            $t = (new PLTMissionSPRecord(substr($hex, $offset), $this->TIE))->loadHex();
            $this->missionSPExercise[] = $t;
            $offset += $t->getLength();
        }
        $this->missionSPMelee = [];
        $offset = 0x21B4;
        for ($i = 0; $i < 250; $i++) {
            $t = (new PLTMissionSPRecord(substr($hex, $offset), $this->TIE))->loadHex();
            $this->missionSPMelee[] = $t;
            $offset += $t->getLength();
        }
        $this->missionSPCombat = [];
        $offset = 0x44DC;
        for ($i = 0; $i < 250; $i++) {
            $t = (new PLTMissionSPRecord(substr($hex, $offset), $this->TIE))->loadHex();
            $this->missionSPCombat[] = $t;
            $offset += $t->getLength();
        }
        $this->missionMPExercise = [];
        $offset = 0x6804;
        for ($i = 0; $i < 100; $i++) {
            $t = (new PLTMissionMPRecord(substr($hex, $offset), $this->TIE))->loadHex();
            $this->missionMPExercise[] = $t;
            $offset += $t->getLength();
        }
        $this->missionMPMelee = [];
        $offset = 0x7AC4;
        for ($i = 0; $i < 250; $i++) {
            $t = (new PLTMissionMPRecord(substr($hex, $offset), $this->TIE))->loadHex();
            $this->missionMPMelee[] = $t;
            $offset += $t->getLength();
        }
        $this->missionMPCombat = [];
        $offset = 0xA9A4;
        for ($i = 0; $i < 250; $i++) {
            $t = (new PLTMissionMPRecord(substr($hex, $offset), $this->TIE))->loadHex();
            $this->missionMPCombat[] = $t;
            $offset += $t->getLength();
        }
        $this->missionSPTourn = [];
        $offset = 0xD884;
        for ($i = 0; $i < 25; $i++) {
            $t = (new PLTTournSPRecord(substr($hex, $offset), $this->TIE))->loadHex();
            $this->missionSPTourn[] = $t;
            $offset += $t->getLength();
        }
        $this->missionMPTourn = [];
        $offset = 0xDC6C;
        for ($i = 0; $i < 25; $i++) {
            $t = (new PLTTournMPRecord(substr($hex, $offset), $this->TIE))->loadHex();
            $this->missionMPTourn[] = $t;
            $offset += $t->getLength();
        }
        $this->missionSPBattle = [];
        $offset = 0xE0B8;
        for ($i = 0; $i < 25; $i++) {
            $t = (new PLTBattleSPRecord(substr($hex, $offset), $this->TIE))->loadHex();
            $this->missionSPBattle[] = $t;
            $offset += $t->getLength();
        }
        $this->missionMPBattle = [];
        $offset = 0xE43C;
        for ($i = 0; $i < 25; $i++) {
            $t = (new PLTBattleMPRecord(substr($hex, $offset), $this->TIE))->loadHex();
            $this->missionMPBattle[] = $t;
            $offset += $t->getLength();
        }
        

        $this->hex = substr($this->hex, 0, $this->getLength());
        return $this;
    }
    
    public function __debugInfo()
    {
        return [
            "totalMissionsFlown" => $this->totalMissionsFlown,
            "lastMissionTeam" => $this->lastMissionTeam,
            "lastMissionType" => $this->lastMissionType,
            "lastMissionTrainingSelected" => $this->lastMissionTrainingSelected,
            "lastMissionMeleeSelected" => $this->lastMissionMeleeSelected,
            "lastMissionTournamentSelected" => $this->lastMissionTournamentSelected,
            "lastMissionCombatSelected" => $this->lastMissionCombatSelected,
            "lastMissionBattleSelected" => $this->lastMissionBattleSelected,
            "unknown0x20" => $this->unknown0x20,
            "earnedMedalCount" => $this->earnedMedalCount,
            "debriefMeleePlaqueType" => $this->debriefMeleePlaqueType,
            "debriefTournamentTrophyType" => $this->debriefTournamentTrophyType,
            "debriefMissionBadgeType" => $this->debriefMissionBadgeType,
            "debriefBattleMedalType" => $this->debriefBattleMedalType,
            "UnknownRecord4" => $this->UnknownRecord4,
            "totalFactionScore" => $this->totalFactionScore,
            "totalCategoryScore" => $this->totalCategoryScore,
            "totalCategoryFlown" => $this->totalCategoryFlown,
            "totalCampaignExerciseFlown" => $this->totalCampaignExerciseFlown,
            "totalTournamentMeleeFlown" => $this->totalTournamentMeleeFlown,
            "totalBattleCombatFlown" => $this->totalBattleCombatFlown,
            "totalFullKills" => $this->totalFullKills,
            "totalFriendlyFullKills" => $this->totalFriendlyFullKills,
            "totalFullKillsByShipExercise" => $this->totalFullKillsByShipExercise,
            "totalFullKillsByShipMelee" => $this->totalFullKillsByShipMelee,
            "totalFullKillsByShipCombat" => $this->totalFullKillsByShipCombat,
            "totalSharedKillsOfShipExercise" => $this->totalSharedKillsOfShipExercise,
            "totalSharedKillsOfShipMelee" => $this->totalSharedKillsOfShipMelee,
            "totalSharedKillsOfShipCombat" => $this->totalSharedKillsOfShipCombat,
            "totalAssistKillsOfShipExercise" => $this->totalAssistKillsOfShipExercise,
            "totalAssistKillsOfShipMelee" => $this->totalAssistKillsOfShipMelee,
            "totalAssistKillsOfShipCombat" => $this->totalAssistKillsOfShipCombat,
            "totalFullKillsOfPlayerRank" => $this->totalFullKillsOfPlayerRank,
            "totalSharedKillsOfPlayerRank" => $this->totalSharedKillsOfPlayerRank,
            "totalAssistKillsOfPlayerRank" => $this->totalAssistKillsOfPlayerRank,
            "totalFullKillsOfAIRank" => $this->totalFullKillsOfAIRank,
            "totalSharedKillsOfAIRank" => $this->totalSharedKillsOfAIRank,
            "totalAssistKillsOfAIRank" => $this->totalAssistKillsOfAIRank,
            "totalHiddenCargoFound" => $this->totalHiddenCargoFound,
            "totalCannonHit" => $this->totalCannonHit,
            "totalCannonFired" => $this->totalCannonFired,
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
            "missionMPBattle" => $this->missionMPBattle
        ];
    }
    
    public function toHexString($hex = null)
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $hex = $this->writeInt($this->totalMissionsFlown, $hex, 0x0000);
        $hex = $this->writeInt($this->lastMissionTeam, $hex, 0x0004);
        $hex = $this->writeInt($this->lastMissionType, $hex, 0x0008);
        $hex = $this->writeInt($this->lastMissionTrainingSelected, $hex, 0x000C);
        $hex = $this->writeInt($this->lastMissionMeleeSelected, $hex, 0x0010);
        $hex = $this->writeInt($this->lastMissionTournamentSelected, $hex, 0x0014);
        $hex = $this->writeInt($this->lastMissionCombatSelected, $hex, 0x0018);
        $hex = $this->writeInt($this->lastMissionBattleSelected, $hex, 0x001C);
        $offset = 0x0020;
        for ($i = 0; $i < 10; $i++) {
            $t = $this->unknown0x20[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $hex = $this->writeObject($this->earnedMedalCount, $hex, 0x0048);
        $hex = $this->writeInt($this->debriefMeleePlaqueType, $hex, 0x00A8);
        $hex = $this->writeInt($this->debriefTournamentTrophyType, $hex, 0x00AC);
        $hex = $this->writeInt($this->debriefMissionBadgeType, $hex, 0x00B0);
        $hex = $this->writeInt($this->debriefBattleMedalType, $hex, 0x00B4);
        $offset = 0x00B8;
        for ($i = 0; $i < 4; $i++) {
            $t = $this->UnknownRecord4[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $hex = $this->writeInt($this->totalFactionScore, $hex, 0x00C8);
        $hex = $this->writeObject($this->totalCategoryScore, $hex, 0x00CC);
        $hex = $this->writeObject($this->totalCategoryFlown, $hex, 0x00D8);
        $hex = $this->writeInt($this->totalCampaignExerciseFlown, $hex, 0x00E4);
        $hex = $this->writeInt($this->totalTournamentMeleeFlown, $hex, 0x00E8);
        $hex = $this->writeInt($this->totalBattleCombatFlown, $hex, 0x00EC);
        $hex = $this->writeObject($this->totalFullKills, $hex, 0x00F0);
        $hex = $this->writeObject($this->totalFriendlyFullKills, $hex, 0x00FC);
        $offset = 0x0108;
        for ($i = 0; $i < 88; $i++) {
            $t = $this->totalFullKillsByShipExercise[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $offset = 0x0268;
        for ($i = 0; $i < 88; $i++) {
            $t = $this->totalFullKillsByShipMelee[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $offset = 0x03C8;
        for ($i = 0; $i < 88; $i++) {
            $t = $this->totalFullKillsByShipCombat[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $offset = 0x0528;
        for ($i = 0; $i < 88; $i++) {
            $t = $this->totalSharedKillsOfShipExercise[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $offset = 0x0688;
        for ($i = 0; $i < 88; $i++) {
            $t = $this->totalSharedKillsOfShipMelee[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $offset = 0x07E8;
        for ($i = 0; $i < 88; $i++) {
            $t = $this->totalSharedKillsOfShipCombat[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $offset = 0x0948;
        for ($i = 0; $i < 88; $i++) {
            $t = $this->totalAssistKillsOfShipExercise[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $offset = 0x0AA8;
        for ($i = 0; $i < 88; $i++) {
            $t = $this->totalAssistKillsOfShipMelee[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $offset = 0x0C08;
        for ($i = 0; $i < 88; $i++) {
            $t = $this->totalAssistKillsOfShipCombat[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $hex = $this->writeObject($this->totalFullKillsOfPlayerRank, $hex, 0x0D68);
        $hex = $this->writeObject($this->totalSharedKillsOfPlayerRank, $hex, 0x0E94);
        $hex = $this->writeObject($this->totalAssistKillsOfPlayerRank, $hex, 0x0FC0);
        $hex = $this->writeObject($this->totalFullKillsOfAIRank, $hex, 0x10EC);
        $hex = $this->writeObject($this->totalSharedKillsOfAIRank, $hex, 0x1134);
        $hex = $this->writeObject($this->totalAssistKillsOfAIRank, $hex, 0x117C);
        $hex = $this->writeObject($this->totalHiddenCargoFound, $hex, 0x11C4);
        $hex = $this->writeObject($this->totalCannonHit, $hex, 0x11D0);
        $hex = $this->writeObject($this->totalCannonFired, $hex, 0x11DC);
        $hex = $this->writeObject($this->totalWarheadHit, $hex, 0x11E8);
        $hex = $this->writeObject($this->totalWarheadFired, $hex, 0x11F4);
        $hex = $this->writeObject($this->totalLosses, $hex, 0x1200);
        $hex = $this->writeObject($this->totalLossesByCollision, $hex, 0x120C);
        $hex = $this->writeObject($this->totalLossesByStarship, $hex, 0x1218);
        $hex = $this->writeObject($this->totalLossesByMines, $hex, 0x1224);
        $hex = $this->writeObject($this->totalLossesByPlayerRank, $hex, 0x1230);
        $hex = $this->writeObject($this->totalLossesByAIRank, $hex, 0x135C);
        $offset = 0x13A4;
        for ($i = 0; $i < 100; $i++) {
            $t = $this->missionSPExercise[$i];
            $hex = $this->writeObject($t, $hex, $offset);
            $offset += $t->getLength();
        }
        $offset = 0x21B4;
        for ($i = 0; $i < 250; $i++) {
            $t = $this->missionSPMelee[$i];
            $hex = $this->writeObject($t, $hex, $offset);
            $offset += $t->getLength();
        }
        $offset = 0x44DC;
        for ($i = 0; $i < 250; $i++) {
            $t = $this->missionSPCombat[$i];
            $hex = $this->writeObject($t, $hex, $offset);
            $offset += $t->getLength();
        }
        $offset = 0x6804;
        for ($i = 0; $i < 100; $i++) {
            $t = $this->missionMPExercise[$i];
            $hex = $this->writeObject($t, $hex, $offset);
            $offset += $t->getLength();
        }
        $offset = 0x7AC4;
        for ($i = 0; $i < 250; $i++) {
            $t = $this->missionMPMelee[$i];
            $hex = $this->writeObject($t, $hex, $offset);
            $offset += $t->getLength();
        }
        $offset = 0xA9A4;
        for ($i = 0; $i < 250; $i++) {
            $t = $this->missionMPCombat[$i];
            $hex = $this->writeObject($t, $hex, $offset);
            $offset += $t->getLength();
        }
        $offset = 0xD884;
        for ($i = 0; $i < 25; $i++) {
            $t = $this->missionSPTourn[$i];
            $hex = $this->writeObject($t, $hex, $offset);
            $offset += $t->getLength();
        }
        $offset = 0xDC6C;
        for ($i = 0; $i < 25; $i++) {
            $t = $this->missionMPTourn[$i];
            $hex = $this->writeObject($t, $hex, $offset);
            $offset += $t->getLength();
        }
        $offset = 0xE0B8;
        for ($i = 0; $i < 25; $i++) {
            $t = $this->missionSPBattle[$i];
            $hex = $this->writeObject($t, $hex, $offset);
            $offset += $t->getLength();
        }
        $offset = 0xE43C;
        for ($i = 0; $i < 25; $i++) {
            $t = $this->missionMPBattle[$i];
            $hex = $this->writeObject($t, $hex, $offset);
            $offset += $t->getLength();
        }

        return $hex;
    }
    
    
    public function getLength()
    {
        return self::PLTFACTIONRECORDLENGTH;
    }
}