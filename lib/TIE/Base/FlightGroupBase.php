<?php

namespace Pyrite\TIE\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\PyriteBase;
use Pyrite\TIE\Constants;

abstract class FlightGroupBase extends PyriteBase implements Byteable
{
    use HexDecoder;

    const FLIGHTGROUP_LENGTH = 0x124;

    /** @var \Pyrite\TIE\CHAR<12> */
    public $Name;
    /** @var \Pyrite\TIE\CHAR<12> */
    public $Pilot;
    /** @var \Pyrite\TIE\CHAR<12> */
    public $Cargo;
    /** @var \Pyrite\TIE\CHAR<12> */
    public $SpecialCargo;
    /** @var \Pyrite\TIE\BYTE */
    public $SpecialCargoCraft;
    /** @var \Pyrite\TIE\BOOL */
    public $RandomSpecialCargoCraft;
    /** @var \Pyrite\TIE\BYTE */
    public $CraftType;
    /** @var \Pyrite\TIE\BYTE */
    public $NumberOfCraft;
    /** @var \Pyrite\TIE\BYTE */
    public $Status;
    /** @var \Pyrite\TIE\BYTE */
    public $Warhead;
    /** @var \Pyrite\TIE\BYTE */
    public $Beam;
    /** @var \Pyrite\TIE\BYTE */
    public $Iff;
    /** @var \Pyrite\TIE\BYTE */
    public $GroupAI;
    /** @var \Pyrite\TIE\BYTE */
    public $Markings;
    /** @var \Pyrite\TIE\BOOL */
    public $ObeyPlayerOrders;
    /** @var \Pyrite\TIE\BYTE */
    public $Reserved1; // (0)  Unknown1 in TFW
    /** @var \Pyrite\TIE\BYTE */
    public $Formation;
    /** @var \Pyrite\TIE\BYTE */
    public $FormationSpacing; // Unknown2
    /** @var \Pyrite\TIE\BYTE */
    public $GlobalGroup; // Unknown3
    /** @var \Pyrite\TIE\BYTE */
    public $LeaderSpacing; // Unknown4
    /** @var \Pyrite\TIE\BYTE */
    public $NumberOfWaves;
    /** @var \Pyrite\TIE\BYTE */
    public $Unknown5;
    /** @var \Pyrite\TIE\BYTE */
    public $PlayerCraft;
    /** @var \Pyrite\TIE\BYTE */
    public $Yaw; // Unknown6
    /** @var \Pyrite\TIE\BYTE */
    public $Pitch; // Unknown7
    /** @var \Pyrite\TIE\BYTE */
    public $Roll; // Unknown8
    /** @var \Pyrite\TIE\BOOL */
    public $Unknown9;
    /** @var \Pyrite\TIE\BYTE */
    public $Unknown10;
    /** @var \Pyrite\TIE\BYTE */
    public $Reserved2; // (0)  Unknown11
    /** @var \Pyrite\TIE\BYTE */
    public $ArrivalDifficulty;
    /** @var \Pyrite\TIE\Trigger */
    public $Arrival1;
    /** @var \Pyrite\TIE\Trigger */
    public $Arrival2;
    /** @var \Pyrite\TIE\BOOL */
    public $Arrival1OrArrival2;
    /** @var \Pyrite\TIE\BYTE */
    public $Reserved3; // (0)  Unknown12
    /** @var \Pyrite\TIE\BYTE */
    public $ArrivalDelayMinutes;
    /** @var \Pyrite\TIE\BYTE */
    public $ArrivalDelaySeconds;
    /** @var \Pyrite\TIE\Trigger */
    public $Departure;
    /** @var \Pyrite\TIE\BYTE */
    public $DepartureDelayMinutes; // Unknown13
    /** @var \Pyrite\TIE\BYTE */
    public $DepartureDelatSeconds; // Unknown14
    /** @var \Pyrite\TIE\BYTE */
    public $AbortTrigger;
    /** @var \Pyrite\TIE\BYTE */
    public $Reserved4; // (0)  Unknown15
    /** @var \Pyrite\TIE\BYTE */
    public $Unknown16;
    /** @var \Pyrite\TIE\BYTE */
    public $Reserved5; // (0)  Unknown17
    /** @var \Pyrite\TIE\BYTE */
    public $ArrivalMothership;
    /** @var \Pyrite\TIE\BOOL */
    public $ArriveViaMothership;
    /** @var \Pyrite\TIE\BYTE */
    public $DepartureMothership;
    /** @var \Pyrite\TIE\BOOL */
    public $DepartViaMothership;
    /** @var \Pyrite\TIE\BYTE */
    public $AlternateArrivalMothership;
    /** @var \Pyrite\TIE\BOOL */
    public $AlternateArriveViaMothership;
    /** @var \Pyrite\TIE\BYTE */
    public $AlternateDepartureMothership;
    /** @var \Pyrite\TIE\BOOL */
    public $AlternateDepartViaMothership;
    /** @var \Pyrite\TIE\Order */
    public $Orders;
    /** @var \Pyrite\TIE\GoalFG */
    public $FlightGroupGoals;
    /** @var \Pyrite\TIE\SBYTE */
    public $BonusGoalPoints;
    /** @var \Pyrite\TIE\Waypt */
    public $Waypoints;
    /** @var \Pyrite\TIE\BOOL */
    public $Unknown19;
    /** @var \Pyrite\TIE\BYTE */
    public $Unknown20;
    /** @var \Pyrite\TIE\BOOL */
    public $Unknown21;

    public function __construct($hex, $tie)
    {
        $this->hex = $hex;
        $this->TIE = $tie;
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
        $this->Reserved1 = $this->getByte($hex, 0x03B);
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
        $this->Reserved2 = $this->getByte($hex, 0x048);
        $this->ArrivalDifficulty = $this->getByte($hex, 0x049);
        $this->Arrival1 = new \Pyrite\TIE\Trigger(substr($hex, 0x04A), $this->TIE);
        $this->Arrival2 = new \Pyrite\TIE\Trigger(substr($hex, 0x04E), $this->TIE);
        $this->Arrival1OrArrival2 = $this->getBool($hex, 0x052);
        $this->Reserved3 = $this->getByte($hex, 0x053);
        $this->ArrivalDelayMinutes = $this->getByte($hex, 0x054);
        $this->ArrivalDelaySeconds = $this->getByte($hex, 0x055);
        $this->Departure = new \Pyrite\TIE\Trigger(substr($hex, 0x056), $this->TIE);
        $this->DepartureDelayMinutes = $this->getByte($hex, 0x05A);
        $this->DepartureDelatSeconds = $this->getByte($hex, 0x05B);
        $this->AbortTrigger = $this->getByte($hex, 0x05C);
        $this->Reserved4 = $this->getByte($hex, 0x05D);
        $this->Unknown16 = $this->getByte($hex, 0x05E);
        $this->Reserved5 = $this->getByte($hex, 0x05F);
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
            $t = new \Pyrite\TIE\Order(substr($hex, $offset), $this->TIE);
            $this->Orders[] = $t;
            $offset += $t->getLength();
        }

        $this->FlightGroupGoals = [];
        $offset = 0x09E;
        for ($i = 0; $i < 4; $i++) {
            $t = new \Pyrite\TIE\GoalFG(substr($hex, $offset), $this->TIE);
            $this->FlightGroupGoals[] = $t;
            $offset += $t->getLength();
        }
        $this->BonusGoalPoints = $this->getSByte($hex, 0x0A6);

        $this->Waypoints = [];
        $offset = 0x0A8;
        for ($i = 0; $i < 4; $i++) {
            $t = new \Pyrite\TIE\Waypt(substr($hex, $offset), $this->TIE);
            $this->Waypoints[] = $t;
            $offset += $t->getLength();
        }
        $this->Unknown19 = $this->getBool($hex, 0x120);
        $this->Unknown20 = $this->getByte($hex, 0x122);
        $this->Unknown21 = $this->getBool($hex, 0x123);
        $this->afterConstruct();
    }

    public function __debugInfo()
    {
        return [
            "Name"                         => $this->Name,
            "Pilot"                        => $this->Pilot,
            "Cargo"                        => $this->Cargo,
            "SpecialCargo"                 => $this->SpecialCargo,
            "SpecialCargoCraft"            => $this->SpecialCargoCraft,
            "RandomSpecialCargoCraft"      => $this->RandomSpecialCargoCraft,
            "CraftType"                    => $this->getCraftTypeLabel(),
            "NumberOfCraft"                => $this->NumberOfCraft,
            "Status"                       => $this->getStatusLabel(),
            "Warhead"                      => $this->getWarheadLabel(),
            "Beam"                         => $this->getBeamLabel(),
            "Iff"                          => $this->Iff,
            "GroupAI"                      => $this->getGroupAILabel(),
            "Markings"                     => $this->getMarkingsLabel(),
            "ObeyPlayerOrders"             => $this->ObeyPlayerOrders,
            "Reserved1"                    => $this->Reserved1,
            "Formation"                    => $this->getFormationLabel(),
            "FormationSpacing"             => $this->FormationSpacing,
            "GlobalGroup"                  => $this->GlobalGroup,
            "LeaderSpacing"                => $this->LeaderSpacing,
            "NumberOfWaves"                => $this->NumberOfWaves,
            "Unknown5"                     => $this->Unknown5,
            "PlayerCraft"                  => $this->PlayerCraft,
            "Yaw"                          => $this->Yaw,
            "Pitch"                        => $this->Pitch,
            "Roll"                         => $this->Roll,
            "Unknown9"                     => $this->Unknown9,
            "Unknown10"                    => $this->Unknown10,
            "Reserved2"                    => $this->Reserved2,
            "ArrivalDifficulty"            => $this->getArrivalDifficultyLabel(),
            "Arrival1"                     => $this->Arrival1,
            "Arrival2"                     => $this->Arrival2,
            "Arrival1OrArrival2"           => $this->Arrival1OrArrival2,
            "Reserved3"                    => $this->Reserved3,
            "ArrivalDelayMinutes"          => $this->ArrivalDelayMinutes,
            "ArrivalDelaySeconds"          => $this->ArrivalDelaySeconds,
            "Departure"                    => $this->Departure,
            "DepartureDelayMinutes"        => $this->DepartureDelayMinutes,
            "DepartureDelatSeconds"        => $this->DepartureDelatSeconds,
            "AbortTrigger"                 => $this->getAbortTriggerLabel(),
            "Reserved4"                    => $this->Reserved4,
            "Unknown16"                    => $this->Unknown16,
            "Reserved5"                    => $this->Reserved5,
            "ArrivalMothership"            => $this->ArrivalMothership,
            "ArriveViaMothership"          => $this->ArriveViaMothership,
            "DepartureMothership"          => $this->DepartureMothership,
            "DepartViaMothership"          => $this->DepartViaMothership,
            "AlternateArrivalMothership"   => $this->AlternateArrivalMothership,
            "AlternateArriveViaMothership" => $this->AlternateArriveViaMothership,
            "AlternateDepartureMothership" => $this->AlternateDepartureMothership,
            "AlternateDepartViaMothership" => $this->AlternateDepartViaMothership,
            "Orders"                       => $this->Orders,
            "FlightGroupGoals"             => $this->FlightGroupGoals,
            "BonusGoalPoints"              => $this->BonusGoalPoints,
            "Waypoints"                    => $this->Waypoints,
            "Unknown19"                    => $this->Unknown19,
            "Unknown20"                    => $this->Unknown20,
            "Unknown21"                    => $this->Unknown21
        ];
    }

    protected function getCraftTypeLabel()
    {
        return isset($this->CraftType) && isset(Constants::$CRAFTTYPE[$this->CraftType]) ? Constants::$CRAFTTYPE[$this->CraftType] : "Unknown";
    }

    protected function getStatusLabel()
    {
        return isset($this->Status) && isset(Constants::$STATUS[$this->Status]) ? Constants::$STATUS[$this->Status] : "Unknown";
    }

    protected function getWarheadLabel()
    {
        return isset($this->Warhead) && isset(Constants::$WARHEAD[$this->Warhead]) ? Constants::$WARHEAD[$this->Warhead] : "Unknown";
    }

    protected function getBeamLabel()
    {
        return isset($this->Beam) && isset(Constants::$BEAM[$this->Beam]) ? Constants::$BEAM[$this->Beam] : "Unknown";
    }

    protected function getGroupAILabel()
    {
        return isset($this->GroupAI) && isset(Constants::$GROUPAI[$this->GroupAI]) ? Constants::$GROUPAI[$this->GroupAI] : "Unknown";
    }

    protected function getMarkingsLabel()
    {
        return isset($this->Markings) && isset(Constants::$MARKINGS[$this->Markings]) ? Constants::$MARKINGS[$this->Markings] : "Unknown";
    }

    protected function getFormationLabel()
    {
        return isset($this->Formation) && isset(Constants::$FORMATION[$this->Formation]) ? Constants::$FORMATION[$this->Formation] : "Unknown";
    }

    protected function getArrivalDifficultyLabel()
    {
        return isset($this->ArrivalDifficulty) && isset(Constants::$ARRIVALDIFFICULTY[$this->ArrivalDifficulty]) ? Constants::$ARRIVALDIFFICULTY[$this->ArrivalDifficulty] : "Unknown";
    }

    protected function getAbortTriggerLabel()
    {
        return isset($this->AbortTrigger) && isset(Constants::$ABORTTRIGGER[$this->AbortTrigger]) ? Constants::$ABORTTRIGGER[$this->AbortTrigger] : "Unknown";
    }

    protected function toHexString()
    {

        $hex = "";

        $offset = 0;
        $this->writeChar($hex, $this->Name, 0x000, 12);
        $this->writeChar($hex, $this->Pilot, 0x00C, 12);
        $this->writeChar($hex, $this->Cargo, 0x018, 12);
        $this->writeChar($hex, $this->SpecialCargo, 0x024, 12);
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
        $this->writeByte($hex, $this->Reserved1, 0x03B);
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
        $this->writeByte($hex, $this->Reserved2, 0x048);
        $this->writeByte($hex, $this->ArrivalDifficulty, 0x049);
        $this->writeObject($hex, $this->Arrival1, 0x04A);
        $this->writeObject($hex, $this->Arrival2, 0x04E);
        $this->writeBool($hex, $this->Arrival1OrArrival2, 0x052);
        $this->writeByte($hex, $this->Reserved3, 0x053);
        $this->writeByte($hex, $this->ArrivalDelayMinutes, 0x054);
        $this->writeByte($hex, $this->ArrivalDelaySeconds, 0x055);
        $this->writeObject($hex, $this->Departure, 0x056);
        $this->writeByte($hex, $this->DepartureDelayMinutes, 0x05A);
        $this->writeByte($hex, $this->DepartureDelatSeconds, 0x05B);
        $this->writeByte($hex, $this->AbortTrigger, 0x05C);
        $this->writeByte($hex, $this->Reserved4, 0x05D);
        $this->writeByte($hex, $this->Unknown16, 0x05E);
        $this->writeByte($hex, $this->Reserved5, 0x05F);
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
            $this->writeObject($hex, $this->Orders[$i], $offset);
            $offset += $t->getLength();
        }

        $offset = 0x09E;
        for ($i = 0; $i < 4; $i++) {
            $t = $this->FlightGroupGoals[$i];
            $this->writeObject($hex, $this->FlightGroupGoals[$i], $offset);
            $offset += $t->getLength();
        }
        $this->writeSByte($hex, $this->BonusGoalPoints, 0x0A6);

        $offset = 0x0A8;
        for ($i = 0; $i < 4; $i++) {
            $t = $this->Waypoints[$i];
            $this->writeObject($hex, $this->Waypoints[$i], $offset);
            $offset += $t->getLength();
        }
        $this->writeBool($hex, $this->Unknown19, 0x120);
        $this->writeByte($hex, $this->Unknown20, 0x122);
        $this->writeBool($hex, $this->Unknown21, 0x123);
        return $hex;
    }


    public function getLength()
    {
        return self::FLIGHTGROUP_LENGTH;
    }
}