<?php

namespace Pyrite\TIE\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;
use Pyrite\PyriteModel;
use Pyrite\TIE\Constants;
use Pyrite\TIE\GoalFG;
use Pyrite\TIE\Order;
use Pyrite\TIE\Trigger;
use Pyrite\TIE\Waypt;

abstract class FlightGroupBase extends PyriteBase implements Byteable, PyriteModel
{
    use HexDecoder;
    use HexEncoder;

    /** @var int FLIGHTGROUPLENGTH INT */
	public const FLIGHTGROUPLENGTH = 292;
    /** @var string 0x000 Name CHAR */
	public string $Name;
    /** @var string 0x00C Pilot CHAR */
	public string $Pilot;
    /** @var string 0x018 Cargo CHAR */
	public string $Cargo;
    /** @var string 0x024 SpecialCargo CHAR */
	public string $SpecialCargo;
    /** @var int 0x030 SpecialCargoCraft BYTE */
	public int $SpecialCargoCraft;
    /** @var bool 0x031 RandomSpecialCargoCraft BOOL */
	public bool $RandomSpecialCargoCraft;
    /** @var int 0x032 CraftType BYTE */
	public int $CraftType;
    /** @var int 0x033 NumberOfCraft BYTE */
	public int $NumberOfCraft;
    /** @var int 0x034 Status BYTE */
	public int $Status;
    /** @var int 0x035 Warhead BYTE */
	public int $Warhead;
    /** @var int 0x036 Beam BYTE */
	public int $Beam;
    /** @var int 0x037 Iff BYTE */
	public int $Iff;
    /** @var int 0x038 GroupAI BYTE */
	public int $GroupAI;
    /** @var int 0x039 Markings BYTE */
	public int $Markings;
    /** @var bool 0x03A ObeyPlayerOrders BOOL */
	public bool $ObeyPlayerOrders;
    /** @var int 0x03B Reserved1 BYTE */
	public const Reserved1 = 0; // Unknown1 in TFW
    /** @var int 0x03C Formation BYTE */
	public int $Formation;
    /** @var int 0x03D FormationSpacing BYTE */
	public int $FormationSpacing; // Unknown2
    /** @var int 0x03E GlobalGroup BYTE */
	public int $GlobalGroup; // Unknown3
    /** @var int 0x03F LeaderSpacing BYTE */
	public int $LeaderSpacing; // Unknown4
    /** @var int 0x040 NumberOfWaves BYTE */
	public int $NumberOfWaves;
    /** @var int 0x041 Unknown5 BYTE */
	public int $Unknown5;
    /** @var int 0x042 PlayerCraft BYTE */
	public int $PlayerCraft;
    /** @var int 0x043 Yaw BYTE */
	public int $Yaw; // Unknown6
    /** @var int 0x044 Pitch BYTE */
	public int $Pitch; // Unknown7
    /** @var int 0x045 Roll BYTE */
	public int $Roll; // Unknown8
    /** @var bool 0x046 Unknown9 BOOL */
	public bool $Unknown9;
    /** @var int 0x047 Unknown10 BYTE */
	public int $Unknown10;
    /** @var int 0x048 Reserved2 BYTE */
	public const Reserved2 = 0; // Unknown11
    /** @var int 0x049 ArrivalDifficulty BYTE */
	public int $ArrivalDifficulty;
    /** @var Trigger 0x04A Arrival1 Trigger */
	public Trigger $Arrival1;
    /** @var Trigger 0x04E Arrival2 Trigger */
	public Trigger $Arrival2;
    /** @var bool 0x052 Arrival1OrArrival2 BOOL */
	public bool $Arrival1OrArrival2;
    /** @var int 0x053 Reserved3 BYTE */
	public const Reserved3 = 0; // Unknown12
    /** @var int 0x054 ArrivalDelayMinutes BYTE */
	public int $ArrivalDelayMinutes;
    /** @var int 0x055 ArrivalDelaySeconds BYTE */
	public int $ArrivalDelaySeconds;
    /** @var Trigger 0x056 Departure Trigger */
	public Trigger $Departure;
    /** @var int 0x05A DepartureDelayMinutes BYTE */
	public int $DepartureDelayMinutes; // Unknown13
    /** @var int 0x05B DepartureDelatSeconds BYTE */
	public int $DepartureDelatSeconds; // Unknown14
    /** @var int 0x05C AbortTrigger BYTE */
	public int $AbortTrigger;
    /** @var int 0x05D Reserved4 BYTE */
	public const Reserved4 = 0; // Unknown15
    /** @var int 0x05E Unknown16 BYTE */
	public int $Unknown16;
    /** @var int 0x05F Reserved5 BYTE */
	public const Reserved5 = 0; // Unknown17
    /** @var int 0x060 ArrivalMothership BYTE */
	public int $ArrivalMothership;
    /** @var bool 0x061 ArriveViaMothership BOOL */
	public bool $ArriveViaMothership;
    /** @var int 0x062 DepartureMothership BYTE */
	public int $DepartureMothership;
    /** @var bool 0x063 DepartViaMothership BOOL */
	public bool $DepartViaMothership;
    /** @var int 0x064 AlternateArrivalMothership BYTE */
	public int $AlternateArrivalMothership;
    /** @var bool 0x065 AlternateArriveViaMothership BOOL */
	public bool $AlternateArriveViaMothership;
    /** @var int 0x066 AlternateDepartureMothership BYTE */
	public int $AlternateDepartureMothership;
    /** @var bool 0x067 AlternateDepartViaMothership BOOL */
	public bool $AlternateDepartViaMothership;
    /** @var array<Order> 0x068 Orders Order */
	public array $Orders;
    /** @var array<GoalFG> 0x09E FlightGroupGoals GoalFG */
	public array $FlightGroupGoals;
    /** @var int 0x0A6 BonusGoalPoints SBYTE */
	public int $BonusGoalPoints;
    /** @var array<Waypt> 0x0A8 Waypoints Waypt */
	public array $Waypoints;
    /** @var bool 0x120 Unknown19 BOOL */
	public bool $Unknown19;
    /** @var int 0x122 Unknown20 BYTE */
	public int $Unknown20;
    /** @var bool 0x123 Unknown21 BOOL */
	public bool $Unknown21;
    
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
        $this->Arrival1 = (new Trigger(substr($hex, 0x04A), $this->TIE))->loadHex();
        $this->Arrival2 = (new Trigger(substr($hex, 0x04E), $this->TIE))->loadHex();
        $this->Arrival1OrArrival2 = $this->getBool($hex, 0x052);
        // static BYTE value Reserved3 = 0
        $this->ArrivalDelayMinutes = $this->getByte($hex, 0x054);
        $this->ArrivalDelaySeconds = $this->getByte($hex, 0x055);
        $this->Departure = (new Trigger(substr($hex, 0x056), $this->TIE))->loadHex();
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
            $t = (new Order(substr($hex, $offset), $this->TIE))->loadHex();
            $this->Orders[] = $t;
            $offset += $t->getLength();
        }
        $this->FlightGroupGoals = [];
        $offset = 0x09E;
        for ($i = 0; $i < 4; $i++) {
            $t = (new GoalFG(substr($hex, $offset), $this->TIE))->loadHex();
            $this->FlightGroupGoals[] = $t;
            $offset += $t->getLength();
        }
        $this->BonusGoalPoints = $this->getSByte($hex, 0x0A6);
        $this->Waypoints = [];
        $offset = 0x0A8;
        for ($i = 0; $i < 4; $i++) {
            $t = (new Waypt(substr($hex, $offset), $this->TIE))->loadHex();
            $this->Waypoints[] = $t;
            $offset += $t->getLength();
        }
        $this->Unknown19 = $this->getBool($hex, 0x120);
        $this->Unknown20 = $this->getByte($hex, 0x122);
        $this->Unknown21 = $this->getBool($hex, 0x123);
        

        $this->hex = substr($this->hex, 0, $this->getLength());
        $this->afterLoadHex();
        return $this;
    }
    
    public function __debugInfo(): array
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
    
    public function toHexString($hex = null): string
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $hex = $this->writeChar($this->Name, $hex, 0x000);
        $hex = $this->writeChar($this->Pilot, $hex, 0x00C);
        $hex = $this->writeChar($this->Cargo, $hex, 0x018);
        $hex = $this->writeChar($this->SpecialCargo, $hex, 0x024);
        $hex = $this->writeByte($this->SpecialCargoCraft, $hex, 0x030);
        $hex = $this->writeBool($this->RandomSpecialCargoCraft, $hex, 0x031);
        $hex = $this->writeByte($this->CraftType, $hex, 0x032);
        $hex = $this->writeByte($this->NumberOfCraft, $hex, 0x033);
        $hex = $this->writeByte($this->Status, $hex, 0x034);
        $hex = $this->writeByte($this->Warhead, $hex, 0x035);
        $hex = $this->writeByte($this->Beam, $hex, 0x036);
        $hex = $this->writeByte($this->Iff, $hex, 0x037);
        $hex = $this->writeByte($this->GroupAI, $hex, 0x038);
        $hex = $this->writeByte($this->Markings, $hex, 0x039);
        $hex = $this->writeBool($this->ObeyPlayerOrders, $hex, 0x03A);
        $hex = $this->writeByte(0, $hex, 0x03B);
        $hex = $this->writeByte($this->Formation, $hex, 0x03C);
        $hex = $this->writeByte($this->FormationSpacing, $hex, 0x03D);
        $hex = $this->writeByte($this->GlobalGroup, $hex, 0x03E);
        $hex = $this->writeByte($this->LeaderSpacing, $hex, 0x03F);
        $hex = $this->writeByte($this->NumberOfWaves, $hex, 0x040);
        $hex = $this->writeByte($this->Unknown5, $hex, 0x041);
        $hex = $this->writeByte($this->PlayerCraft, $hex, 0x042);
        $hex = $this->writeByte($this->Yaw, $hex, 0x043);
        $hex = $this->writeByte($this->Pitch, $hex, 0x044);
        $hex = $this->writeByte($this->Roll, $hex, 0x045);
        $hex = $this->writeBool($this->Unknown9, $hex, 0x046);
        $hex = $this->writeByte($this->Unknown10, $hex, 0x047);
        $hex = $this->writeByte(0, $hex, 0x048);
        $hex = $this->writeByte($this->ArrivalDifficulty, $hex, 0x049);
        $hex = $this->writeObject($this->Arrival1, $hex, 0x04A);
        $hex = $this->writeObject($this->Arrival2, $hex, 0x04E);
        $hex = $this->writeBool($this->Arrival1OrArrival2, $hex, 0x052);
        $hex = $this->writeByte(0, $hex, 0x053);
        $hex = $this->writeByte($this->ArrivalDelayMinutes, $hex, 0x054);
        $hex = $this->writeByte($this->ArrivalDelaySeconds, $hex, 0x055);
        $hex = $this->writeObject($this->Departure, $hex, 0x056);
        $hex = $this->writeByte($this->DepartureDelayMinutes, $hex, 0x05A);
        $hex = $this->writeByte($this->DepartureDelatSeconds, $hex, 0x05B);
        $hex = $this->writeByte($this->AbortTrigger, $hex, 0x05C);
        $hex = $this->writeByte(0, $hex, 0x05D);
        $hex = $this->writeByte($this->Unknown16, $hex, 0x05E);
        $hex = $this->writeByte(0, $hex, 0x05F);
        $hex = $this->writeByte($this->ArrivalMothership, $hex, 0x060);
        $hex = $this->writeBool($this->ArriveViaMothership, $hex, 0x061);
        $hex = $this->writeByte($this->DepartureMothership, $hex, 0x062);
        $hex = $this->writeBool($this->DepartViaMothership, $hex, 0x063);
        $hex = $this->writeByte($this->AlternateArrivalMothership, $hex, 0x064);
        $hex = $this->writeBool($this->AlternateArriveViaMothership, $hex, 0x065);
        $hex = $this->writeByte($this->AlternateDepartureMothership, $hex, 0x066);
        $hex = $this->writeBool($this->AlternateDepartViaMothership, $hex, 0x067);
        $offset = 0x068;
        for ($i = 0; $i < 3; $i++) {
            $t = $this->Orders[$i];
            $hex = $this->writeObject($t, $hex, $offset);
            $offset += $t->getLength();
        }
        $offset = 0x09E;
        for ($i = 0; $i < 4; $i++) {
            $t = $this->FlightGroupGoals[$i];
            $hex = $this->writeObject($t, $hex, $offset);
            $offset += $t->getLength();
        }
        $hex = $this->writeSByte($this->BonusGoalPoints, $hex, 0x0A6);
        $offset = 0x0A8;
        for ($i = 0; $i < 4; $i++) {
            $t = $this->Waypoints[$i];
            $hex = $this->writeObject($t, $hex, $offset);
            $offset += $t->getLength();
        }
        $hex = $this->writeBool($this->Unknown19, $hex, 0x120);
        $hex = $this->writeByte($this->Unknown20, $hex, 0x122);
        $hex = $this->writeBool($this->Unknown21, $hex, 0x123);

        return $hex;
    }
    
    public function getCraftTypeLabel(): string 
    {
        return isset($this->CraftType) && isset(Constants::$CRAFTTYPE[$this->CraftType]) ? Constants::$CRAFTTYPE[$this->CraftType] : "Unknown";
    }

    public function getStatusLabel(): string 
    {
        return isset($this->Status) && isset(Constants::$STATUS[$this->Status]) ? Constants::$STATUS[$this->Status] : "Unknown";
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

    public function getFormationLabel(): string 
    {
        return isset($this->Formation) && isset(Constants::$FORMATION[$this->Formation]) ? Constants::$FORMATION[$this->Formation] : "Unknown";
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