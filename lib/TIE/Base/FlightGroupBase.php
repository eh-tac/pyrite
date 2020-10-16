<?php

namespace Pyrite\TIE\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\PyriteBase;
use Pyrite\TIE\Constants;
use Pyrite\TIE\GoalFG;
use Pyrite\TIE\Order;
use Pyrite\TIE\Trigger;
use Pyrite\TIE\Waypt;

abstract class FlightGroupBase extends PyriteBase implements Byteable
{
    use HexDecoder;

    /** @var integer */
    public const FLIGHTGROUPLENGTH = 292;
    /** @var string */
    public $Name;
    /** @var string */
    public $Pilot;
    /** @var string */
    public $Cargo;
    /** @var string */
    public $SpecialCargo;
    /** @var integer */
    public $SpecialCargoCraft;
    /** @var boolean */
    public $RandomSpecialCargoCraft;
    /** @var integer */
    public $CraftType;
    /** @var integer */
    public $NumberOfCraft;
    /** @var integer */
    public $Status;
    /** @var integer */
    public $Warhead;
    /** @var integer */
    public $Beam;
    /** @var integer */
    public $Iff;
    /** @var integer */
    public $GroupAI;
    /** @var integer */
    public $Markings;
    /** @var boolean */
    public $ObeyPlayerOrders;
    /** @var integer */
    public const Reserved1 = 0; //Unknown1 in TFW
    /** @var integer */
    public $Formation;
    /** @var integer */
    public $FormationSpacing; //Unknown2
    /** @var integer */
    public $GlobalGroup; //Unknown3
    /** @var integer */
    public $LeaderSpacing; //Unknown4
    /** @var integer */
    public $NumberOfWaves;
    /** @var integer */
    public $Unknown5;
    /** @var integer */
    public $PlayerCraft;
    /** @var integer */
    public $Yaw; //Unknown6
    /** @var integer */
    public $Pitch; //Unknown7
    /** @var integer */
    public $Roll; //Unknown8
    /** @var boolean */
    public $Unknown9;
    /** @var integer */
    public $Unknown10;
    /** @var integer */
    public const Reserved2 = 0; //Unknown11
    /** @var integer */
    public $ArrivalDifficulty;
    /** @var Trigger */
    public $Arrival1;
    /** @var Trigger */
    public $Arrival2;
    /** @var boolean */
    public $Arrival1OrArrival2;
    /** @var integer */
    public const Reserved3 = 0; //Unknown12
    /** @var integer */
    public $ArrivalDelayMinutes;
    /** @var integer */
    public $ArrivalDelaySeconds;
    /** @var Trigger */
    public $Departure;
    /** @var integer */
    public $DepartureDelayMinutes; //Unknown13
    /** @var integer */
    public $DepartureDelatSeconds; //Unknown14
    /** @var integer */
    public $AbortTrigger;
    /** @var integer */
    public const Reserved4 = 0; //Unknown15
    /** @var integer */
    public $Unknown16;
    /** @var integer */
    public const Reserved5 = 0; //Unknown17
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
    /** @var Order[] */
    public $Orders;
    /** @var GoalFG[] */
    public $FlightGroupGoals;
    /** @var integer */
    public $BonusGoalPoints;
    /** @var Waypt[] */
    public $Waypoints;
    /** @var boolean */
    public $Unknown19;
    /** @var integer */
    public $Unknown20;
    /** @var boolean */
    public $Unknown21;
    
    public function __construct($hex, $tie = null)
    {
        parent::__construct($hex, $tie);
        $this->beforeConstruct();
        $offset = 0;

        $this->Name = $this->getChar($hex, 0x000, 12);
        $this->Pilot = $this->getChar($hex, 0x00C, 12);
        $this->Cargo = $this->getChar($hex, 0x018, 12);
        $this->SpecialCargo = $this->getChar($hex, 0x024, 12);
        $this->SpecialCargoCraft = $this->getByte($hex, 0x030);
        $this->RandomSpecialCargoCraft = $this->getBool($hex, 0x031);
        $this->CraftType = $this->getByte($hex, 0x032);
        $this->NumberOfCraft = $this->getByte($hex, 0x033);
        $this->Status = $this->getByte($hex, 0x034);
        $this->Warhead = $this->getByte($hex, 0x035);
        $this->Beam = $this->getByte($hex, 0x036);
        $this->Iff = $this->getByte($hex, 0x037);
        $this->GroupAI = $this->getByte($hex, 0x038);
        $this->Markings = $this->getByte($hex, 0x039);
        $this->ObeyPlayerOrders = $this->getBool($hex, 0x03A);
        // static BYTE value Reserved1 = 0
        $this->Formation = $this->getByte($hex, 0x03C);
        $this->FormationSpacing = $this->getByte($hex, 0x03D);
        $this->GlobalGroup = $this->getByte($hex, 0x03E);
        $this->LeaderSpacing = $this->getByte($hex, 0x03F);
        $this->NumberOfWaves = $this->getByte($hex, 0x040);
        $this->Unknown5 = $this->getByte($hex, 0x041);
        $this->PlayerCraft = $this->getByte($hex, 0x042);
        $this->Yaw = $this->getByte($hex, 0x043);
        $this->Pitch = $this->getByte($hex, 0x044);
        $this->Roll = $this->getByte($hex, 0x045);
        $this->Unknown9 = $this->getBool($hex, 0x046);
        $this->Unknown10 = $this->getByte($hex, 0x047);
        // static BYTE value Reserved2 = 0
        $this->ArrivalDifficulty = $this->getByte($hex, 0x049);
        $this->Arrival1 = new Trigger(substr($hex, 0x04A), $this->TIE);
        $this->Arrival2 = new Trigger(substr($hex, 0x04E), $this->TIE);
        $this->Arrival1OrArrival2 = $this->getBool($hex, 0x052);
        // static BYTE value Reserved3 = 0
        $this->ArrivalDelayMinutes = $this->getByte($hex, 0x054);
        $this->ArrivalDelaySeconds = $this->getByte($hex, 0x055);
        $this->Departure = new Trigger(substr($hex, 0x056), $this->TIE);
        $this->DepartureDelayMinutes = $this->getByte($hex, 0x05A);
        $this->DepartureDelatSeconds = $this->getByte($hex, 0x05B);
        $this->AbortTrigger = $this->getByte($hex, 0x05C);
        // static BYTE value Reserved4 = 0
        $this->Unknown16 = $this->getByte($hex, 0x05E);
        // static BYTE value Reserved5 = 0
        $this->ArrivalMothership = $this->getByte($hex, 0x060);
        $this->ArriveViaMothership = $this->getBool($hex, 0x061);
        $this->DepartureMothership = $this->getByte($hex, 0x062);
        $this->DepartViaMothership = $this->getBool($hex, 0x063);
        $this->AlternateArrivalMothership = $this->getByte($hex, 0x064);
        $this->AlternateArriveViaMothership = $this->getBool($hex, 0x065);
        $this->AlternateDepartureMothership = $this->getByte($hex, 0x066);
        $this->AlternateDepartViaMothership = $this->getBool($hex, 0x067);
        $this->Orders = [];
        $offset = 0x068;
        for ($i = 0; $i < 3; $i++) {
            $t = new Order(substr($hex, $offset), $this->TIE);
            $this->Orders[] = $t;
            $offset += $t->getLength();
        }
        $this->FlightGroupGoals = [];
        $offset = 0x09E;
        for ($i = 0; $i < 4; $i++) {
            $t = new GoalFG(substr($hex, $offset), $this->TIE);
            $this->FlightGroupGoals[] = $t;
            $offset += $t->getLength();
        }
        $this->BonusGoalPoints = $this->getSByte($hex, 0x0A6);
        $this->Waypoints = [];
        $offset = 0x0A8;
        for ($i = 0; $i < 4; $i++) {
            $t = new Waypt(substr($hex, $offset), $this->TIE);
            $this->Waypoints[] = $t;
            $offset += $t->getLength();
        }
        $this->Unknown19 = $this->getBool($hex, 0x120);
        $this->Unknown20 = $this->getByte($hex, 0x122);
        $this->Unknown21 = $this->getBool($hex, 0x123);
        
    }
    
    public function __debugInfo()
    {
        return [
            "Name" => $this->Name,
            "Pilot" => $this->Pilot,
            "Cargo" => $this->Cargo,
            "SpecialCargo" => $this->SpecialCargo,
            "SpecialCargoCraft" => $this->SpecialCargoCraft,
            "RandomSpecialCargoCraft" => $this->RandomSpecialCargoCraft,
            "CraftType" => $this->getCraftTypeLabel(),
            "NumberOfCraft" => $this->NumberOfCraft,
            "Status" => $this->getStatusLabel(),
            "Warhead" => $this->getWarheadLabel(),
            "Beam" => $this->getBeamLabel(),
            "Iff" => $this->Iff,
            "GroupAI" => $this->getGroupAILabel(),
            "Markings" => $this->getMarkingsLabel(),
            "ObeyPlayerOrders" => $this->ObeyPlayerOrders,
            "Formation" => $this->getFormationLabel(),
            "FormationSpacing" => $this->FormationSpacing,
            "GlobalGroup" => $this->GlobalGroup,
            "LeaderSpacing" => $this->LeaderSpacing,
            "NumberOfWaves" => $this->NumberOfWaves,
            "Unknown5" => $this->Unknown5,
            "PlayerCraft" => $this->PlayerCraft,
            "Yaw" => $this->Yaw,
            "Pitch" => $this->Pitch,
            "Roll" => $this->Roll,
            "Unknown9" => $this->Unknown9,
            "Unknown10" => $this->Unknown10,
            "ArrivalDifficulty" => $this->getArrivalDifficultyLabel(),
            "Arrival1" => $this->Arrival1,
            "Arrival2" => $this->Arrival2,
            "Arrival1OrArrival2" => $this->Arrival1OrArrival2,
            "ArrivalDelayMinutes" => $this->ArrivalDelayMinutes,
            "ArrivalDelaySeconds" => $this->ArrivalDelaySeconds,
            "Departure" => $this->Departure,
            "DepartureDelayMinutes" => $this->DepartureDelayMinutes,
            "DepartureDelatSeconds" => $this->DepartureDelatSeconds,
            "AbortTrigger" => $this->getAbortTriggerLabel(),
            "Unknown16" => $this->Unknown16,
            "ArrivalMothership" => $this->ArrivalMothership,
            "ArriveViaMothership" => $this->ArriveViaMothership,
            "DepartureMothership" => $this->DepartureMothership,
            "DepartViaMothership" => $this->DepartViaMothership,
            "AlternateArrivalMothership" => $this->AlternateArrivalMothership,
            "AlternateArriveViaMothership" => $this->AlternateArriveViaMothership,
            "AlternateDepartureMothership" => $this->AlternateDepartureMothership,
            "AlternateDepartViaMothership" => $this->AlternateDepartViaMothership,
            "Orders" => $this->Orders,
            "FlightGroupGoals" => $this->FlightGroupGoals,
            "BonusGoalPoints" => $this->BonusGoalPoints,
            "Waypoints" => $this->Waypoints,
            "Unknown19" => $this->Unknown19,
            "Unknown20" => $this->Unknown20,
            "Unknown21" => $this->Unknown21
        ];
    }
    
    public function toHexString()
    {
        $hex = "";
        $offset = 0;

        $this->writeChar($hex, $this->Name, 0x000);
        $this->writeChar($hex, $this->Pilot, 0x00C);
        $this->writeChar($hex, $this->Cargo, 0x018);
        $this->writeChar($hex, $this->SpecialCargo, 0x024);
        $this->writeByte($hex, $this->SpecialCargoCraft, 0x030);
        $this->writeBool($hex, $this->RandomSpecialCargoCraft, 0x031);
        $this->writeByte($hex, $this->CraftType, 0x032);
        $this->writeByte($hex, $this->NumberOfCraft, 0x033);
        $this->writeByte($hex, $this->Status, 0x034);
        $this->writeByte($hex, $this->Warhead, 0x035);
        $this->writeByte($hex, $this->Beam, 0x036);
        $this->writeByte($hex, $this->Iff, 0x037);
        $this->writeByte($hex, $this->GroupAI, 0x038);
        $this->writeByte($hex, $this->Markings, 0x039);
        $this->writeBool($hex, $this->ObeyPlayerOrders, 0x03A);
        $this->writeByte($hex, 0, 0x03B);
        $this->writeByte($hex, $this->Formation, 0x03C);
        $this->writeByte($hex, $this->FormationSpacing, 0x03D);
        $this->writeByte($hex, $this->GlobalGroup, 0x03E);
        $this->writeByte($hex, $this->LeaderSpacing, 0x03F);
        $this->writeByte($hex, $this->NumberOfWaves, 0x040);
        $this->writeByte($hex, $this->Unknown5, 0x041);
        $this->writeByte($hex, $this->PlayerCraft, 0x042);
        $this->writeByte($hex, $this->Yaw, 0x043);
        $this->writeByte($hex, $this->Pitch, 0x044);
        $this->writeByte($hex, $this->Roll, 0x045);
        $this->writeBool($hex, $this->Unknown9, 0x046);
        $this->writeByte($hex, $this->Unknown10, 0x047);
        $this->writeByte($hex, 0, 0x048);
        $this->writeByte($hex, $this->ArrivalDifficulty, 0x049);
        $this->writeObject($hex, $this->Arrival1, 0x04A);
        $this->writeObject($hex, $this->Arrival2, 0x04E);
        $this->writeBool($hex, $this->Arrival1OrArrival2, 0x052);
        $this->writeByte($hex, 0, 0x053);
        $this->writeByte($hex, $this->ArrivalDelayMinutes, 0x054);
        $this->writeByte($hex, $this->ArrivalDelaySeconds, 0x055);
        $this->writeObject($hex, $this->Departure, 0x056);
        $this->writeByte($hex, $this->DepartureDelayMinutes, 0x05A);
        $this->writeByte($hex, $this->DepartureDelatSeconds, 0x05B);
        $this->writeByte($hex, $this->AbortTrigger, 0x05C);
        $this->writeByte($hex, 0, 0x05D);
        $this->writeByte($hex, $this->Unknown16, 0x05E);
        $this->writeByte($hex, 0, 0x05F);
        $this->writeByte($hex, $this->ArrivalMothership, 0x060);
        $this->writeBool($hex, $this->ArriveViaMothership, 0x061);
        $this->writeByte($hex, $this->DepartureMothership, 0x062);
        $this->writeBool($hex, $this->DepartViaMothership, 0x063);
        $this->writeByte($hex, $this->AlternateArrivalMothership, 0x064);
        $this->writeBool($hex, $this->AlternateArriveViaMothership, 0x065);
        $this->writeByte($hex, $this->AlternateDepartureMothership, 0x066);
        $this->writeBool($hex, $this->AlternateDepartViaMothership, 0x067);
        $offset = 0x068;
        for ($i = 0; $i < 3; $i++) {
            $t = $this->Orders[$i];
            $this->writeObject($hex, $t, $offset);
            $offset += $t->getLength();
        }
        $offset = 0x09E;
        for ($i = 0; $i < 4; $i++) {
            $t = $this->FlightGroupGoals[$i];
            $this->writeObject($hex, $t, $offset);
            $offset += $t->getLength();
        }
        $this->writeSByte($hex, $this->BonusGoalPoints, 0x0A6);
        $offset = 0x0A8;
        for ($i = 0; $i < 4; $i++) {
            $t = $this->Waypoints[$i];
            $this->writeObject($hex, $t, $offset);
            $offset += $t->getLength();
        }
        $this->writeBool($hex, $this->Unknown19, 0x120);
        $this->writeByte($hex, $this->Unknown20, 0x122);
        $this->writeBool($hex, $this->Unknown21, 0x123);

        return $hex;
    }
    
    public function getCraftTypeLabel() {
        return isset($this->CraftType) && isset(Constants::$CRAFTTYPE[$this->CraftType]) ? Constants::$CRAFTTYPE[$this->CraftType] : "Unknown";
    }

    public function getStatusLabel() {
        return isset($this->Status) && isset(Constants::$STATUS[$this->Status]) ? Constants::$STATUS[$this->Status] : "Unknown";
    }

    public function getWarheadLabel() {
        return isset($this->Warhead) && isset(Constants::$WARHEAD[$this->Warhead]) ? Constants::$WARHEAD[$this->Warhead] : "Unknown";
    }

    public function getBeamLabel() {
        return isset($this->Beam) && isset(Constants::$BEAM[$this->Beam]) ? Constants::$BEAM[$this->Beam] : "Unknown";
    }

    public function getGroupAILabel() {
        return isset($this->GroupAI) && isset(Constants::$GROUPAI[$this->GroupAI]) ? Constants::$GROUPAI[$this->GroupAI] : "Unknown";
    }

    public function getMarkingsLabel() {
        return isset($this->Markings) && isset(Constants::$MARKINGS[$this->Markings]) ? Constants::$MARKINGS[$this->Markings] : "Unknown";
    }

    public function getFormationLabel() {
        return isset($this->Formation) && isset(Constants::$FORMATION[$this->Formation]) ? Constants::$FORMATION[$this->Formation] : "Unknown";
    }

    public function getArrivalDifficultyLabel() {
        return isset($this->ArrivalDifficulty) && isset(Constants::$ARRIVALDIFFICULTY[$this->ArrivalDifficulty]) ? Constants::$ARRIVALDIFFICULTY[$this->ArrivalDifficulty] : "Unknown";
    }

    public function getAbortTriggerLabel() {
        return isset($this->AbortTrigger) && isset(Constants::$ABORTTRIGGER[$this->AbortTrigger]) ? Constants::$ABORTTRIGGER[$this->AbortTrigger] : "Unknown";
    }
    
    public function getLength()
    {
        return self::FLIGHTGROUPLENGTH;
    }
}