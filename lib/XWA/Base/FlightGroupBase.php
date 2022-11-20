<?php

namespace Pyrite\XWA\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;
use Pyrite\XWA\Constants;
use Pyrite\XWA\GoalFG;
use Pyrite\XWA\Order;
use Pyrite\XWA\Skip;
use Pyrite\XWA\Trigger;
use Pyrite\XWA\Waypt;

abstract class FlightGroupBase extends PyriteBase implements Byteable
{
    use HexDecoder;
    use HexEncoder;

    /** @var integer  FLIGHTGROUPLENGTH INT */
    public const FLIGHTGROUPLENGTH = 3646;
    /** @var string 0x000 Name STR */
    public $Name;
    /** @var integer 0x014 EnableDesignation BYTE */
    public $EnableDesignation;
    /** @var integer 0x015 EnableDesignation2 BYTE */
    public $EnableDesignation2;
    /** @var integer 0x016 Designation1 BYTE */
    public $Designation1;
    /** @var integer 0x017 Designation2 BYTE */
    public $Designation2;
    /** @var integer 0x018 Unknown1 BYTE */
    public $Unknown1;
    /** @var integer 0x019 GlobalCargoIndex BYTE */
    public $GlobalCargoIndex;
    /** @var integer 0x01A GlobalSpecialCargoIndex BYTE */
    public $GlobalSpecialCargoIndex;
    /** @var string 0x028 Cargo STR */
    public $Cargo;
    /** @var string 0x03C SpecialCargo STR */
    public $SpecialCargo;
    /** @var string 0x050 CraftRole STR */
    public $CraftRole;
    /** @var integer 0x069 SpecialCargoCraft BYTE */
    public $SpecialCargoCraft;
    /** @var boolean 0x06A RandomSpecialCargoCraft BOOL */
    public $RandomSpecialCargoCraft;
    /** @var integer 0x06B CraftType BYTE */
    public $CraftType;
    /** @var integer 0x06C NumberOfCraft BYTE */
    public $NumberOfCraft;
    /** @var integer 0x06D Status1 BYTE */
    public $Status1;
    /** @var integer 0x06E Warhead BYTE */
    public $Warhead;
    /** @var integer 0x06F Beam BYTE */
    public $Beam;
    /** @var integer 0x070 Iff BYTE */
    public $Iff;
    /** @var integer 0x071 Team BYTE */
    public $Team;
    /** @var integer 0x072 GroupAI BYTE */
    public $GroupAI;
    /** @var integer 0x073 Markings BYTE */
    public $Markings;
    /** @var integer 0x074 Radio BYTE */
    public $Radio;
    /** @var integer 0x076 Formation BYTE */
    public $Formation;
    /** @var integer 0x077 FormationSpacing BYTE */
    public $FormationSpacing;
    /** @var integer 0x078 GlobalGroup BYTE */
    public $GlobalGroup;
    /** @var integer 0x079 LeaderSpacing BYTE */
    public $LeaderSpacing;
    /** @var integer 0x07A NumberOfWaves BYTE */
    public $NumberOfWaves;
    /** @var integer 0x07B Unknown3 BYTE */
    public $Unknown3;
    /** @var integer 0x07D PlayerNumber BYTE */
    public $PlayerNumber;
    /** @var boolean 0x07E ArriveOnlyIfHuman BOOL */
    public $ArriveOnlyIfHuman;
    /** @var integer 0x07F PlayerCraft BYTE */
    public $PlayerCraft;
    /** @var integer 0x080 Yaw BYTE */
    public $Yaw;
    /** @var integer 0x081 Pitch BYTE */
    public $Pitch;
    /** @var integer 0x082 Roll BYTE */
    public $Roll;
    /** @var integer 0x084 Unknown4 BYTE */
    public $Unknown4;
    /** @var integer 0x086 Unknown5 BYTE */
    public $Unknown5;
    /** @var integer 0x087 ArrivalDifficulty BYTE */
    public $ArrivalDifficulty;
    /** @var Trigger 0x088 Arrival1 Trigger */
    public $Arrival1;
    /** @var Trigger 0x08E Arrival2 Trigger */
    public $Arrival2;
    /** @var boolean 0x096 Arrival1OrArrival2 BOOL */
    public $Arrival1OrArrival2;
    /** @var boolean 0x097 Unknown6 BOOL */
    public $Unknown6;
    /** @var Trigger 0x098 Arrival3 Trigger */
    public $Arrival3;
    /** @var Trigger 0x09E Arrival4 Trigger */
    public $Arrival4;
    /** @var boolean 0x0A6 Arrival3OrArrival4 BOOL */
    public $Arrival3OrArrival4;
    /** @var boolean 0x0A8 Arrivals12OrArrivals34 BOOL */
    public $Arrivals12OrArrivals34;
    /** @var integer 0x0AA ArrivalDelayMinutes BYTE */
    public $ArrivalDelayMinutes;
    /** @var integer 0x0AB ArrivalDelaySeconds BYTE */
    public $ArrivalDelaySeconds;
    /** @var Trigger 0x0AC Departure1 Trigger */
    public $Departure1;
    /** @var Trigger 0x0B2 Departure2 Trigger */
    public $Departure2;
    /** @var boolean 0x0BA Departure1OrDeparture2 BOOL */
    public $Departure1OrDeparture2;
    /** @var integer 0x0BC DepartureDelayMinutes BYTE */
    public $DepartureDelayMinutes;
    /** @var integer 0x0BD DepartureDelaySeconds BYTE */
    public $DepartureDelaySeconds;
    /** @var integer 0x0BE AbortTrigger BYTE */
    public $AbortTrigger;
    /** @var integer 0x0BF Unknown7 BYTE */
    public $Unknown7;
    /** @var integer 0x0C0 Unknown8 BYTE */
    public $Unknown8;
    /** @var integer 0x0C2 ArrivalMothership BYTE */
    public $ArrivalMothership;
    /** @var boolean 0x0C3 ArriveViaMothership BOOL */
    public $ArriveViaMothership;
    /** @var integer 0x0C4 DepartureMothership BYTE */
    public $DepartureMothership;
    /** @var boolean 0x0C5 DepartViaMothership BOOL */
    public $DepartViaMothership;
    /** @var integer 0x0C6 AlternateArrivalMothership BYTE */
    public $AlternateArrivalMothership;
    /** @var boolean 0x0C7 AlternateArriveViaMothership BOOL */
    public $AlternateArriveViaMothership;
    /** @var integer 0x0C8 AlternateDepartureMothership BYTE */
    public $AlternateDepartureMothership;
    /** @var boolean 0x0C9 AlternateDepartViaMothership BOOL */
    public $AlternateDepartViaMothership;
    /** @var Order[] 0x0CA Orders Order */
    public $Orders;
    /** @var Skip[] 0xA0A Skips Skip */
    public $Skips;
    /** @var GoalFG[] 0xB0A Goals GoalFG */
    public $Goals;
    /** @var Waypt[] 0xD8A StartPoints Waypt */
    public $StartPoints;
    /** @var Waypt 0xDA2 HyperPoint Waypt */
    public $HyperPoint;
    /** @var integer[] 0xDAA StartPointRegions BYTE */
    public $StartPointRegions;
    /** @var integer 0xDAD HyperPointRegion BYTE */
    public $HyperPointRegion;
    /** @var integer 0xDAE Unknown16 BYTE */
    public $Unknown16;
    /** @var integer 0xDAF Unknown17 BYTE */
    public $Unknown17;
    /** @var integer 0xDB0 Unknown18 BYTE */
    public $Unknown18;
    /** @var integer 0xDB1 Unknown19 BYTE */
    public $Unknown19;
    /** @var integer 0xDB2 Unknown20 BYTE */
    public $Unknown20;
    /** @var integer 0xDB3 Unknown21 BYTE */
    public $Unknown21;
    /** @var boolean 0xDB4 Unknown22 BOOL */
    public $Unknown22;
    /** @var integer 0xDB6 Unknown23 BYTE */
    public $Unknown23;
    /** @var integer 0xDB7 Unknown24 BYTE */
    public $Unknown24;
    /** @var integer 0xDB8 Unknown25 BYTE */
    public $Unknown25;
    /** @var integer 0xDB9 Unknown26 BYTE */
    public $Unknown26;
    /** @var integer 0xDBA Unknown27 BYTE */
    public $Unknown27;
    /** @var integer 0xDBB Unknown28 BYTE */
    public $Unknown28;
    /** @var boolean 0xDBC Unknown29 BOOL */
    public $Unknown29;
    /** @var boolean 0xDC0 Unknown30 BOOL */
    public $Unknown30;
    /** @var boolean 0xDC1 Unknown31 BOOL */
    public $Unknown31;
    /** @var boolean 0xDC4 EnableGlobalUnit BOOL */
    public $EnableGlobalUnit;
    /** @var integer 0xDC5 Unknown32 BYTE */
    public $Unknown32;
    /** @var integer 0xDC6 Unknown33 BYTE */
    public $Unknown33;
    /** @var integer 0xDC7 Countermeasures BYTE */
    public $Countermeasures;
    /** @var integer 0xDC8 CraftExplosionTime BYTE */
    public $CraftExplosionTime;
    /** @var integer 0xDC9 Status2 BYTE */
    public $Status2;
    /** @var integer 0xDCA GlobalUnit BYTE */
    public $GlobalUnit;
    /** @var integer[] 0xDCC OptionalWarheads BYTE */
    public $OptionalWarheads;
    /** @var integer[] 0xDD4 OptionalBeams BYTE */
    public $OptionalBeams;
    /** @var integer[] 0xDDA OptionalCountermeasures BYTE */
    public $OptionalCountermeasures;
    /** @var integer 0xDDE OptionalCraftCategory BYTE */
    public $OptionalCraftCategory;
    /** @var integer[] 0xDDF OptionalCraft BYTE */
    public $OptionalCraft;
    /** @var integer[] 0xDE9 NumberOfOptionalCraft BYTE */
    public $NumberOfOptionalCraft;
    /** @var integer[] 0xDF3 NumberofOptionalCraftWaves BYTE */
    public $NumberofOptionalCraftWaves;
    /** @var string 0xDFD PilotID STR */
    public $PilotID;
    /** @var integer 0xE12 Backdrop BYTE */
    public $Backdrop;
    /** @var boolean 0xE29 Unknown34 BOOL */
    public $Unknown34;
    /** @var boolean 0xE2B Unknown35 BOOL */
    public $Unknown35;
    /** @var boolean 0xE2D Unknown36 BOOL */
    public $Unknown36;
    /** @var boolean 0xE2F Unknown37 BOOL */
    public $Unknown37;
    /** @var boolean 0xE31 Unknown38 BOOL */
    public $Unknown38;
    /** @var boolean 0xE33 Unknown39 BOOL */
    public $Unknown39;
    /** @var boolean 0xE35 Unknown40 BOOL */
    public $Unknown40;
    /** @var boolean 0xE37 Unknown41 BOOL */
    public $Unknown41;
    
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
        $this->Arrival1 = (new Trigger(substr($hex, 0x088), $this->TIE))->loadHex();
        $this->Arrival2 = (new Trigger(substr($hex, 0x08E), $this->TIE))->loadHex();
        $this->Arrival1OrArrival2 = $this->getBool($hex, 0x096);
        $this->Unknown6 = $this->getBool($hex, 0x097);
        $this->Arrival3 = (new Trigger(substr($hex, 0x098), $this->TIE))->loadHex();
        $this->Arrival4 = (new Trigger(substr($hex, 0x09E), $this->TIE))->loadHex();
        $this->Arrival3OrArrival4 = $this->getBool($hex, 0x0A6);
        $this->Arrivals12OrArrivals34 = $this->getBool($hex, 0x0A8);
        $this->ArrivalDelayMinutes = $this->getByte($hex, 0x0AA);
        $this->ArrivalDelaySeconds = $this->getByte($hex, 0x0AB);
        $this->Departure1 = (new Trigger(substr($hex, 0x0AC), $this->TIE))->loadHex();
        $this->Departure2 = (new Trigger(substr($hex, 0x0B2), $this->TIE))->loadHex();
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
        $this->Orders = [];
        $offset = 0x0CA;
        for ($i = 0; $i < 16; $i++) {
            $t = (new Order(substr($hex, $offset), $this->TIE))->loadHex();
            $this->Orders[] = $t;
            $offset += $t->getLength();
        }
        $this->Skips = [];
        $offset = 0xA0A;
        for ($i = 0; $i < 16; $i++) {
            $t = (new Skip(substr($hex, $offset), $this->TIE))->loadHex();
            $this->Skips[] = $t;
            $offset += $t->getLength();
        }
        $this->Goals = [];
        $offset = 0xB0A;
        for ($i = 0; $i < 8; $i++) {
            $t = (new GoalFG(substr($hex, $offset), $this->TIE))->loadHex();
            $this->Goals[] = $t;
            $offset += $t->getLength();
        }
        $this->StartPoints = [];
        $offset = 0xD8A;
        for ($i = 0; $i < 3; $i++) {
            $t = (new Waypt(substr($hex, $offset), $this->TIE))->loadHex();
            $this->StartPoints[] = $t;
            $offset += $t->getLength();
        }
        $this->HyperPoint = (new Waypt(substr($hex, 0xDA2), $this->TIE))->loadHex();
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
        
        return $this;
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
            "Orders" => $this->Orders,
            "Skips" => $this->Skips,
            "Goals" => $this->Goals,
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
    
    public function toHexString($hex = null)
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        [$hex, $offset] = $this->writeString($this->Name, $hex, 0x000);
        [$hex, $offset] = $this->writeByte($this->EnableDesignation, $hex, 0x014);
        [$hex, $offset] = $this->writeByte($this->EnableDesignation2, $hex, 0x015);
        [$hex, $offset] = $this->writeByte($this->Designation1, $hex, 0x016);
        [$hex, $offset] = $this->writeByte($this->Designation2, $hex, 0x017);
        [$hex, $offset] = $this->writeByte($this->Unknown1, $hex, 0x018);
        [$hex, $offset] = $this->writeByte($this->GlobalCargoIndex, $hex, 0x019);
        [$hex, $offset] = $this->writeByte($this->GlobalSpecialCargoIndex, $hex, 0x01A);
        [$hex, $offset] = $this->writeString($this->Cargo, $hex, 0x028);
        [$hex, $offset] = $this->writeString($this->SpecialCargo, $hex, 0x03C);
        [$hex, $offset] = $this->writeString($this->CraftRole, $hex, 0x050);
        [$hex, $offset] = $this->writeByte($this->SpecialCargoCraft, $hex, 0x069);
        [$hex, $offset] = $this->writeBool($this->RandomSpecialCargoCraft, $hex, 0x06A);
        [$hex, $offset] = $this->writeByte($this->CraftType, $hex, 0x06B);
        [$hex, $offset] = $this->writeByte($this->NumberOfCraft, $hex, 0x06C);
        [$hex, $offset] = $this->writeByte($this->Status1, $hex, 0x06D);
        [$hex, $offset] = $this->writeByte($this->Warhead, $hex, 0x06E);
        [$hex, $offset] = $this->writeByte($this->Beam, $hex, 0x06F);
        [$hex, $offset] = $this->writeByte($this->Iff, $hex, 0x070);
        [$hex, $offset] = $this->writeByte($this->Team, $hex, 0x071);
        [$hex, $offset] = $this->writeByte($this->GroupAI, $hex, 0x072);
        [$hex, $offset] = $this->writeByte($this->Markings, $hex, 0x073);
        [$hex, $offset] = $this->writeByte($this->Radio, $hex, 0x074);
        [$hex, $offset] = $this->writeByte($this->Formation, $hex, 0x076);
        [$hex, $offset] = $this->writeByte($this->FormationSpacing, $hex, 0x077);
        [$hex, $offset] = $this->writeByte($this->GlobalGroup, $hex, 0x078);
        [$hex, $offset] = $this->writeByte($this->LeaderSpacing, $hex, 0x079);
        [$hex, $offset] = $this->writeByte($this->NumberOfWaves, $hex, 0x07A);
        [$hex, $offset] = $this->writeByte($this->Unknown3, $hex, 0x07B);
        [$hex, $offset] = $this->writeByte($this->PlayerNumber, $hex, 0x07D);
        [$hex, $offset] = $this->writeBool($this->ArriveOnlyIfHuman, $hex, 0x07E);
        [$hex, $offset] = $this->writeByte($this->PlayerCraft, $hex, 0x07F);
        [$hex, $offset] = $this->writeByte($this->Yaw, $hex, 0x080);
        [$hex, $offset] = $this->writeByte($this->Pitch, $hex, 0x081);
        [$hex, $offset] = $this->writeByte($this->Roll, $hex, 0x082);
        [$hex, $offset] = $this->writeByte($this->Unknown4, $hex, 0x084);
        [$hex, $offset] = $this->writeByte($this->Unknown5, $hex, 0x086);
        [$hex, $offset] = $this->writeByte($this->ArrivalDifficulty, $hex, 0x087);
        [$hex, $offset] = $this->writeObject($this->Arrival1, $hex, 0x088);
        [$hex, $offset] = $this->writeObject($this->Arrival2, $hex, 0x08E);
        [$hex, $offset] = $this->writeBool($this->Arrival1OrArrival2, $hex, 0x096);
        [$hex, $offset] = $this->writeBool($this->Unknown6, $hex, 0x097);
        [$hex, $offset] = $this->writeObject($this->Arrival3, $hex, 0x098);
        [$hex, $offset] = $this->writeObject($this->Arrival4, $hex, 0x09E);
        [$hex, $offset] = $this->writeBool($this->Arrival3OrArrival4, $hex, 0x0A6);
        [$hex, $offset] = $this->writeBool($this->Arrivals12OrArrivals34, $hex, 0x0A8);
        [$hex, $offset] = $this->writeByte($this->ArrivalDelayMinutes, $hex, 0x0AA);
        [$hex, $offset] = $this->writeByte($this->ArrivalDelaySeconds, $hex, 0x0AB);
        [$hex, $offset] = $this->writeObject($this->Departure1, $hex, 0x0AC);
        [$hex, $offset] = $this->writeObject($this->Departure2, $hex, 0x0B2);
        [$hex, $offset] = $this->writeBool($this->Departure1OrDeparture2, $hex, 0x0BA);
        [$hex, $offset] = $this->writeByte($this->DepartureDelayMinutes, $hex, 0x0BC);
        [$hex, $offset] = $this->writeByte($this->DepartureDelaySeconds, $hex, 0x0BD);
        [$hex, $offset] = $this->writeByte($this->AbortTrigger, $hex, 0x0BE);
        [$hex, $offset] = $this->writeByte($this->Unknown7, $hex, 0x0BF);
        [$hex, $offset] = $this->writeByte($this->Unknown8, $hex, 0x0C0);
        [$hex, $offset] = $this->writeByte($this->ArrivalMothership, $hex, 0x0C2);
        [$hex, $offset] = $this->writeBool($this->ArriveViaMothership, $hex, 0x0C3);
        [$hex, $offset] = $this->writeByte($this->DepartureMothership, $hex, 0x0C4);
        [$hex, $offset] = $this->writeBool($this->DepartViaMothership, $hex, 0x0C5);
        [$hex, $offset] = $this->writeByte($this->AlternateArrivalMothership, $hex, 0x0C6);
        [$hex, $offset] = $this->writeBool($this->AlternateArriveViaMothership, $hex, 0x0C7);
        [$hex, $offset] = $this->writeByte($this->AlternateDepartureMothership, $hex, 0x0C8);
        [$hex, $offset] = $this->writeBool($this->AlternateDepartViaMothership, $hex, 0x0C9);
        $offset = 0x0CA;
        for ($i = 0; $i < 16; $i++) {
            $t = $this->Orders[$i];
            [$hex, $offset] = $this->writeObject($t, $hex, $offset);
        }
        $offset = 0xA0A;
        for ($i = 0; $i < 16; $i++) {
            $t = $this->Skips[$i];
            [$hex, $offset] = $this->writeObject($t, $hex, $offset);
        }
        $offset = 0xB0A;
        for ($i = 0; $i < 8; $i++) {
            $t = $this->Goals[$i];
            [$hex, $offset] = $this->writeObject($t, $hex, $offset);
        }
        $offset = 0xD8A;
        for ($i = 0; $i < 3; $i++) {
            $t = $this->StartPoints[$i];
            [$hex, $offset] = $this->writeObject($t, $hex, $offset);
        }
        [$hex, $offset] = $this->writeObject($this->HyperPoint, $hex, 0xDA2);
        $offset = 0xDAA;
        for ($i = 0; $i < 3; $i++) {
            $t = $this->StartPointRegions[$i];
            [$hex, $offset] = $this->writeByte($t, $hex, $offset);
        }
        [$hex, $offset] = $this->writeByte($this->HyperPointRegion, $hex, 0xDAD);
        [$hex, $offset] = $this->writeByte($this->Unknown16, $hex, 0xDAE);
        [$hex, $offset] = $this->writeByte($this->Unknown17, $hex, 0xDAF);
        [$hex, $offset] = $this->writeByte($this->Unknown18, $hex, 0xDB0);
        [$hex, $offset] = $this->writeByte($this->Unknown19, $hex, 0xDB1);
        [$hex, $offset] = $this->writeByte($this->Unknown20, $hex, 0xDB2);
        [$hex, $offset] = $this->writeByte($this->Unknown21, $hex, 0xDB3);
        [$hex, $offset] = $this->writeBool($this->Unknown22, $hex, 0xDB4);
        [$hex, $offset] = $this->writeByte($this->Unknown23, $hex, 0xDB6);
        [$hex, $offset] = $this->writeByte($this->Unknown24, $hex, 0xDB7);
        [$hex, $offset] = $this->writeByte($this->Unknown25, $hex, 0xDB8);
        [$hex, $offset] = $this->writeByte($this->Unknown26, $hex, 0xDB9);
        [$hex, $offset] = $this->writeByte($this->Unknown27, $hex, 0xDBA);
        [$hex, $offset] = $this->writeByte($this->Unknown28, $hex, 0xDBB);
        [$hex, $offset] = $this->writeBool($this->Unknown29, $hex, 0xDBC);
        [$hex, $offset] = $this->writeBool($this->Unknown30, $hex, 0xDC0);
        [$hex, $offset] = $this->writeBool($this->Unknown31, $hex, 0xDC1);
        [$hex, $offset] = $this->writeBool($this->EnableGlobalUnit, $hex, 0xDC4);
        [$hex, $offset] = $this->writeByte($this->Unknown32, $hex, 0xDC5);
        [$hex, $offset] = $this->writeByte($this->Unknown33, $hex, 0xDC6);
        [$hex, $offset] = $this->writeByte($this->Countermeasures, $hex, 0xDC7);
        [$hex, $offset] = $this->writeByte($this->CraftExplosionTime, $hex, 0xDC8);
        [$hex, $offset] = $this->writeByte($this->Status2, $hex, 0xDC9);
        [$hex, $offset] = $this->writeByte($this->GlobalUnit, $hex, 0xDCA);
        $offset = 0xDCC;
        for ($i = 0; $i < 8; $i++) {
            $t = $this->OptionalWarheads[$i];
            [$hex, $offset] = $this->writeByte($t, $hex, $offset);
        }
        $offset = 0xDD4;
        for ($i = 0; $i < 4; $i++) {
            $t = $this->OptionalBeams[$i];
            [$hex, $offset] = $this->writeByte($t, $hex, $offset);
        }
        $offset = 0xDDA;
        for ($i = 0; $i < 3; $i++) {
            $t = $this->OptionalCountermeasures[$i];
            [$hex, $offset] = $this->writeByte($t, $hex, $offset);
        }
        [$hex, $offset] = $this->writeByte($this->OptionalCraftCategory, $hex, 0xDDE);
        $offset = 0xDDF;
        for ($i = 0; $i < 10; $i++) {
            $t = $this->OptionalCraft[$i];
            [$hex, $offset] = $this->writeByte($t, $hex, $offset);
        }
        $offset = 0xDE9;
        for ($i = 0; $i < 10; $i++) {
            $t = $this->NumberOfOptionalCraft[$i];
            [$hex, $offset] = $this->writeByte($t, $hex, $offset);
        }
        $offset = 0xDF3;
        for ($i = 0; $i < 10; $i++) {
            $t = $this->NumberofOptionalCraftWaves[$i];
            [$hex, $offset] = $this->writeByte($t, $hex, $offset);
        }
        [$hex, $offset] = $this->writeString($this->PilotID, $hex, 0xDFD);
        [$hex, $offset] = $this->writeByte($this->Backdrop, $hex, 0xE12);
        [$hex, $offset] = $this->writeBool($this->Unknown34, $hex, 0xE29);
        [$hex, $offset] = $this->writeBool($this->Unknown35, $hex, 0xE2B);
        [$hex, $offset] = $this->writeBool($this->Unknown36, $hex, 0xE2D);
        [$hex, $offset] = $this->writeBool($this->Unknown37, $hex, 0xE2F);
        [$hex, $offset] = $this->writeBool($this->Unknown38, $hex, 0xE31);
        [$hex, $offset] = $this->writeBool($this->Unknown39, $hex, 0xE33);
        [$hex, $offset] = $this->writeBool($this->Unknown40, $hex, 0xE35);
        [$hex, $offset] = $this->writeBool($this->Unknown41, $hex, 0xE37);

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