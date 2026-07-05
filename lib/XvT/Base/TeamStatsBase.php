<?php

namespace Pyrite\XvT\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;
use Pyrite\PyriteModel;
use Pyrite\XvT\MissionData;

abstract class TeamStatsBase extends PyriteBase implements Byteable, PyriteModel
{
    use HexDecoder;
    use HexEncoder;

    /** @var int TEAMSTATSLENGTH INT */
	public const TEAMSTATSLENGTH = 21160;
    /** @var array<int> 0x0000 MeleeMedals INT */
	public array $MeleeMedals;
    /** @var array<int> 0x0018 TournamentMedals INT */
	public array $TournamentMedals;
    /** @var array<int> 0x0030 MissionTopRatings INT */
	public array $MissionTopRatings;
    /** @var array<int> 0x0048 MissionMedals INT */
	public array $MissionMedals;
    /** @var array<int> 0x0090 PlayCounts INT */
	public array $PlayCounts;
    /** @var array<int> 0x00A8 totalKills INT */
	public array $totalKills;
    /** @var array<int> 0x00C0 ExerciseKillsByType INT */
	public array $ExerciseKillsByType;
    /** @var array<int> 0x0220 MeleeKillsByType INT */
	public array $MeleeKillsByType;
    /** @var array<int> 0x0380 CombatKillsByType INT */
	public array $CombatKillsByType;
    /** @var array<int> 0x4e0 ExercisePartialsByType INT */
	public array $ExercisePartialsByType;
    /** @var array<int> 0x640 MeleePartialsByType INT */
	public array $MeleePartialsByType;
    /** @var array<int> 0x7a0 CombatPartialsByType INT */
	public array $CombatPartialsByType;
    /** @var array<int> 0x900 ExerciseAssistsByType INT */
	public array $ExerciseAssistsByType;
    /** @var array<int> 0xa60 MeleeAssistsByType INT */
	public array $MeleeAssistsByType;
    /** @var array<int> 0xbc0 CombatAssistsByType INT */
	public array $CombatAssistsByType;
    /** @var array<int> 0x117c HiddenCargoFound INT */
	public array $HiddenCargoFound;
    /** @var array<int> 0x1188 LasersHit INT */
	public array $LasersHit;
    /** @var array<int> 0x1194 LasersTotal INT */
	public array $LasersTotal;
    /** @var array<int> 0x11a0 WarheadsHit INT */
	public array $WarheadsHit;
    /** @var array<int> 0x11ac WarheadsTotal INT */
	public array $WarheadsTotal;
    /** @var array<int> 0x11b8 CraftLosses INT */
	public array $CraftLosses;
    /** @var array<int> 0x11c4 CollisionLosses INT */
	public array $CollisionLosses;
    /** @var array<int> 0x11d0 StarshipLosses INT */
	public array $StarshipLosses;
    /** @var array<int> 0x11dc MineLosses INT */
	public array $MineLosses;
    /** @var array<MissionData> 0x1360 TrainingMissionData MissionData */
	public array $TrainingMissionData;
    /** @var array<MissionData> 0x2170 MeleeMissionData MissionData */
	public array $MeleeMissionData;
    /** @var array<MissionData> 0x4498 CombatMissionData MissionData */
	public array $CombatMissionData;
    
    public function __construct(string $hex = null, ?PyriteModel $TIE = null)
    {
        parent::__construct($hex, $TIE);
    }

    /**
     * Process the $hex string provided in the constructor.
     * Separating the constructor and loading allows for the objects to be made from scratch.
     * @return $this 
     */
    public function loadHex(): static
    {
        $hex = $this->hex;
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
        $this->totalKills = [];
        $offset = 0x00A8;
        for ($i = 0; $i < 3; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->totalKills[] = $t;
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
        for ($i = 0; $i < 100; $i++) {
            $t = (new MissionData(substr($hex, $offset), $this->TIE))->loadHex();
            $this->TrainingMissionData[] = $t;
            $offset += $t->getLength();
        }
        $this->MeleeMissionData = [];
        $offset = 0x2170;
        for ($i = 0; $i < 100; $i++) {
            $t = (new MissionData(substr($hex, $offset), $this->TIE))->loadHex();
            $this->MeleeMissionData[] = $t;
            $offset += $t->getLength();
        }
        $this->CombatMissionData = [];
        $offset = 0x4498;
        for ($i = 0; $i < 100; $i++) {
            $t = (new MissionData(substr($hex, $offset), $this->TIE))->loadHex();
            $this->CombatMissionData[] = $t;
            $offset += $t->getLength();
        }
        

        $this->hex = substr($this->hex, 0, $this->getLength());
        return $this;
    }
    
    public function __debugInfo(): array
    {
        return [
            "MeleeMedals" => $this->MeleeMedals,
            "TournamentMedals" => $this->TournamentMedals,
            "MissionTopRatings" => $this->MissionTopRatings,
            "MissionMedals" => $this->MissionMedals,
            "PlayCounts" => $this->PlayCounts,
            "totalKills" => $this->totalKills,
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
    
    public function toHexString($hex = null): string
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $offset = 0x0000;
        for ($i = 0; $i < 6; $i++) {
            $t = $this->MeleeMedals[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $offset = 0x0018;
        for ($i = 0; $i < 6; $i++) {
            $t = $this->TournamentMedals[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $offset = 0x0030;
        for ($i = 0; $i < 6; $i++) {
            $t = $this->MissionTopRatings[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $offset = 0x0048;
        for ($i = 0; $i < 6; $i++) {
            $t = $this->MissionMedals[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $offset = 0x0090;
        for ($i = 0; $i < 3; $i++) {
            $t = $this->PlayCounts[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $offset = 0x00A8;
        for ($i = 0; $i < 3; $i++) {
            $t = $this->totalKills[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $offset = 0x00C0;
        for ($i = 0; $i < 88; $i++) {
            $t = $this->ExerciseKillsByType[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $offset = 0x0220;
        for ($i = 0; $i < 88; $i++) {
            $t = $this->MeleeKillsByType[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $offset = 0x0380;
        for ($i = 0; $i < 88; $i++) {
            $t = $this->CombatKillsByType[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $offset = 0x4e0;
        for ($i = 0; $i < 88; $i++) {
            $t = $this->ExercisePartialsByType[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $offset = 0x640;
        for ($i = 0; $i < 88; $i++) {
            $t = $this->MeleePartialsByType[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $offset = 0x7a0;
        for ($i = 0; $i < 88; $i++) {
            $t = $this->CombatPartialsByType[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $offset = 0x900;
        for ($i = 0; $i < 88; $i++) {
            $t = $this->ExerciseAssistsByType[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $offset = 0xa60;
        for ($i = 0; $i < 88; $i++) {
            $t = $this->MeleeAssistsByType[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $offset = 0xbc0;
        for ($i = 0; $i < 88; $i++) {
            $t = $this->CombatAssistsByType[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $offset = 0x117c;
        for ($i = 0; $i < 3; $i++) {
            $t = $this->HiddenCargoFound[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $offset = 0x1188;
        for ($i = 0; $i < 3; $i++) {
            $t = $this->LasersHit[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $offset = 0x1194;
        for ($i = 0; $i < 3; $i++) {
            $t = $this->LasersTotal[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $offset = 0x11a0;
        for ($i = 0; $i < 3; $i++) {
            $t = $this->WarheadsHit[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $offset = 0x11ac;
        for ($i = 0; $i < 3; $i++) {
            $t = $this->WarheadsTotal[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $offset = 0x11b8;
        for ($i = 0; $i < 3; $i++) {
            $t = $this->CraftLosses[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $offset = 0x11c4;
        for ($i = 0; $i < 3; $i++) {
            $t = $this->CollisionLosses[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $offset = 0x11d0;
        for ($i = 0; $i < 3; $i++) {
            $t = $this->StarshipLosses[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $offset = 0x11dc;
        for ($i = 0; $i < 3; $i++) {
            $t = $this->MineLosses[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $offset = 0x1360;
        for ($i = 0; $i < 100; $i++) {
            $t = $this->TrainingMissionData[$i];
            $hex = $this->writeObject($t, $hex, $offset);
            $offset += $t->getLength();
        }
        $offset = 0x2170;
        for ($i = 0; $i < 100; $i++) {
            $t = $this->MeleeMissionData[$i];
            $hex = $this->writeObject($t, $hex, $offset);
            $offset += $t->getLength();
        }
        $offset = 0x4498;
        for ($i = 0; $i < 100; $i++) {
            $t = $this->CombatMissionData[$i];
            $hex = $this->writeObject($t, $hex, $offset);
            $offset += $t->getLength();
        }

        return $hex;
    }
    
    
    public function getLength(): int
    {
        return self::TEAMSTATSLENGTH;
    }
}