<?php

namespace Pyrite\XW\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;
use Pyrite\PyriteModel;
use Pyrite\XW\Constants;

abstract class FlightGroupBase extends PyriteBase implements Byteable, PyriteModel
{
    use HexDecoder;
    use HexEncoder;

    /** @var int FLIGHTGROUPLENGTH INT */
	public const FLIGHTGROUPLENGTH = 148;
    /** @var string 0x000 Name CHAR */
	public string $Name;
    /** @var string 0x010 Cargo CHAR */
	public string $Cargo;
    /** @var string 0x020 SpecialCargo CHAR */
	public string $SpecialCargo;
    /** @var int 0x030 SpecialCargoCraft SHORT */
	public int $SpecialCargoCraft;
    /** @var int 0x032 CraftType SHORT */
	public int $CraftType;
    /** @var int 0x034 IFF SHORT */
	public int $IFF;
    /** @var int 0x036 FlightGroupStatus SHORT */
	public int $FlightGroupStatus; // (unusual formatting)
    /** @var int 0x038 NumberOfCraft SHORT */
	public int $NumberOfCraft;
    /** @var int 0x03A NumberOfWaves SHORT */
	public int $NumberOfWaves;
    /** @var int 0x03C ArrivalEvent SHORT */
	public int $ArrivalEvent;
    /** @var int 0x03E ArrivalDelay SHORT */
	public int $ArrivalDelay; // (unusual formatting)
    /** @var int 0x040 ArrivalFG SHORT */
	public int $ArrivalFG; // (-1 for none)
    /** @var int 0x042 Mothership SHORT */
	public int $Mothership; // (-1 for none)
    /** @var int 0x044 ArrivalHyperspace SHORT */
	public int $ArrivalHyperspace;
    /** @var int 0x046 DepartureHyperspace SHORT */
	public int $DepartureHyperspace;
    /** @var array<int> 0x048 WaypointX SHORT */
	public array $WaypointX;
    /** @var array<int> 0x056 WaypointY SHORT */
	public array $WaypointY;
    /** @var array<int> 0x064 WaypointZ SHORT */
	public array $WaypointZ;
    /** @var array<int> 0x072 WaypointEnabled SHORT */
	public array $WaypointEnabled;
    /** @var int 0x080 Formation SHORT */
	public int $Formation;
    /** @var int 0x082 PlayerCraft SHORT */
	public int $PlayerCraft;
    /** @var int 0x084 GroupAI SHORT */
	public int $GroupAI;
    /** @var int 0x086 Order SHORT */
	public int $Order;
    /** @var int 0x088 OrderValue SHORT */
	public int $OrderValue; // (dock time or throttle)
    /** @var int 0x08C Markings SHORT */
	public int $Markings;
    /** @var int 0x08E Objective SHORT */
	public int $Objective;
    /** @var int 0x090 TargetPrimary SHORT */
	public int $TargetPrimary; // (-1 for none)
    /** @var int 0x092 TargetSecondary SHORT */
	public int $TargetSecondary; // (-1 for none)
    
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

        $this->Name = $this->getChar($hex, 0x000, 16);
        $this->Cargo = $this->getChar($hex, 0x010, 16);
        $this->SpecialCargo = $this->getChar($hex, 0x020, 16);
        $this->SpecialCargoCraft = $this->getShort($hex, 0x030);
        $this->CraftType = $this->getShort($hex, 0x032);
        $this->IFF = $this->getShort($hex, 0x034);
        $this->FlightGroupStatus = $this->getShort($hex, 0x036);
        $this->NumberOfCraft = $this->getShort($hex, 0x038);
        $this->NumberOfWaves = $this->getShort($hex, 0x03A);
        $this->ArrivalEvent = $this->getShort($hex, 0x03C);
        $this->ArrivalDelay = $this->getShort($hex, 0x03E);
        $this->ArrivalFG = $this->getShort($hex, 0x040);
        $this->Mothership = $this->getShort($hex, 0x042);
        $this->ArrivalHyperspace = $this->getShort($hex, 0x044);
        $this->DepartureHyperspace = $this->getShort($hex, 0x046);
        $this->WaypointX = [];
        $offset = 0x048;
        for ($i = 0; $i < 7; $i++) {
            $t = $this->getShort($hex, $offset);
            $this->WaypointX[] = $t;
            $offset += 2;
        }
        $this->WaypointY = [];
        $offset = 0x056;
        for ($i = 0; $i < 7; $i++) {
            $t = $this->getShort($hex, $offset);
            $this->WaypointY[] = $t;
            $offset += 2;
        }
        $this->WaypointZ = [];
        $offset = 0x064;
        for ($i = 0; $i < 7; $i++) {
            $t = $this->getShort($hex, $offset);
            $this->WaypointZ[] = $t;
            $offset += 2;
        }
        $this->WaypointEnabled = [];
        $offset = 0x072;
        for ($i = 0; $i < 7; $i++) {
            $t = $this->getShort($hex, $offset);
            $this->WaypointEnabled[] = $t;
            $offset += 2;
        }
        $this->Formation = $this->getShort($hex, 0x080);
        $this->PlayerCraft = $this->getShort($hex, 0x082);
        $this->GroupAI = $this->getShort($hex, 0x084);
        $this->Order = $this->getShort($hex, 0x086);
        $this->OrderValue = $this->getShort($hex, 0x088);
        $this->Markings = $this->getShort($hex, 0x08C);
        $this->Objective = $this->getShort($hex, 0x08E);
        $this->TargetPrimary = $this->getShort($hex, 0x090);
        $this->TargetSecondary = $this->getShort($hex, 0x092);
        

        $this->hex = substr($this->hex, 0, $this->getLength());
        return $this;
    }
    
    public function __debugInfo(): array
    {
        return [
            "Name" => $this->Name,
            "Cargo" => $this->Cargo,
            "SpecialCargo" => $this->SpecialCargo,
            "SpecialCargoCraft" => $this->SpecialCargoCraft,
            "CraftType" => $this->getCraftTypeLabel(),
            "IFF" => $this->getIFFLabel(),
            "FlightGroupStatus" => $this->getFlightGroupStatusLabel(),
            "NumberOfCraft" => $this->NumberOfCraft,
            "NumberOfWaves" => $this->NumberOfWaves,
            "ArrivalEvent" => $this->getArrivalEventLabel(),
            "ArrivalDelay" => $this->ArrivalDelay,
            "ArrivalFG" => $this->ArrivalFG,
            "Mothership" => $this->Mothership,
            "ArrivalHyperspace" => $this->ArrivalHyperspace,
            "DepartureHyperspace" => $this->DepartureHyperspace,
            "WaypointX" => $this->WaypointX,
            "WaypointY" => $this->WaypointY,
            "WaypointZ" => $this->WaypointZ,
            "WaypointEnabled" => $this->WaypointEnabled,
            "Formation" => $this->getFormationLabel(),
            "PlayerCraft" => $this->PlayerCraft,
            "GroupAI" => $this->getGroupAILabel(),
            "Order" => $this->getOrderLabel(),
            "OrderValue" => $this->OrderValue,
            "Markings" => $this->getMarkingsLabel(),
            "Objective" => $this->getObjectiveLabel(),
            "TargetPrimary" => $this->TargetPrimary,
            "TargetSecondary" => $this->TargetSecondary
        ];
    }
    
    public function toHexString($hex = null): string
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $hex = $this->writeChar($this->Name, $hex, 0x000);
        $hex = $this->writeChar($this->Cargo, $hex, 0x010);
        $hex = $this->writeChar($this->SpecialCargo, $hex, 0x020);
        $hex = $this->writeShort($this->SpecialCargoCraft, $hex, 0x030);
        $hex = $this->writeShort($this->CraftType, $hex, 0x032);
        $hex = $this->writeShort($this->IFF, $hex, 0x034);
        $hex = $this->writeShort($this->FlightGroupStatus, $hex, 0x036);
        $hex = $this->writeShort($this->NumberOfCraft, $hex, 0x038);
        $hex = $this->writeShort($this->NumberOfWaves, $hex, 0x03A);
        $hex = $this->writeShort($this->ArrivalEvent, $hex, 0x03C);
        $hex = $this->writeShort($this->ArrivalDelay, $hex, 0x03E);
        $hex = $this->writeShort($this->ArrivalFG, $hex, 0x040);
        $hex = $this->writeShort($this->Mothership, $hex, 0x042);
        $hex = $this->writeShort($this->ArrivalHyperspace, $hex, 0x044);
        $hex = $this->writeShort($this->DepartureHyperspace, $hex, 0x046);
        $offset = 0x048;
        for ($i = 0; $i < 7; $i++) {
            $t = $this->WaypointX[$i];
            $hex = $this->writeShort($t, $hex, $offset);
            $offset += 2;
        }
        $offset = 0x056;
        for ($i = 0; $i < 7; $i++) {
            $t = $this->WaypointY[$i];
            $hex = $this->writeShort($t, $hex, $offset);
            $offset += 2;
        }
        $offset = 0x064;
        for ($i = 0; $i < 7; $i++) {
            $t = $this->WaypointZ[$i];
            $hex = $this->writeShort($t, $hex, $offset);
            $offset += 2;
        }
        $offset = 0x072;
        for ($i = 0; $i < 7; $i++) {
            $t = $this->WaypointEnabled[$i];
            $hex = $this->writeShort($t, $hex, $offset);
            $offset += 2;
        }
        $hex = $this->writeShort($this->Formation, $hex, 0x080);
        $hex = $this->writeShort($this->PlayerCraft, $hex, 0x082);
        $hex = $this->writeShort($this->GroupAI, $hex, 0x084);
        $hex = $this->writeShort($this->Order, $hex, 0x086);
        $hex = $this->writeShort($this->OrderValue, $hex, 0x088);
        $hex = $this->writeShort($this->Markings, $hex, 0x08C);
        $hex = $this->writeShort($this->Objective, $hex, 0x08E);
        $hex = $this->writeShort($this->TargetPrimary, $hex, 0x090);
        $hex = $this->writeShort($this->TargetSecondary, $hex, 0x092);

        return $hex;
    }
    
    public function getCraftTypeLabel(): string 
    {
        return isset($this->CraftType) && isset(Constants::$CRAFTTYPE[$this->CraftType]) ? Constants::$CRAFTTYPE[$this->CraftType] : "Unknown";
    }

    public function getIFFLabel(): string 
    {
        return isset($this->IFF) && isset(Constants::$IFF[$this->IFF]) ? Constants::$IFF[$this->IFF] : "Unknown";
    }

    public function getFlightGroupStatusLabel(): string 
    {
        return isset($this->FlightGroupStatus) && isset(Constants::$FLIGHTGROUPSTATUS[$this->FlightGroupStatus]) ? Constants::$FLIGHTGROUPSTATUS[$this->FlightGroupStatus] : "Unknown";
    }

    public function getArrivalEventLabel(): string 
    {
        return isset($this->ArrivalEvent) && isset(Constants::$ARRIVALEVENT[$this->ArrivalEvent]) ? Constants::$ARRIVALEVENT[$this->ArrivalEvent] : "Unknown";
    }

    public function getFormationLabel(): string 
    {
        return isset($this->Formation) && isset(Constants::$FORMATION[$this->Formation]) ? Constants::$FORMATION[$this->Formation] : "Unknown";
    }

    public function getGroupAILabel(): string 
    {
        return isset($this->GroupAI) && isset(Constants::$GROUPAI[$this->GroupAI]) ? Constants::$GROUPAI[$this->GroupAI] : "Unknown";
    }

    public function getOrderLabel(): string 
    {
        return isset($this->Order) && isset(Constants::$ORDER[$this->Order]) ? Constants::$ORDER[$this->Order] : "Unknown";
    }

    public function getMarkingsLabel(): string 
    {
        return isset($this->Markings) && isset(Constants::$MARKINGS[$this->Markings]) ? Constants::$MARKINGS[$this->Markings] : "Unknown";
    }

    public function getObjectiveLabel(): string 
    {
        return isset($this->Objective) && isset(Constants::$OBJECTIVE[$this->Objective]) ? Constants::$OBJECTIVE[$this->Objective] : "Unknown";
    }
    
    public function getLength(): int
    {
        return self::FLIGHTGROUPLENGTH;
    }
}