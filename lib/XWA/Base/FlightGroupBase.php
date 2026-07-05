<?php

namespace Pyrite\XWA\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;
use Pyrite\PyriteModel;
use Pyrite\XWA\Constants;
use Pyrite\XWA\GoalFG;
use Pyrite\XWA\Order;
use Pyrite\XWA\TriggerPair;
use Pyrite\XWA\Waypt;

abstract class FlightGroupBase extends PyriteBase implements Byteable, PyriteModel
{
    use HexDecoder;
    use HexEncoder;

    /** @var int FLIGHTGROUPLENGTH INT */
	public const FLIGHTGROUPLENGTH = 3646;
    /** @var string 0x000 Name STR */
	public string $Name;
    /** @var int 0x014 EnableDesignation BYTE */
	public int $EnableDesignation;
    /** @var int 0x015 EnableDesignation2 BYTE */
	public int $EnableDesignation2;
    /** @var int 0x016 Designation1 BYTE */
	public int $Designation1;
    /** @var int 0x017 Designation2 BYTE */
	public int $Designation2;
    /** @var int 0x018 Comm BYTE */
	public int $Comm; // (was Unknown1) {None, Minimal, Normal, Verbose}
    /** @var int 0x019 GlobalCargoIndex BYTE */
	public int $GlobalCargoIndex;
    /** @var int 0x01A GlobalSpecialCargoIndex BYTE */
	public int $GlobalSpecialCargoIndex;
    /** @var string 0x028 Cargo STR */
	public string $Cargo;
    /** @var string 0x03C SpecialCargo STR */
	public string $SpecialCargo;
    /** @var string 0x050 CraftRole STR */
	public string $CraftRole;
    /** @var int 0x069 SpecialCargoCraft BYTE */
	public int $SpecialCargoCraft;
    /** @var bool 0x06A RandomSpecialCargoCraft BOOL */
	public bool $RandomSpecialCargoCraft;
    /** @var int 0x06B CraftType BYTE */
	public int $CraftType;
    /** @var int 0x06C NumberOfCraft BYTE */
	public int $NumberOfCraft;
    /** @var int 0x06D Status1 BYTE */
	public int $Status1;
    /** @var int 0x06E Warhead BYTE */
	public int $Warhead;
    /** @var int 0x06F Beam BYTE */
	public int $Beam;
    /** @var int 0x070 Iff BYTE */
	public int $Iff;
    /** @var int 0x071 Team BYTE */
	public int $Team;
    /** @var int 0x072 GroupAI BYTE */
	public int $GroupAI;
    /** @var int 0x073 Markings BYTE */
	public int $Markings;
    /** @var int 0x074 Radio BYTE */
	public int $Radio;
    /** @var int 0x076 Formation BYTE */
	public int $Formation;
    /** @var int 0x077 FormationSpacing BYTE */
	public int $FormationSpacing;
    /** @var int 0x078 GlobalGroup BYTE */
	public int $GlobalGroup;
    /** @var int 0x079 LeaderSpacingUnused BYTE */
	public int $LeaderSpacingUnused;
    /** @var int 0x07A NumberOfWaves BYTE */
	public int $NumberOfWaves;
    /** @var int 0x07B WavesDelay BYTE */
	public int $WavesDelay;
    /** @var int 0x07C StopArrivingWhen BYTE */
	public int $StopArrivingWhen;
    /** @var int 0x07D PlayerNumber BYTE */
	public int $PlayerNumber;
    /** @var bool 0x07E ArriveOnlyIfHuman BOOL */
	public bool $ArriveOnlyIfHuman;
    /** @var int 0x07F PlayerCraft BYTE */
	public int $PlayerCraft;
    /** @var int 0x080 Yaw BYTE */
	public int $Yaw;
    /** @var int 0x081 Pitch BYTE */
	public int $Pitch;
    /** @var int 0x082 Roll BYTE */
	public int $Roll;
    /** @var int 0x084 Unknown4 BYTE */
	public int $Unknown4;
    /** @var int 0x086 Unknown5 BYTE */
	public int $Unknown5;
    /** @var int 0x087 ArrivalDifficulty BYTE */
	public int $ArrivalDifficulty;
    /** @var array<TriggerPair> 0x088 Arrival TriggerPair */
	public array $Arrival;
    /** @var bool 0x0A8 Arrivals12OrArrivals34 BOOL */
	public bool $Arrivals12OrArrivals34;
    /** @var int 0x0AA ArrivalDelayMinutes BYTE */
	public int $ArrivalDelayMinutes;
    /** @var int 0x0AB ArrivalDelaySeconds BYTE */
	public int $ArrivalDelaySeconds;
    /** @var TriggerPair 0x0AC Departure TriggerPair */
	public TriggerPair $Departure;
    /** @var int 0x0BC DepartureDelayMinutes BYTE */
	public int $DepartureDelayMinutes;
    /** @var int 0x0BD DepartureDelaySeconds BYTE */
	public int $DepartureDelaySeconds;
    /** @var int 0x0BE AbortTrigger BYTE */
	public int $AbortTrigger;
    /** @var int 0x0BF ArrivalRandDelaySeconds BYTE */
	public int $ArrivalRandDelaySeconds;
    /** @var int 0x0C0 Unknown8 BYTE */
	public int $Unknown8;
    /** @var int 0x0C2 ArrivalMothership BYTE */
	public int $ArrivalMothership;
    /** @var int 0x0C3 ArrivalMethod BYTE */
	public int $ArrivalMethod; // {Hyper, Mothership, Hyp Rgn FG}
    /** @var int 0x0C4 DepartureMothership BYTE */
	public int $DepartureMothership;
    /** @var bool 0x0C5 DepartMethod BOOL */
	public bool $DepartMethod; // {Hyper, Mothership, Planet}
    /** @var int 0x0C6 AlternateMothership BYTE */
	public int $AlternateMothership;
    /** @var bool 0x0C7 AlternateMothershipUsed BOOL */
	public bool $AlternateMothershipUsed;
    /** @var int 0x0C8 CapturedDepartureMothership BYTE */
	public int $CapturedDepartureMothership;
    /** @var bool 0x0C9 CapturedDepartViaMothership BOOL */
	public bool $CapturedDepartViaMothership;
    /** @var array<Order> 0x0CA Orders Order */
	public array $Orders;
    /** @var array<TriggerPair> 0xA0A SkipTriggers TriggerPair */
	public array $SkipTriggers;
    /** @var array<GoalFG> 0xB0A FGGoals GoalFG */
	public array $FGGoals;
    /** @var array<Waypt> 0xD8A StartPoints Waypt */
	public array $StartPoints;
    /** @var Waypt 0xD9A CaptureHyperPoint Waypt */
	public Waypt $CaptureHyperPoint;
    /** @var Waypt 0xDA2 HyperPoint Waypt */
	public Waypt $HyperPoint;
    /** @var array<int> 0xDAA StartPointRegions BYTE */
	public array $StartPointRegions;
    /** @var int 0xDAC CaptureHyperRegion BYTE */
	public int $CaptureHyperRegion;
    /** @var int 0xDAD HyperPointRegion BYTE */
	public int $HyperPointRegion;
    /** @var bool 0xDC4 DisableWaveNumbering BOOL */
	public bool $DisableWaveNumbering;
    /** @var int 0xDC5 DepartureClockMin BYTE */
	public int $DepartureClockMin; // (was Unknown32)
    /** @var int 0xDC6 DepartureClockSec BYTE */
	public int $DepartureClockSec; // (was Unknown33)
    /** @var int 0xDC7 Countermeasures BYTE */
	public int $Countermeasures;
    /** @var int 0xDC8 CraftExplosionTime BYTE */
	public int $CraftExplosionTime;
    /** @var int 0xDC9 Status2 BYTE */
	public int $Status2;
    /** @var int 0xDCA GlobalUnit BYTE */
	public int $GlobalUnit;
    /** @var int 0xDCB Handicap BYTE */
	public int $Handicap; // {None, FavorRebels, EvenOnly, FavorImps, FavorRebsEven, FavorImpsEven}
    /** @var array<int> 0xDCC OptionalWarheads BYTE */
	public array $OptionalWarheads;
    /** @var array<int> 0xDD4 OptionalBeams BYTE */
	public array $OptionalBeams;
    /** @var array<int> 0xDDA OptionalCountermeasures BYTE */
	public array $OptionalCountermeasures;
    /** @var int 0xDDE OptionalCraftCategory BYTE */
	public int $OptionalCraftCategory;
    /** @var array<int> 0xDDF OptionalCraft BYTE */
	public array $OptionalCraft;
    /** @var array<int> 0xDE9 NumberOfOptionalCraft BYTE */
	public array $NumberOfOptionalCraft;
    /** @var array<int> 0xDF3 NumberofOptionalCraftWaves BYTE */
	public array $NumberofOptionalCraftWaves;
    /** @var string 0xDFD PilotID STR */
	public string $PilotID;
    /** @var int 0xE12 Backdrop INT */
	public int $Backdrop;
    
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

        $this->Name = $this->getString($hex, 0x000);
        $this->EnableDesignation = $this->getByte($hex, 0x014);
        $this->EnableDesignation2 = $this->getByte($hex, 0x015);
        $this->Designation1 = $this->getByte($hex, 0x016);
        $this->Designation2 = $this->getByte($hex, 0x017);
        $this->Comm = $this->getByte($hex, 0x018);
        $this->GlobalCargoIndex = $this->getByte($hex, 0x019);
        $this->GlobalSpecialCargoIndex = $this->getByte($hex, 0x01A);
        $this->Cargo = $this->getString($hex, 0x028);
        $this->SpecialCargo = $this->getString($hex, 0x03C);
        $this->CraftRole = $this->getString($hex, 0x050);
        $this->SpecialCargoCraft = $this->getByte($hex, 0x069);
        $this->RandomSpecialCargoCraft = $this->getBool($hex, 0x06A);
        $this->CraftType = $this->getByte($hex, 0x06B);
        $this->NumberOfCraft = $this->getByte($hex, 0x06C);
        $this->Status1 = $this->getByte($hex, 0x06D);
        $this->Warhead = $this->getByte($hex, 0x06E);
        $this->Beam = $this->getByte($hex, 0x06F);
        $this->Iff = $this->getByte($hex, 0x070);
        $this->Team = $this->getByte($hex, 0x071);
        $this->GroupAI = $this->getByte($hex, 0x072);
        $this->Markings = $this->getByte($hex, 0x073);
        $this->Radio = $this->getByte($hex, 0x074);
        $this->Formation = $this->getByte($hex, 0x076);
        $this->FormationSpacing = $this->getByte($hex, 0x077);
        $this->GlobalGroup = $this->getByte($hex, 0x078);
        $this->LeaderSpacingUnused = $this->getByte($hex, 0x079);
        $this->NumberOfWaves = $this->getByte($hex, 0x07A);
        $this->WavesDelay = $this->getByte($hex, 0x07B);
        $this->StopArrivingWhen = $this->getByte($hex, 0x07C);
        $this->PlayerNumber = $this->getByte($hex, 0x07D);
        $this->ArriveOnlyIfHuman = $this->getBool($hex, 0x07E);
        $this->PlayerCraft = $this->getByte($hex, 0x07F);
        $this->Yaw = $this->getByte($hex, 0x080);
        $this->Pitch = $this->getByte($hex, 0x081);
        $this->Roll = $this->getByte($hex, 0x082);
        $this->Unknown4 = $this->getByte($hex, 0x084);
        $this->Unknown5 = $this->getByte($hex, 0x086);
        $this->ArrivalDifficulty = $this->getByte($hex, 0x087);
        $this->Arrival = [];
        $offset = 0x088;
        for ($i = 0; $i < 2; $i++) {
            $t = (new TriggerPair(substr($hex, $offset), $this->TIE))->loadHex();
            $this->Arrival[] = $t;
            $offset += $t->getLength();
        }
        $this->Arrivals12OrArrivals34 = $this->getBool($hex, 0x0A8);
        $this->ArrivalDelayMinutes = $this->getByte($hex, 0x0AA);
        $this->ArrivalDelaySeconds = $this->getByte($hex, 0x0AB);
        $this->Departure = (new TriggerPair(substr($hex, 0x0AC), $this->TIE))->loadHex();
        $this->DepartureDelayMinutes = $this->getByte($hex, 0x0BC);
        $this->DepartureDelaySeconds = $this->getByte($hex, 0x0BD);
        $this->AbortTrigger = $this->getByte($hex, 0x0BE);
        $this->ArrivalRandDelaySeconds = $this->getByte($hex, 0x0BF);
        $this->Unknown8 = $this->getByte($hex, 0x0C0);
        $this->ArrivalMothership = $this->getByte($hex, 0x0C2);
        $this->ArrivalMethod = $this->getByte($hex, 0x0C3);
        $this->DepartureMothership = $this->getByte($hex, 0x0C4);
        $this->DepartMethod = $this->getBool($hex, 0x0C5);
        $this->AlternateMothership = $this->getByte($hex, 0x0C6);
        $this->AlternateMothershipUsed = $this->getBool($hex, 0x0C7);
        $this->CapturedDepartureMothership = $this->getByte($hex, 0x0C8);
        $this->CapturedDepartViaMothership = $this->getBool($hex, 0x0C9);
        $this->Orders = [];
        $offset = 0x0CA;
        for ($i = 0; $i < 16; $i++) {
            $t = (new Order(substr($hex, $offset), $this->TIE))->loadHex();
            $this->Orders[] = $t;
            $offset += $t->getLength();
        }
        $this->SkipTriggers = [];
        $offset = 0xA0A;
        for ($i = 0; $i < 16; $i++) {
            $t = (new TriggerPair(substr($hex, $offset), $this->TIE))->loadHex();
            $this->SkipTriggers[] = $t;
            $offset += $t->getLength();
        }
        $this->FGGoals = [];
        $offset = 0xB0A;
        for ($i = 0; $i < 8; $i++) {
            $t = (new GoalFG(substr($hex, $offset), $this->TIE))->loadHex();
            $this->FGGoals[] = $t;
            $offset += $t->getLength();
        }
        $this->StartPoints = [];
        $offset = 0xD8A;
        for ($i = 0; $i < 2; $i++) {
            $t = (new Waypt(substr($hex, $offset), $this->TIE))->loadHex();
            $this->StartPoints[] = $t;
            $offset += $t->getLength();
        }
        $this->CaptureHyperPoint = (new Waypt(substr($hex, 0xD9A), $this->TIE))->loadHex();
        $this->HyperPoint = (new Waypt(substr($hex, 0xDA2), $this->TIE))->loadHex();
        $this->StartPointRegions = [];
        $offset = 0xDAA;
        for ($i = 0; $i < 2; $i++) {
            $t = $this->getByte($hex, $offset);
            $this->StartPointRegions[] = $t;
            $offset += 1;
        }
        $this->CaptureHyperRegion = $this->getByte($hex, 0xDAC);
        $this->HyperPointRegion = $this->getByte($hex, 0xDAD);
        $this->DisableWaveNumbering = $this->getBool($hex, 0xDC4);
        $this->DepartureClockMin = $this->getByte($hex, 0xDC5);
        $this->DepartureClockSec = $this->getByte($hex, 0xDC6);
        $this->Countermeasures = $this->getByte($hex, 0xDC7);
        $this->CraftExplosionTime = $this->getByte($hex, 0xDC8);
        $this->Status2 = $this->getByte($hex, 0xDC9);
        $this->GlobalUnit = $this->getByte($hex, 0xDCA);
        $this->Handicap = $this->getByte($hex, 0xDCB);
        $this->OptionalWarheads = [];
        $offset = 0xDCC;
        for ($i = 0; $i < 8; $i++) {
            $t = $this->getByte($hex, $offset);
            $this->OptionalWarheads[] = $t;
            $offset += 1;
        }
        $this->OptionalBeams = [];
        $offset = 0xDD4;
        for ($i = 0; $i < 4; $i++) {
            $t = $this->getByte($hex, $offset);
            $this->OptionalBeams[] = $t;
            $offset += 1;
        }
        $this->OptionalCountermeasures = [];
        $offset = 0xDDA;
        for ($i = 0; $i < 3; $i++) {
            $t = $this->getByte($hex, $offset);
            $this->OptionalCountermeasures[] = $t;
            $offset += 1;
        }
        $this->OptionalCraftCategory = $this->getByte($hex, 0xDDE);
        $this->OptionalCraft = [];
        $offset = 0xDDF;
        for ($i = 0; $i < 10; $i++) {
            $t = $this->getByte($hex, $offset);
            $this->OptionalCraft[] = $t;
            $offset += 1;
        }
        $this->NumberOfOptionalCraft = [];
        $offset = 0xDE9;
        for ($i = 0; $i < 10; $i++) {
            $t = $this->getByte($hex, $offset);
            $this->NumberOfOptionalCraft[] = $t;
            $offset += 1;
        }
        $this->NumberofOptionalCraftWaves = [];
        $offset = 0xDF3;
        for ($i = 0; $i < 10; $i++) {
            $t = $this->getByte($hex, $offset);
            $this->NumberofOptionalCraftWaves[] = $t;
            $offset += 1;
        }
        $this->PilotID = $this->getString($hex, 0xDFD);
        $this->Backdrop = $this->getInt($hex, 0xE12);
        

        $this->hex = substr($this->hex, 0, $this->getLength());
        return $this;
    }
    
    public function __debugInfo(): array
    {
        return [
            "Name" => $this->Name,
            "EnableDesignation" => $this->EnableDesignation,
            "EnableDesignation2" => $this->EnableDesignation2,
            "Designation1" => $this->getDesignation1Label(),
            "Designation2" => $this->getDesignation2Label(),
            "Comm" => $this->Comm,
            "GlobalCargoIndex" => $this->GlobalCargoIndex,
            "GlobalSpecialCargoIndex" => $this->GlobalSpecialCargoIndex,
            "Cargo" => $this->Cargo,
            "SpecialCargo" => $this->SpecialCargo,
            "CraftRole" => $this->CraftRole,
            "SpecialCargoCraft" => $this->SpecialCargoCraft,
            "RandomSpecialCargoCraft" => $this->RandomSpecialCargoCraft,
            "CraftType" => $this->getCraftTypeLabel(),
            "NumberOfCraft" => $this->NumberOfCraft,
            "Status1" => $this->getStatus1Label(),
            "Warhead" => $this->getWarheadLabel(),
            "Beam" => $this->getBeamLabel(),
            "Iff" => $this->Iff,
            "Team" => $this->Team,
            "GroupAI" => $this->getGroupAILabel(),
            "Markings" => $this->getMarkingsLabel(),
            "Radio" => $this->getRadioLabel(),
            "Formation" => $this->getFormationLabel(),
            "FormationSpacing" => $this->getFormationSpacingLabel(),
            "GlobalGroup" => $this->GlobalGroup,
            "LeaderSpacingUnused" => $this->LeaderSpacingUnused,
            "NumberOfWaves" => $this->NumberOfWaves,
            "WavesDelay" => $this->WavesDelay,
            "StopArrivingWhen" => $this->getStopArrivingWhenLabel(),
            "PlayerNumber" => $this->PlayerNumber,
            "ArriveOnlyIfHuman" => $this->ArriveOnlyIfHuman,
            "PlayerCraft" => $this->PlayerCraft,
            "Yaw" => $this->Yaw,
            "Pitch" => $this->Pitch,
            "Roll" => $this->Roll,
            "Unknown4" => $this->Unknown4,
            "Unknown5" => $this->Unknown5,
            "ArrivalDifficulty" => $this->getArrivalDifficultyLabel(),
            "Arrival" => $this->Arrival,
            "Arrivals12OrArrivals34" => $this->Arrivals12OrArrivals34,
            "ArrivalDelayMinutes" => $this->ArrivalDelayMinutes,
            "ArrivalDelaySeconds" => $this->ArrivalDelaySeconds,
            "Departure" => $this->Departure,
            "DepartureDelayMinutes" => $this->DepartureDelayMinutes,
            "DepartureDelaySeconds" => $this->DepartureDelaySeconds,
            "AbortTrigger" => $this->getAbortTriggerLabel(),
            "ArrivalRandDelaySeconds" => $this->ArrivalRandDelaySeconds,
            "Unknown8" => $this->Unknown8,
            "ArrivalMothership" => $this->ArrivalMothership,
            "ArrivalMethod" => $this->ArrivalMethod,
            "DepartureMothership" => $this->DepartureMothership,
            "DepartMethod" => $this->DepartMethod,
            "AlternateMothership" => $this->AlternateMothership,
            "AlternateMothershipUsed" => $this->AlternateMothershipUsed,
            "CapturedDepartureMothership" => $this->CapturedDepartureMothership,
            "CapturedDepartViaMothership" => $this->CapturedDepartViaMothership,
            "Orders" => $this->Orders,
            "SkipTriggers" => $this->SkipTriggers,
            "FGGoals" => $this->FGGoals,
            "StartPoints" => $this->StartPoints,
            "CaptureHyperPoint" => $this->CaptureHyperPoint,
            "HyperPoint" => $this->HyperPoint,
            "StartPointRegions" => $this->StartPointRegions,
            "CaptureHyperRegion" => $this->CaptureHyperRegion,
            "HyperPointRegion" => $this->HyperPointRegion,
            "DisableWaveNumbering" => $this->DisableWaveNumbering,
            "DepartureClockMin" => $this->DepartureClockMin,
            "DepartureClockSec" => $this->DepartureClockSec,
            "Countermeasures" => $this->Countermeasures,
            "CraftExplosionTime" => $this->CraftExplosionTime,
            "Status2" => $this->Status2,
            "GlobalUnit" => $this->GlobalUnit,
            "Handicap" => $this->Handicap,
            "OptionalWarheads" => $this->OptionalWarheads,
            "OptionalBeams" => $this->OptionalBeams,
            "OptionalCountermeasures" => $this->OptionalCountermeasures,
            "OptionalCraftCategory" => $this->OptionalCraftCategory,
            "OptionalCraft" => $this->OptionalCraft,
            "NumberOfOptionalCraft" => $this->NumberOfOptionalCraft,
            "NumberofOptionalCraftWaves" => $this->NumberofOptionalCraftWaves,
            "PilotID" => $this->PilotID,
            "Backdrop" => $this->Backdrop
        ];
    }
    
    public function toHexString($hex = null): string
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $hex = $this->writeString($this->Name, $hex, 0x000);
        $hex = $this->writeByte($this->EnableDesignation, $hex, 0x014);
        $hex = $this->writeByte($this->EnableDesignation2, $hex, 0x015);
        $hex = $this->writeByte($this->Designation1, $hex, 0x016);
        $hex = $this->writeByte($this->Designation2, $hex, 0x017);
        $hex = $this->writeByte($this->Comm, $hex, 0x018);
        $hex = $this->writeByte($this->GlobalCargoIndex, $hex, 0x019);
        $hex = $this->writeByte($this->GlobalSpecialCargoIndex, $hex, 0x01A);
        $hex = $this->writeString($this->Cargo, $hex, 0x028);
        $hex = $this->writeString($this->SpecialCargo, $hex, 0x03C);
        $hex = $this->writeString($this->CraftRole, $hex, 0x050);
        $hex = $this->writeByte($this->SpecialCargoCraft, $hex, 0x069);
        $hex = $this->writeBool($this->RandomSpecialCargoCraft, $hex, 0x06A);
        $hex = $this->writeByte($this->CraftType, $hex, 0x06B);
        $hex = $this->writeByte($this->NumberOfCraft, $hex, 0x06C);
        $hex = $this->writeByte($this->Status1, $hex, 0x06D);
        $hex = $this->writeByte($this->Warhead, $hex, 0x06E);
        $hex = $this->writeByte($this->Beam, $hex, 0x06F);
        $hex = $this->writeByte($this->Iff, $hex, 0x070);
        $hex = $this->writeByte($this->Team, $hex, 0x071);
        $hex = $this->writeByte($this->GroupAI, $hex, 0x072);
        $hex = $this->writeByte($this->Markings, $hex, 0x073);
        $hex = $this->writeByte($this->Radio, $hex, 0x074);
        $hex = $this->writeByte($this->Formation, $hex, 0x076);
        $hex = $this->writeByte($this->FormationSpacing, $hex, 0x077);
        $hex = $this->writeByte($this->GlobalGroup, $hex, 0x078);
        $hex = $this->writeByte($this->LeaderSpacingUnused, $hex, 0x079);
        $hex = $this->writeByte($this->NumberOfWaves, $hex, 0x07A);
        $hex = $this->writeByte($this->WavesDelay, $hex, 0x07B);
        $hex = $this->writeByte($this->StopArrivingWhen, $hex, 0x07C);
        $hex = $this->writeByte($this->PlayerNumber, $hex, 0x07D);
        $hex = $this->writeBool($this->ArriveOnlyIfHuman, $hex, 0x07E);
        $hex = $this->writeByte($this->PlayerCraft, $hex, 0x07F);
        $hex = $this->writeByte($this->Yaw, $hex, 0x080);
        $hex = $this->writeByte($this->Pitch, $hex, 0x081);
        $hex = $this->writeByte($this->Roll, $hex, 0x082);
        $hex = $this->writeByte($this->Unknown4, $hex, 0x084);
        $hex = $this->writeByte($this->Unknown5, $hex, 0x086);
        $hex = $this->writeByte($this->ArrivalDifficulty, $hex, 0x087);
        $offset = 0x088;
        for ($i = 0; $i < 2; $i++) {
            $t = $this->Arrival[$i];
            $hex = $this->writeObject($t, $hex, $offset);
            $offset += $t->getLength();
        }
        $hex = $this->writeBool($this->Arrivals12OrArrivals34, $hex, 0x0A8);
        $hex = $this->writeByte($this->ArrivalDelayMinutes, $hex, 0x0AA);
        $hex = $this->writeByte($this->ArrivalDelaySeconds, $hex, 0x0AB);
        $hex = $this->writeObject($this->Departure, $hex, 0x0AC);
        $hex = $this->writeByte($this->DepartureDelayMinutes, $hex, 0x0BC);
        $hex = $this->writeByte($this->DepartureDelaySeconds, $hex, 0x0BD);
        $hex = $this->writeByte($this->AbortTrigger, $hex, 0x0BE);
        $hex = $this->writeByte($this->ArrivalRandDelaySeconds, $hex, 0x0BF);
        $hex = $this->writeByte($this->Unknown8, $hex, 0x0C0);
        $hex = $this->writeByte($this->ArrivalMothership, $hex, 0x0C2);
        $hex = $this->writeByte($this->ArrivalMethod, $hex, 0x0C3);
        $hex = $this->writeByte($this->DepartureMothership, $hex, 0x0C4);
        $hex = $this->writeBool($this->DepartMethod, $hex, 0x0C5);
        $hex = $this->writeByte($this->AlternateMothership, $hex, 0x0C6);
        $hex = $this->writeBool($this->AlternateMothershipUsed, $hex, 0x0C7);
        $hex = $this->writeByte($this->CapturedDepartureMothership, $hex, 0x0C8);
        $hex = $this->writeBool($this->CapturedDepartViaMothership, $hex, 0x0C9);
        $offset = 0x0CA;
        for ($i = 0; $i < 16; $i++) {
            $t = $this->Orders[$i];
            $hex = $this->writeObject($t, $hex, $offset);
            $offset += $t->getLength();
        }
        $offset = 0xA0A;
        for ($i = 0; $i < 16; $i++) {
            $t = $this->SkipTriggers[$i];
            $hex = $this->writeObject($t, $hex, $offset);
            $offset += $t->getLength();
        }
        $offset = 0xB0A;
        for ($i = 0; $i < 8; $i++) {
            $t = $this->FGGoals[$i];
            $hex = $this->writeObject($t, $hex, $offset);
            $offset += $t->getLength();
        }
        $offset = 0xD8A;
        for ($i = 0; $i < 2; $i++) {
            $t = $this->StartPoints[$i];
            $hex = $this->writeObject($t, $hex, $offset);
            $offset += $t->getLength();
        }
        $hex = $this->writeObject($this->CaptureHyperPoint, $hex, 0xD9A);
        $hex = $this->writeObject($this->HyperPoint, $hex, 0xDA2);
        $offset = 0xDAA;
        for ($i = 0; $i < 2; $i++) {
            $t = $this->StartPointRegions[$i];
            $hex = $this->writeByte($t, $hex, $offset);
            $offset += 1;
        }
        $hex = $this->writeByte($this->CaptureHyperRegion, $hex, 0xDAC);
        $hex = $this->writeByte($this->HyperPointRegion, $hex, 0xDAD);
        $hex = $this->writeBool($this->DisableWaveNumbering, $hex, 0xDC4);
        $hex = $this->writeByte($this->DepartureClockMin, $hex, 0xDC5);
        $hex = $this->writeByte($this->DepartureClockSec, $hex, 0xDC6);
        $hex = $this->writeByte($this->Countermeasures, $hex, 0xDC7);
        $hex = $this->writeByte($this->CraftExplosionTime, $hex, 0xDC8);
        $hex = $this->writeByte($this->Status2, $hex, 0xDC9);
        $hex = $this->writeByte($this->GlobalUnit, $hex, 0xDCA);
        $hex = $this->writeByte($this->Handicap, $hex, 0xDCB);
        $offset = 0xDCC;
        for ($i = 0; $i < 8; $i++) {
            $t = $this->OptionalWarheads[$i];
            $hex = $this->writeByte($t, $hex, $offset);
            $offset += 1;
        }
        $offset = 0xDD4;
        for ($i = 0; $i < 4; $i++) {
            $t = $this->OptionalBeams[$i];
            $hex = $this->writeByte($t, $hex, $offset);
            $offset += 1;
        }
        $offset = 0xDDA;
        for ($i = 0; $i < 3; $i++) {
            $t = $this->OptionalCountermeasures[$i];
            $hex = $this->writeByte($t, $hex, $offset);
            $offset += 1;
        }
        $hex = $this->writeByte($this->OptionalCraftCategory, $hex, 0xDDE);
        $offset = 0xDDF;
        for ($i = 0; $i < 10; $i++) {
            $t = $this->OptionalCraft[$i];
            $hex = $this->writeByte($t, $hex, $offset);
            $offset += 1;
        }
        $offset = 0xDE9;
        for ($i = 0; $i < 10; $i++) {
            $t = $this->NumberOfOptionalCraft[$i];
            $hex = $this->writeByte($t, $hex, $offset);
            $offset += 1;
        }
        $offset = 0xDF3;
        for ($i = 0; $i < 10; $i++) {
            $t = $this->NumberofOptionalCraftWaves[$i];
            $hex = $this->writeByte($t, $hex, $offset);
            $offset += 1;
        }
        $hex = $this->writeString($this->PilotID, $hex, 0xDFD);
        $hex = $this->writeInt($this->Backdrop, $hex, 0xE12);

        return $hex;
    }
    
    public function getDesignation1Label(): string 
    {
        return isset($this->Designation1) && isset(Constants::$DESIGNATION[$this->Designation1]) ? Constants::$DESIGNATION[$this->Designation1] : "Unknown";
    }

    public function getDesignation2Label(): string 
    {
        return isset($this->Designation2) && isset(Constants::$DESIGNATION[$this->Designation2]) ? Constants::$DESIGNATION[$this->Designation2] : "Unknown";
    }

    public function getCraftTypeLabel(): string 
    {
        return isset($this->CraftType) && isset(Constants::$CRAFTTYPE[$this->CraftType]) ? Constants::$CRAFTTYPE[$this->CraftType] : "Unknown";
    }

    public function getStatus1Label(): string 
    {
        return isset($this->Status1) && isset(Constants::$STATUS[$this->Status1]) ? Constants::$STATUS[$this->Status1] : "Unknown";
    }

    public function getWarheadLabel(): string 
    {
        return isset($this->Warhead) && isset(Constants::$WARHEAD[$this->Warhead]) ? Constants::$WARHEAD[$this->Warhead] : "Unknown";
    }

    public function getBeamLabel(): string 
    {
        return isset($this->Beam) && isset(Constants::$BEAM[$this->Beam]) ? Constants::$BEAM[$this->Beam] : "Unknown";
    }

    public function getGroupAILabel(): string 
    {
        return isset($this->GroupAI) && isset(Constants::$GROUPAI[$this->GroupAI]) ? Constants::$GROUPAI[$this->GroupAI] : "Unknown";
    }

    public function getMarkingsLabel(): string 
    {
        return isset($this->Markings) && isset(Constants::$MARKINGS[$this->Markings]) ? Constants::$MARKINGS[$this->Markings] : "Unknown";
    }

    public function getRadioLabel(): string 
    {
        return isset($this->Radio) && isset(Constants::$RADIO[$this->Radio]) ? Constants::$RADIO[$this->Radio] : "Unknown";
    }

    public function getFormationLabel(): string 
    {
        return isset($this->Formation) && isset(Constants::$FORMATION[$this->Formation]) ? Constants::$FORMATION[$this->Formation] : "Unknown";
    }

    public function getFormationSpacingLabel(): string 
    {
        return isset($this->FormationSpacing) && isset(Constants::$FORMATIONSPACING[$this->FormationSpacing]) ? Constants::$FORMATIONSPACING[$this->FormationSpacing] : "Unknown";
    }

    public function getStopArrivingWhenLabel(): string 
    {
        return isset($this->StopArrivingWhen) && isset(Constants::$STOPARRIVINGWHEN[$this->StopArrivingWhen]) ? Constants::$STOPARRIVINGWHEN[$this->StopArrivingWhen] : "Unknown";
    }

    public function getArrivalDifficultyLabel(): string 
    {
        return isset($this->ArrivalDifficulty) && isset(Constants::$ARRIVALDIFFICULTY[$this->ArrivalDifficulty]) ? Constants::$ARRIVALDIFFICULTY[$this->ArrivalDifficulty] : "Unknown";
    }

    public function getAbortTriggerLabel(): string 
    {
        return isset($this->AbortTrigger) && isset(Constants::$ABORTTRIGGER[$this->AbortTrigger]) ? Constants::$ABORTTRIGGER[$this->AbortTrigger] : "Unknown";
    }
    
    public function getLength(): int
    {
        return self::FLIGHTGROUPLENGTH;
    }
}