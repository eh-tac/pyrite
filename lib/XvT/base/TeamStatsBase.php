<?php

namespace Pyrite\XvT\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\PyriteBase;
use Pyrite\XvT\MissionData;

abstract class TeamStatsBase extends PyriteBase implements Byteable
{
    use HexDecoder;

    /** @var integer */
    public $TeamStatsLength;
    /** @var integer[] */
    public $MeleeMedals;
    /** @var integer[] */
    public $TournamentMedals;
    /** @var integer[] */
    public $MissionTopRatings;
    /** @var integer[] */
    public $MissionMedals;
    /** @var integer[] */
    public $PlayCounts;
    /** @var integer[] */
    public $TotalKills;
    /** @var integer[] */
    public $ExerciseKillsByType;
    /** @var integer[] */
    public $MeleeKillsByType;
    /** @var integer[] */
    public $CombatKillsByType;
    /** @var integer[] */
    public $ExercisePartialsByType;
    /** @var integer[] */
    public $MeleePartialsByType;
    /** @var integer[] */
    public $CombatPartialsByType;
    /** @var integer[] */
    public $ExerciseAssistsByType;
    /** @var integer[] */
    public $MeleeAssistsByType;
    /** @var integer[] */
    public $CombatAssistsByType;
    /** @var integer[] */
    public $HiddenCargoFound;
    /** @var integer[] */
    public $LasersHit;
    /** @var integer[] */
    public $LasersTotal;
    /** @var integer[] */
    public $WarheadsHit;
    /** @var integer[] */
    public $WarheadsTotal;
    /** @var integer[] */
    public $CraftLosses;
    /** @var integer[] */
    public $CollisionLosses;
    /** @var integer[] */
    public $StarshipLosses;
    /** @var integer[] */
    public $MineLosses;
    /** @var MissionData[] */
    public $TrainingMissionData;
    /** @var MissionData[] */
    public $MeleeMissionData;
    /** @var MissionData[] */
    public $CombatMissionData;
    
    public function __construct($hex, $tie = null)
    {
        parent::__construct($hex, $tie);
        $this->beforeConstruct();
        $offset = 0;

        $this->MeleeMedals = [];
        $offset = 0x0000;
        for ($i = 0; $i < 6; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->MeleeMedals[] = $t;
            $offset += 4;
        }
        $this->TournamentMedals = [];
        $offset = 0x0018;
        for ($i = 0; $i < 6; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->TournamentMedals[] = $t;
            $offset += 4;
        }
        $this->MissionTopRatings = [];
        $offset = 0x0030;
        for ($i = 0; $i < 6; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->MissionTopRatings[] = $t;
            $offset += 4;
        }
        $this->MissionMedals = [];
        $offset = 0x0048;
        for ($i = 0; $i < 6; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->MissionMedals[] = $t;
            $offset += 4;
        }
        $this->PlayCounts = [];
        $offset = 0x0090;
        for ($i = 0; $i < 3; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->PlayCounts[] = $t;
            $offset += 4;
        }
        $this->TotalKills = [];
        $offset = 0x00A8;
        for ($i = 0; $i < 3; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->TotalKills[] = $t;
            $offset += 4;
        }
        $this->ExerciseKillsByType = [];
        $offset = 0x00C0;
        for ($i = 0; $i < 88; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->ExerciseKillsByType[] = $t;
            $offset += 4;
        }
        $this->MeleeKillsByType = [];
        $offset = 0x0220;
        for ($i = 0; $i < 88; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->MeleeKillsByType[] = $t;
            $offset += 4;
        }
        $this->CombatKillsByType = [];
        $offset = 0x0380;
        for ($i = 0; $i < 88; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->CombatKillsByType[] = $t;
            $offset += 4;
        }
        $this->ExercisePartialsByType = [];
        $offset = 0x4e0;
        for ($i = 0; $i < 88; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->ExercisePartialsByType[] = $t;
            $offset += 4;
        }
        $this->MeleePartialsByType = [];
        $offset = 0x640;
        for ($i = 0; $i < 88; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->MeleePartialsByType[] = $t;
            $offset += 4;
        }
        $this->CombatPartialsByType = [];
        $offset = 0x7a0;
        for ($i = 0; $i < 88; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->CombatPartialsByType[] = $t;
            $offset += 4;
        }
        $this->ExerciseAssistsByType = [];
        $offset = 0x900;
        for ($i = 0; $i < 88; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->ExerciseAssistsByType[] = $t;
            $offset += 4;
        }
        $this->MeleeAssistsByType = [];
        $offset = 0xa60;
        for ($i = 0; $i < 88; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->MeleeAssistsByType[] = $t;
            $offset += 4;
        }
        $this->CombatAssistsByType = [];
        $offset = 0xbc0;
        for ($i = 0; $i < 88; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->CombatAssistsByType[] = $t;
            $offset += 4;
        }
        $this->HiddenCargoFound = [];
        $offset = 0x117c;
        for ($i = 0; $i < 3; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->HiddenCargoFound[] = $t;
            $offset += 4;
        }
        $this->LasersHit = [];
        $offset = 0x1188;
        for ($i = 0; $i < 3; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->LasersHit[] = $t;
            $offset += 4;
        }
        $this->LasersTotal = [];
        $offset = 0x1194;
        for ($i = 0; $i < 3; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->LasersTotal[] = $t;
            $offset += 4;
        }
        $this->WarheadsHit = [];
        $offset = 0x11a0;
        for ($i = 0; $i < 3; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->WarheadsHit[] = $t;
            $offset += 4;
        }
        $this->WarheadsTotal = [];
        $offset = 0x11ac;
        for ($i = 0; $i < 3; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->WarheadsTotal[] = $t;
            $offset += 4;
        }
        $this->CraftLosses = [];
        $offset = 0x11b8;
        for ($i = 0; $i < 3; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->CraftLosses[] = $t;
            $offset += 4;
        }
        $this->CollisionLosses = [];
        $offset = 0x11c4;
        for ($i = 0; $i < 3; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->CollisionLosses[] = $t;
            $offset += 4;
        }
        $this->StarshipLosses = [];
        $offset = 0x11d0;
        for ($i = 0; $i < 3; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->StarshipLosses[] = $t;
            $offset += 4;
        }
        $this->MineLosses = [];
        $offset = 0x11dc;
        for ($i = 0; $i < 3; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->MineLosses[] = $t;
            $offset += 4;
        }
        $this->TrainingMissionData = [];
        $offset = 0x1360;
        for ($i = 0; $i < 40; $i++) {
            $t = new MissionData(substr($hex, $offset), $this->TIE);
            $this->TrainingMissionData[] = $t;
            $offset += $t->getLength();
        }
        $this->MeleeMissionData = [];
        $offset = 0x2170;
        for ($i = 0; $i < 100; $i++) {
            $t = new MissionData(substr($hex, $offset), $this->TIE);
            $this->MeleeMissionData[] = $t;
            $offset += $t->getLength();
        }
        $this->CombatMissionData = [];
        $offset = 0x4498;
        for ($i = 0; $i < 100; $i++) {
            $t = new MissionData(substr($hex, $offset), $this->TIE);
            $this->CombatMissionData[] = $t;
            $offset += $t->getLength();
        }
        $this->TeamStatsLength = $offset;
    }
    
    public function __debugInfo()
    {
        return [
            "MeleeMedals" => $this->MeleeMedals,
            "TournamentMedals" => $this->TournamentMedals,
            "MissionTopRatings" => $this->MissionTopRatings,
            "MissionMedals" => $this->MissionMedals,
            "PlayCounts" => $this->PlayCounts,
            "TotalKills" => $this->TotalKills,
            "ExerciseKillsByType" => $this->ExerciseKillsByType,
            "MeleeKillsByType" => $this->MeleeKillsByType,
            "CombatKillsByType" => $this->CombatKillsByType,
            "ExercisePartialsByType" => $this->ExercisePartialsByType,
            "MeleePartialsByType" => $this->MeleePartialsByType,
            "CombatPartialsByType" => $this->CombatPartialsByType,
            "ExerciseAssistsByType" => $this->ExerciseAssistsByType,
            "MeleeAssistsByType" => $this->MeleeAssistsByType,
            "CombatAssistsByType" => $this->CombatAssistsByType,
            "HiddenCargoFound" => $this->HiddenCargoFound,
            "LasersHit" => $this->LasersHit,
            "LasersTotal" => $this->LasersTotal,
            "WarheadsHit" => $this->WarheadsHit,
            "WarheadsTotal" => $this->WarheadsTotal,
            "CraftLosses" => $this->CraftLosses,
            "CollisionLosses" => $this->CollisionLosses,
            "StarshipLosses" => $this->StarshipLosses,
            "MineLosses" => $this->MineLosses,
            "TrainingMissionData" => $this->TrainingMissionData,
            "MeleeMissionData" => $this->MeleeMissionData,
            "CombatMissionData" => $this->CombatMissionData
        ];
    }
    
    public function toHexString()
    {
        $hex = "";
        $offset = 0;

        $offset = 0x0000;
        for ($i = 0; $i < 6; $i++) {
            $t = $this->MeleeMedals[$i];
            $this->writeInt($hex, $t, $offset);
            $offset += 4;
        }
        $offset = 0x0018;
        for ($i = 0; $i < 6; $i++) {
            $t = $this->TournamentMedals[$i];
            $this->writeInt($hex, $t, $offset);
            $offset += 4;
        }
        $offset = 0x0030;
        for ($i = 0; $i < 6; $i++) {
            $t = $this->MissionTopRatings[$i];
            $this->writeInt($hex, $t, $offset);
            $offset += 4;
        }
        $offset = 0x0048;
        for ($i = 0; $i < 6; $i++) {
            $t = $this->MissionMedals[$i];
            $this->writeInt($hex, $t, $offset);
            $offset += 4;
        }
        $offset = 0x0090;
        for ($i = 0; $i < 3; $i++) {
            $t = $this->PlayCounts[$i];
            $this->writeInt($hex, $t, $offset);
            $offset += 4;
        }
        $offset = 0x00A8;
        for ($i = 0; $i < 3; $i++) {
            $t = $this->TotalKills[$i];
            $this->writeInt($hex, $t, $offset);
            $offset += 4;
        }
        $offset = 0x00C0;
        for ($i = 0; $i < 88; $i++) {
            $t = $this->ExerciseKillsByType[$i];
            $this->writeInt($hex, $t, $offset);
            $offset += 4;
        }
        $offset = 0x0220;
        for ($i = 0; $i < 88; $i++) {
            $t = $this->MeleeKillsByType[$i];
            $this->writeInt($hex, $t, $offset);
            $offset += 4;
        }
        $offset = 0x0380;
        for ($i = 0; $i < 88; $i++) {
            $t = $this->CombatKillsByType[$i];
            $this->writeInt($hex, $t, $offset);
            $offset += 4;
        }
        $offset = 0x4e0;
        for ($i = 0; $i < 88; $i++) {
            $t = $this->ExercisePartialsByType[$i];
            $this->writeInt($hex, $t, $offset);
            $offset += 4;
        }
        $offset = 0x640;
        for ($i = 0; $i < 88; $i++) {
            $t = $this->MeleePartialsByType[$i];
            $this->writeInt($hex, $t, $offset);
            $offset += 4;
        }
        $offset = 0x7a0;
        for ($i = 0; $i < 88; $i++) {
            $t = $this->CombatPartialsByType[$i];
            $this->writeInt($hex, $t, $offset);
            $offset += 4;
        }
        $offset = 0x900;
        for ($i = 0; $i < 88; $i++) {
            $t = $this->ExerciseAssistsByType[$i];
            $this->writeInt($hex, $t, $offset);
            $offset += 4;
        }
        $offset = 0xa60;
        for ($i = 0; $i < 88; $i++) {
            $t = $this->MeleeAssistsByType[$i];
            $this->writeInt($hex, $t, $offset);
            $offset += 4;
        }
        $offset = 0xbc0;
        for ($i = 0; $i < 88; $i++) {
            $t = $this->CombatAssistsByType[$i];
            $this->writeInt($hex, $t, $offset);
            $offset += 4;
        }
        $offset = 0x117c;
        for ($i = 0; $i < 3; $i++) {
            $t = $this->HiddenCargoFound[$i];
            $this->writeInt($hex, $t, $offset);
            $offset += 4;
        }
        $offset = 0x1188;
        for ($i = 0; $i < 3; $i++) {
            $t = $this->LasersHit[$i];
            $this->writeInt($hex, $t, $offset);
            $offset += 4;
        }
        $offset = 0x1194;
        for ($i = 0; $i < 3; $i++) {
            $t = $this->LasersTotal[$i];
            $this->writeInt($hex, $t, $offset);
            $offset += 4;
        }
        $offset = 0x11a0;
        for ($i = 0; $i < 3; $i++) {
            $t = $this->WarheadsHit[$i];
            $this->writeInt($hex, $t, $offset);
            $offset += 4;
        }
        $offset = 0x11ac;
        for ($i = 0; $i < 3; $i++) {
            $t = $this->WarheadsTotal[$i];
            $this->writeInt($hex, $t, $offset);
            $offset += 4;
        }
        $offset = 0x11b8;
        for ($i = 0; $i < 3; $i++) {
            $t = $this->CraftLosses[$i];
            $this->writeInt($hex, $t, $offset);
            $offset += 4;
        }
        $offset = 0x11c4;
        for ($i = 0; $i < 3; $i++) {
            $t = $this->CollisionLosses[$i];
            $this->writeInt($hex, $t, $offset);
            $offset += 4;
        }
        $offset = 0x11d0;
        for ($i = 0; $i < 3; $i++) {
            $t = $this->StarshipLosses[$i];
            $this->writeInt($hex, $t, $offset);
            $offset += 4;
        }
        $offset = 0x11dc;
        for ($i = 0; $i < 3; $i++) {
            $t = $this->MineLosses[$i];
            $this->writeInt($hex, $t, $offset);
            $offset += 4;
        }
        $offset = 0x1360;
        for ($i = 0; $i < 40; $i++) {
            $t = $this->TrainingMissionData[$i];
            $this->writeObject($hex, $t, $offset);
            $offset += $t->getLength();
        }
        $offset = 0x2170;
        for ($i = 0; $i < 100; $i++) {
            $t = $this->MeleeMissionData[$i];
            $this->writeObject($hex, $t, $offset);
            $offset += $t->getLength();
        }
        $offset = 0x4498;
        for ($i = 0; $i < 100; $i++) {
            $t = $this->CombatMissionData[$i];
            $this->writeObject($hex, $t, $offset);
            $offset += $t->getLength();
        }

        return $hex;
    }
    
    
    public function getLength()
    {
        return $this->TeamStatsLength;
    }
}