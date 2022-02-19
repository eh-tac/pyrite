<?php

namespace Pyrite\XWA\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\PyriteBase;
use Pyrite\XWA\Constants;
use Pyrite\XWA\GoalFG;
use Pyrite\XWA\Trigger;
use Pyrite\XWA\Waypt;

abstract class FlightGroupBase extends PyriteBase implements Byteable
{
    use HexDecoder;

    /** @var integer */
    public const FLIGHTGROUPLENGTH = 3646;
    /** @var string */
    public $Name;
    /** @var integer */
    public $EnableDesignation;
    /** @var integer */
    public $EnableDesignation2;
    /** @var integer */
    public $Designation1;
    /** @var integer */
    public $Designation2;
    /** @var integer */
    public $Unknown1;
    /** @var integer */
    public $GlobalCargoIndex;
    /** @var integer */
    public $GlobalSpecialCargoIndex;
    /** @var string */
    public $Cargo;
    /** @var string */
    public $SpecialCargo;
    /** @var string */
    public $CraftRole;
    /** @var integer */
    public $SpecialCargoCraft;
    /** @var boolean */
    public $RandomSpecialCargoCraft;
    /** @var integer */
    public $CraftType;
    /** @var integer */
    public $NumberOfCraft;
    /** @var integer */
    public $Status1;
    /** @var integer */
    public $Warhead;
    /** @var integer */
    public $Beam;
    /** @var integer */
    public $Iff;
    /** @var integer */
    public $Team;
    /** @var integer */
    public $GroupAI;
    /** @var integer */
    public $Markings;
    /** @var integer */
    public $Radio;
    /** @var integer */
    public $Formation;
    /** @var integer */
    public $FormationSpacing;
    /** @var integer */
    public $GlobalGroup;
    /** @var integer */
    public $LeaderSpacing;
    /** @var integer */
    public $NumberOfWaves;
    /** @var integer */
    public $Unknown3;
    /** @var integer */
    public $PlayerNumber;
    /** @var boolean */
    public $ArriveOnlyIfHuman;
    /** @var integer */
    public $PlayerCraft;
    /** @var integer */
    public $Yaw;
    /** @var integer */
    public $Pitch;
    /** @var integer */
    public $Roll;
    /** @var integer */
    public $Unknown4;
    /** @var integer */
    public $Unknown5;
    /** @var integer */
    public $ArrivalDifficulty;
    /** @var Trigger */
    public $Arrival1;
    /** @var Trigger */
    public $Arrival2;
    /** @var boolean */
    public $Arrival1OrArrival2;
    /** @var boolean */
    public $Unknown6;
    /** @var Trigger */
    public $Arrival3;
    /** @var Trigger */
    public $Arrival4;
    /** @var boolean */
    public $Arrival3OrArrival4;
    /** @var boolean */
    public $Arrivals12OrArrivals34;
    /** @var integer */
    public $ArrivalDelayMinutes;
    /** @var integer */
    public $ArrivalDelaySeconds;
    /** @var Trigger */
    public $Departure1;
    /** @var Trigger */
    public $Departure2;
    /** @var boolean */
    public $Departure1OrDeparture2;
    /** @var integer */
    public $DepartureDelayMinutes;
    /** @var integer */
    public $DepartureDelaySeconds;
    /** @var integer */
    public $AbortTrigger;
    /** @var integer */
    public $Unknown7;
    /** @var integer */
    public $Unknown8;
    /** @var integer */
    public $ArrivalMothership;
    /** @var boolean */
    public $ArriveViaMothership;
    /** @var integer */
    public $DepartureMothership;
    /** @var boolean */
    public $DepartViaMothership;
    /** @var integer */
    public $AlternateArrivalMothership;
    /** @var boolean */
    public $AlternateArriveViaMothership;
    /** @var integer */
    public $AlternateDepartureMothership;
    /** @var boolean */
    public $AlternateDepartViaMothership;
    /** @var GoalFG[] */
    public $Unnamed;
    /** @var Waypt[] */
    public $StartPoints;
    /** @var Waypt */
    public $HyperPoint;
    /** @var integer[] */
    public $StartPointRegions;
    /** @var integer */
    public $HyperPointRegion;
    /** @var integer */
    public $Unknown16;
    /** @var integer */
    public $Unknown17;
    /** @var integer */
    public $Unknown18;
    /** @var integer */
    public $Unknown19;
    /** @var integer */
    public $Unknown20;
    /** @var integer */
    public $Unknown21;
    /** @var boolean */
    public $Unknown22;
    /** @var integer */
    public $Unknown23;
    /** @var integer */
    public $Unknown24;
    /** @var integer */
    public $Unknown25;
    /** @var integer */
    public $Unknown26;
    /** @var integer */
    public $Unknown27;
    /** @var integer */
    public $Unknown28;
    /** @var boolean */
    public $Unknown29;
    /** @var boolean */
    public $Unknown30;
    /** @var boolean */
    public $Unknown31;
    /** @var boolean */
    public $EnableGlobalUnit;
    /** @var integer */
    public $Unknown32;
    /** @var integer */
    public $Unknown33;
    /** @var integer */
    public $Countermeasures;
    /** @var integer */
    public $CraftExplosionTime;
    /** @var integer */
    public $Status2;
    /** @var integer */
    public $GlobalUnit;
    /** @var integer[] */
    public $OptionalWarheads;
    /** @var integer[] */
    public $OptionalBeams;
    /** @var integer[] */
    public $OptionalCountermeasures;
    /** @var integer */
    public $OptionalCraftCategory;
    /** @var integer[] */
    public $OptionalCraft;
    /** @var integer[] */
    public $NumberOfOptionalCraft;
    /** @var integer[] */
    public $NumberofOptionalCraftWaves;
    /** @var string */
    public $PilotID;
    /** @var integer */
    public $Backdrop;
    /** @var boolean */
    public $Unknown34;
    /** @var boolean */
    public $Unknown35;
    /** @var boolean */
    public $Unknown36;
    /** @var boolean */
    public $Unknown37;
    /** @var boolean */
    public $Unknown38;
    /** @var boolean */
    public $Unknown39;
    /** @var boolean */
    public $Unknown40;
    /** @var boolean */
    public $Unknown41;
    
    public function __construct($hex, $tie = null)
    {
        parent::__construct($hex, $tie);
        $this->beforeConstruct();
        $offset = 0;

        $this->Name = $this->getString($hex, 0x000);
        $this->EnableDesignation = $this->getByte($hex, 0x014);
        $this->EnableDesignation2 = $this->getByte($hex, 0x015);
        $this->Designation1 = $this->getByte($hex, 0x016);
        $this->Designation2 = $this->getByte($hex, 0x017);
        $this->Unknown1 = $this->getByte($hex, 0x018);
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
        $this->LeaderSpacing = $this->getByte($hex, 0x079);
        $this->NumberOfWaves = $this->getByte($hex, 0x07A);
        $this->Unknown3 = $this->getByte($hex, 0x07B);
        $this->PlayerNumber = $this->getByte($hex, 0x07D);
        $this->ArriveOnlyIfHuman = $this->getBool($hex, 0x07E);
        $this->PlayerCraft = $this->getByte($hex, 0x07F);
        $this->Yaw = $this->getByte($hex, 0x080);
        $this->Pitch = $this->getByte($hex, 0x081);
        $this->Roll = $this->getByte($hex, 0x082);
        $this->Unknown4 = $this->getByte($hex, 0x084);
        $this->Unknown5 = $this->getByte($hex, 0x086);
        $this->ArrivalDifficulty = $this->getByte($hex, 0x087);
        $this->Arrival1 = new Trigger(substr($hex, 0x088), $this->TIE);
        $this->Arrival2 = new Trigger(substr($hex, 0x08E), $this->TIE);
        $this->Arrival1OrArrival2 = $this->getBool($hex, 0x096);
        $this->Unknown6 = $this->getBool($hex, 0x097);
        $this->Arrival3 = new Trigger(substr($hex, 0x098), $this->TIE);
        $this->Arrival4 = new Trigger(substr($hex, 0x09E), $this->TIE);
        $this->Arrival3OrArrival4 = $this->getBool($hex, 0x0A6);
        $this->Arrivals12OrArrivals34 = $this->getBool($hex, 0x0A8);
        $this->ArrivalDelayMinutes = $this->getByte($hex, 0x0AA);
        $this->ArrivalDelaySeconds = $this->getByte($hex, 0x0AB);
        $this->Departure1 = new Trigger(substr($hex, 0x0AC), $this->TIE);
        $this->Departure2 = new Trigger(substr($hex, 0x0B2), $this->TIE);
        $this->Departure1OrDeparture2 = $this->getBool($hex, 0x0BA);
        $this->DepartureDelayMinutes = $this->getByte($hex, 0x0BC);
        $this->DepartureDelaySeconds = $this->getByte($hex, 0x0BD);
        $this->AbortTrigger = $this->getByte($hex, 0x0BE);
        $this->Unknown7 = $this->getByte($hex, 0x0BF);
        $this->Unknown8 = $this->getByte($hex, 0x0C0);
        $this->ArrivalMothership = $this->getByte($hex, 0x0C2);
        $this->ArriveViaMothership = $this->getBool($hex, 0x0C3);
        $this->DepartureMothership = $this->getByte($hex, 0x0C4);
        $this->DepartViaMothership = $this->getBool($hex, 0x0C5);
        $this->AlternateArrivalMothership = $this->getByte($hex, 0x0C6);
        $this->AlternateArriveViaMothership = $this->getBool($hex, 0x0C7);
        $this->AlternateDepartureMothership = $this->getByte($hex, 0x0C8);
        $this->AlternateDepartViaMothership = $this->getBool($hex, 0x0C9);
        $this->Unnamed = [];
        $offset = 0xB0A;
        for ($i = 0; $i < 8; $i++) {
            $t = new GoalFG(substr($hex, $offset), $this->TIE);
            $this->Unnamed[] = $t;
            $offset += $t->getLength();
        }
        $this->StartPoints = [];
        $offset = 0xD8A;
        for ($i = 0; $i < 3; $i++) {
            $t = new Waypt(substr($hex, $offset), $this->TIE);
            $this->StartPoints[] = $t;
            $offset += $t->getLength();
        }
        $this->HyperPoint = new Waypt(substr($hex, 0xDA2), $this->TIE);
        $this->StartPointRegions = [];
        $offset = 0xDAA;
        for ($i = 0; $i < 3; $i++) {
            $t = $this->getByte($hex, $offset);
            $this->StartPointRegions[] = $t;
            $offset += 1;
        }
        $this->HyperPointRegion = $this->getByte($hex, 0xDAD);
        $this->Unknown16 = $this->getByte($hex, 0xDAE);
        $this->Unknown17 = $this->getByte($hex, 0xDAF);
        $this->Unknown18 = $this->getByte($hex, 0xDB0);
        $this->Unknown19 = $this->getByte($hex, 0xDB1);
        $this->Unknown20 = $this->getByte($hex, 0xDB2);
        $this->Unknown21 = $this->getByte($hex, 0xDB3);
        $this->Unknown22 = $this->getBool($hex, 0xDB4);
        $this->Unknown23 = $this->getByte($hex, 0xDB6);
        $this->Unknown24 = $this->getByte($hex, 0xDB7);
        $this->Unknown25 = $this->getByte($hex, 0xDB8);
        $this->Unknown26 = $this->getByte($hex, 0xDB9);
        $this->Unknown27 = $this->getByte($hex, 0xDBA);
        $this->Unknown28 = $this->getByte($hex, 0xDBB);
        $this->Unknown29 = $this->getBool($hex, 0xDBC);
        $this->Unknown30 = $this->getBool($hex, 0xDC0);
        $this->Unknown31 = $this->getBool($hex, 0xDC1);
        $this->EnableGlobalUnit = $this->getBool($hex, 0xDC4);
        $this->Unknown32 = $this->getByte($hex, 0xDC5);
        $this->Unknown33 = $this->getByte($hex, 0xDC6);
        $this->Countermeasures = $this->getByte($hex, 0xDC7);
        $this->CraftExplosionTime = $this->getByte($hex, 0xDC8);
        $this->Status2 = $this->getByte($hex, 0xDC9);
        $this->GlobalUnit = $this->getByte($hex, 0xDCA);
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
        $this->Backdrop = $this->getByte($hex, 0xE12);
        $this->Unknown34 = $this->getBool($hex, 0xE29);
        $this->Unknown35 = $this->getBool($hex, 0xE2B);
        $this->Unknown36 = $this->getBool($hex, 0xE2D);
        $this->Unknown37 = $this->getBool($hex, 0xE2F);
        $this->Unknown38 = $this->getBool($hex, 0xE31);
        $this->Unknown39 = $this->getBool($hex, 0xE33);
        $this->Unknown40 = $this->getBool($hex, 0xE35);
        $this->Unknown41 = $this->getBool($hex, 0xE37);
        
    }
    
    public function __debugInfo()
    {
        return [
            "Name" => $this->Name,
            "EnableDesignation" => $this->EnableDesignation,
            "EnableDesignation2" => $this->EnableDesignation2,
            "Designation1" => $this->getDesignation1Label(),
            "Designation2" => $this->getDesignation2Label(),
            "Unknown1" => $this->Unknown1,
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
            "FormationSpacing" => $this->FormationSpacing,
            "GlobalGroup" => $this->GlobalGroup,
            "LeaderSpacing" => $this->LeaderSpacing,
            "NumberOfWaves" => $this->NumberOfWaves,
            "Unknown3" => $this->Unknown3,
            "PlayerNumber" => $this->PlayerNumber,
            "ArriveOnlyIfHuman" => $this->ArriveOnlyIfHuman,
            "PlayerCraft" => $this->PlayerCraft,
            "Yaw" => $this->Yaw,
            "Pitch" => $this->Pitch,
            "Roll" => $this->Roll,
            "Unknown4" => $this->Unknown4,
            "Unknown5" => $this->Unknown5,
            "ArrivalDifficulty" => $this->getArrivalDifficultyLabel(),
            "Arrival1" => $this->Arrival1,
            "Arrival2" => $this->Arrival2,
            "Arrival1OrArrival2" => $this->Arrival1OrArrival2,
            "Unknown6" => $this->Unknown6,
            "Arrival3" => $this->Arrival3,
            "Arrival4" => $this->Arrival4,
            "Arrival3OrArrival4" => $this->Arrival3OrArrival4,
            "Arrivals12OrArrivals34" => $this->Arrivals12OrArrivals34,
            "ArrivalDelayMinutes" => $this->ArrivalDelayMinutes,
            "ArrivalDelaySeconds" => $this->ArrivalDelaySeconds,
            "Departure1" => $this->Departure1,
            "Departure2" => $this->Departure2,
            "Departure1OrDeparture2" => $this->Departure1OrDeparture2,
            "DepartureDelayMinutes" => $this->DepartureDelayMinutes,
            "DepartureDelaySeconds" => $this->DepartureDelaySeconds,
            "AbortTrigger" => $this->getAbortTriggerLabel(),
            "Unknown7" => $this->Unknown7,
            "Unknown8" => $this->Unknown8,
            "ArrivalMothership" => $this->ArrivalMothership,
            "ArriveViaMothership" => $this->ArriveViaMothership,
            "DepartureMothership" => $this->DepartureMothership,
            "DepartViaMothership" => $this->DepartViaMothership,
            "AlternateArrivalMothership" => $this->AlternateArrivalMothership,
            "AlternateArriveViaMothership" => $this->AlternateArriveViaMothership,
            "AlternateDepartureMothership" => $this->AlternateDepartureMothership,
            "AlternateDepartViaMothership" => $this->AlternateDepartViaMothership,
            "Unnamed" => $this->Unnamed,
            "StartPoints" => $this->StartPoints,
            "HyperPoint" => $this->HyperPoint,
            "StartPointRegions" => $this->StartPointRegions,
            "HyperPointRegion" => $this->HyperPointRegion,
            "Unknown16" => $this->Unknown16,
            "Unknown17" => $this->Unknown17,
            "Unknown18" => $this->Unknown18,
            "Unknown19" => $this->Unknown19,
            "Unknown20" => $this->Unknown20,
            "Unknown21" => $this->Unknown21,
            "Unknown22" => $this->Unknown22,
            "Unknown23" => $this->Unknown23,
            "Unknown24" => $this->Unknown24,
            "Unknown25" => $this->Unknown25,
            "Unknown26" => $this->Unknown26,
            "Unknown27" => $this->Unknown27,
            "Unknown28" => $this->Unknown28,
            "Unknown29" => $this->Unknown29,
            "Unknown30" => $this->Unknown30,
            "Unknown31" => $this->Unknown31,
            "EnableGlobalUnit" => $this->EnableGlobalUnit,
            "Unknown32" => $this->Unknown32,
            "Unknown33" => $this->Unknown33,
            "Countermeasures" => $this->Countermeasures,
            "CraftExplosionTime" => $this->CraftExplosionTime,
            "Status2" => $this->getStatus2Label(),
            "GlobalUnit" => $this->GlobalUnit,
            "OptionalWarheads" => $this->OptionalWarheads,
            "OptionalBeams" => $this->OptionalBeams,
            "OptionalCountermeasures" => $this->OptionalCountermeasures,
            "OptionalCraftCategory" => $this->OptionalCraftCategory,
            "OptionalCraft" => $this->OptionalCraft,
            "NumberOfOptionalCraft" => $this->NumberOfOptionalCraft,
            "NumberofOptionalCraftWaves" => $this->NumberofOptionalCraftWaves,
            "PilotID" => $this->PilotID,
            "Backdrop" => $this->Backdrop,
            "Unknown34" => $this->Unknown34,
            "Unknown35" => $this->Unknown35,
            "Unknown36" => $this->Unknown36,
            "Unknown37" => $this->Unknown37,
            "Unknown38" => $this->Unknown38,
            "Unknown39" => $this->Unknown39,
            "Unknown40" => $this->Unknown40,
            "Unknown41" => $this->Unknown41
        ];
    }
    
    public function toHexString()
    {
        $hex = "";
        $offset = 0;

        $this->writeString($hex, $this->Name, 0x000);
        $this->writeByte($hex, $this->EnableDesignation, 0x014);
        $this->writeByte($hex, $this->EnableDesignation2, 0x015);
        $this->writeByte($hex, $this->Designation1, 0x016);
        $this->writeByte($hex, $this->Designation2, 0x017);
        $this->writeByte($hex, $this->Unknown1, 0x018);
        $this->writeByte($hex, $this->GlobalCargoIndex, 0x019);
        $this->writeByte($hex, $this->GlobalSpecialCargoIndex, 0x01A);
        $this->writeString($hex, $this->Cargo, 0x028);
        $this->writeString($hex, $this->SpecialCargo, 0x03C);
        $this->writeString($hex, $this->CraftRole, 0x050);
        $this->writeByte($hex, $this->SpecialCargoCraft, 0x069);
        $this->writeBool($hex, $this->RandomSpecialCargoCraft, 0x06A);
        $this->writeByte($hex, $this->CraftType, 0x06B);
        $this->writeByte($hex, $this->NumberOfCraft, 0x06C);
        $this->writeByte($hex, $this->Status1, 0x06D);
        $this->writeByte($hex, $this->Warhead, 0x06E);
        $this->writeByte($hex, $this->Beam, 0x06F);
        $this->writeByte($hex, $this->Iff, 0x070);
        $this->writeByte($hex, $this->Team, 0x071);
        $this->writeByte($hex, $this->GroupAI, 0x072);
        $this->writeByte($hex, $this->Markings, 0x073);
        $this->writeByte($hex, $this->Radio, 0x074);
        $this->writeByte($hex, $this->Formation, 0x076);
        $this->writeByte($hex, $this->FormationSpacing, 0x077);
        $this->writeByte($hex, $this->GlobalGroup, 0x078);
        $this->writeByte($hex, $this->LeaderSpacing, 0x079);
        $this->writeByte($hex, $this->NumberOfWaves, 0x07A);
        $this->writeByte($hex, $this->Unknown3, 0x07B);
        $this->writeByte($hex, $this->PlayerNumber, 0x07D);
        $this->writeBool($hex, $this->ArriveOnlyIfHuman, 0x07E);
        $this->writeByte($hex, $this->PlayerCraft, 0x07F);
        $this->writeByte($hex, $this->Yaw, 0x080);
        $this->writeByte($hex, $this->Pitch, 0x081);
        $this->writeByte($hex, $this->Roll, 0x082);
        $this->writeByte($hex, $this->Unknown4, 0x084);
        $this->writeByte($hex, $this->Unknown5, 0x086);
        $this->writeByte($hex, $this->ArrivalDifficulty, 0x087);
        $this->writeObject($hex, $this->Arrival1, 0x088);
        $this->writeObject($hex, $this->Arrival2, 0x08E);
        $this->writeBool($hex, $this->Arrival1OrArrival2, 0x096);
        $this->writeBool($hex, $this->Unknown6, 0x097);
        $this->writeObject($hex, $this->Arrival3, 0x098);
        $this->writeObject($hex, $this->Arrival4, 0x09E);
        $this->writeBool($hex, $this->Arrival3OrArrival4, 0x0A6);
        $this->writeBool($hex, $this->Arrivals12OrArrivals34, 0x0A8);
        $this->writeByte($hex, $this->ArrivalDelayMinutes, 0x0AA);
        $this->writeByte($hex, $this->ArrivalDelaySeconds, 0x0AB);
        $this->writeObject($hex, $this->Departure1, 0x0AC);
        $this->writeObject($hex, $this->Departure2, 0x0B2);
        $this->writeBool($hex, $this->Departure1OrDeparture2, 0x0BA);
        $this->writeByte($hex, $this->DepartureDelayMinutes, 0x0BC);
        $this->writeByte($hex, $this->DepartureDelaySeconds, 0x0BD);
        $this->writeByte($hex, $this->AbortTrigger, 0x0BE);
        $this->writeByte($hex, $this->Unknown7, 0x0BF);
        $this->writeByte($hex, $this->Unknown8, 0x0C0);
        $this->writeByte($hex, $this->ArrivalMothership, 0x0C2);
        $this->writeBool($hex, $this->ArriveViaMothership, 0x0C3);
        $this->writeByte($hex, $this->DepartureMothership, 0x0C4);
        $this->writeBool($hex, $this->DepartViaMothership, 0x0C5);
        $this->writeByte($hex, $this->AlternateArrivalMothership, 0x0C6);
        $this->writeBool($hex, $this->AlternateArriveViaMothership, 0x0C7);
        $this->writeByte($hex, $this->AlternateDepartureMothership, 0x0C8);
        $this->writeBool($hex, $this->AlternateDepartViaMothership, 0x0C9);
        $offset = 0xB0A;
        for ($i = 0; $i < 8; $i++) {
            $t = $this->Unnamed[$i];
            $this->writeObject($hex, $t, $offset);
            $offset += $t->getLength();
        }
        $offset = 0xD8A;
        for ($i = 0; $i < 3; $i++) {
            $t = $this->StartPoints[$i];
            $this->writeObject($hex, $t, $offset);
            $offset += $t->getLength();
        }
        $this->writeObject($hex, $this->HyperPoint, 0xDA2);
        $offset = 0xDAA;
        for ($i = 0; $i < 3; $i++) {
            $t = $this->StartPointRegions[$i];
            $this->writeByte($hex, $t, $offset);
            $offset += 1;
        }
        $this->writeByte($hex, $this->HyperPointRegion, 0xDAD);
        $this->writeByte($hex, $this->Unknown16, 0xDAE);
        $this->writeByte($hex, $this->Unknown17, 0xDAF);
        $this->writeByte($hex, $this->Unknown18, 0xDB0);
        $this->writeByte($hex, $this->Unknown19, 0xDB1);
        $this->writeByte($hex, $this->Unknown20, 0xDB2);
        $this->writeByte($hex, $this->Unknown21, 0xDB3);
        $this->writeBool($hex, $this->Unknown22, 0xDB4);
        $this->writeByte($hex, $this->Unknown23, 0xDB6);
        $this->writeByte($hex, $this->Unknown24, 0xDB7);
        $this->writeByte($hex, $this->Unknown25, 0xDB8);
        $this->writeByte($hex, $this->Unknown26, 0xDB9);
        $this->writeByte($hex, $this->Unknown27, 0xDBA);
        $this->writeByte($hex, $this->Unknown28, 0xDBB);
        $this->writeBool($hex, $this->Unknown29, 0xDBC);
        $this->writeBool($hex, $this->Unknown30, 0xDC0);
        $this->writeBool($hex, $this->Unknown31, 0xDC1);
        $this->writeBool($hex, $this->EnableGlobalUnit, 0xDC4);
        $this->writeByte($hex, $this->Unknown32, 0xDC5);
        $this->writeByte($hex, $this->Unknown33, 0xDC6);
        $this->writeByte($hex, $this->Countermeasures, 0xDC7);
        $this->writeByte($hex, $this->CraftExplosionTime, 0xDC8);
        $this->writeByte($hex, $this->Status2, 0xDC9);
        $this->writeByte($hex, $this->GlobalUnit, 0xDCA);
        $offset = 0xDCC;
        for ($i = 0; $i < 8; $i++) {
            $t = $this->OptionalWarheads[$i];
            $this->writeByte($hex, $t, $offset);
            $offset += 1;
        }
        $offset = 0xDD4;
        for ($i = 0; $i < 4; $i++) {
            $t = $this->OptionalBeams[$i];
            $this->writeByte($hex, $t, $offset);
            $offset += 1;
        }
        $offset = 0xDDA;
        for ($i = 0; $i < 3; $i++) {
            $t = $this->OptionalCountermeasures[$i];
            $this->writeByte($hex, $t, $offset);
            $offset += 1;
        }
        $this->writeByte($hex, $this->OptionalCraftCategory, 0xDDE);
        $offset = 0xDDF;
        for ($i = 0; $i < 10; $i++) {
            $t = $this->OptionalCraft[$i];
            $this->writeByte($hex, $t, $offset);
            $offset += 1;
        }
        $offset = 0xDE9;
        for ($i = 0; $i < 10; $i++) {
            $t = $this->NumberOfOptionalCraft[$i];
            $this->writeByte($hex, $t, $offset);
            $offset += 1;
        }
        $offset = 0xDF3;
        for ($i = 0; $i < 10; $i++) {
            $t = $this->NumberofOptionalCraftWaves[$i];
            $this->writeByte($hex, $t, $offset);
            $offset += 1;
        }
        $this->writeString($hex, $this->PilotID, 0xDFD);
        $this->writeByte($hex, $this->Backdrop, 0xE12);
        $this->writeBool($hex, $this->Unknown34, 0xE29);
        $this->writeBool($hex, $this->Unknown35, 0xE2B);
        $this->writeBool($hex, $this->Unknown36, 0xE2D);
        $this->writeBool($hex, $this->Unknown37, 0xE2F);
        $this->writeBool($hex, $this->Unknown38, 0xE31);
        $this->writeBool($hex, $this->Unknown39, 0xE33);
        $this->writeBool($hex, $this->Unknown40, 0xE35);
        $this->writeBool($hex, $this->Unknown41, 0xE37);

        return $hex;
    }
    
    public function getDesignation1Label() 
    {
        return isset($this->Designation1) && isset(Constants::$DESIGNATION[$this->Designation1]) ? Constants::$DESIGNATION[$this->Designation1] : "Unknown";
    }

    public function getDesignation2Label() 
    {
        return isset($this->Designation2) && isset(Constants::$DESIGNATION[$this->Designation2]) ? Constants::$DESIGNATION[$this->Designation2] : "Unknown";
    }

    public function getCraftTypeLabel() 
    {
        return isset($this->CraftType) && isset(Constants::$CRAFTTYPE[$this->CraftType]) ? Constants::$CRAFTTYPE[$this->CraftType] : "Unknown";
    }

    public function getStatus1Label() 
    {
        return isset($this->Status1) && isset(Constants::$STATUS[$this->Status1]) ? Constants::$STATUS[$this->Status1] : "Unknown";
    }

    public function getWarheadLabel() 
    {
        return isset($this->Warhead) && isset(Constants::$WARHEAD[$this->Warhead]) ? Constants::$WARHEAD[$this->Warhead] : "Unknown";
    }

    public function getBeamLabel() 
    {
        return isset($this->Beam) && isset(Constants::$BEAM[$this->Beam]) ? Constants::$BEAM[$this->Beam] : "Unknown";
    }

    public function getGroupAILabel() 
    {
        return isset($this->GroupAI) && isset(Constants::$GROUPAI[$this->GroupAI]) ? Constants::$GROUPAI[$this->GroupAI] : "Unknown";
    }

    public function getMarkingsLabel() 
    {
        return isset($this->Markings) && isset(Constants::$MARKINGS[$this->Markings]) ? Constants::$MARKINGS[$this->Markings] : "Unknown";
    }

    public function getRadioLabel() 
    {
        return isset($this->Radio) && isset(Constants::$RADIO[$this->Radio]) ? Constants::$RADIO[$this->Radio] : "Unknown";
    }

    public function getFormationLabel() 
    {
        return isset($this->Formation) && isset(Constants::$FORMATION[$this->Formation]) ? Constants::$FORMATION[$this->Formation] : "Unknown";
    }

    public function getArrivalDifficultyLabel() 
    {
        return isset($this->ArrivalDifficulty) && isset(Constants::$ARRIVALDIFFICULTY[$this->ArrivalDifficulty]) ? Constants::$ARRIVALDIFFICULTY[$this->ArrivalDifficulty] : "Unknown";
    }

    public function getAbortTriggerLabel() 
    {
        return isset($this->AbortTrigger) && isset(Constants::$ABORTTRIGGER[$this->AbortTrigger]) ? Constants::$ABORTTRIGGER[$this->AbortTrigger] : "Unknown";
    }

    public function getStatus2Label() 
    {
        return isset($this->Status2) && isset(Constants::$STATUS[$this->Status2]) ? Constants::$STATUS[$this->Status2] : "Unknown";
    }
    
    public function getLength()
    {
        return self::FLIGHTGROUPLENGTH;
    }
}