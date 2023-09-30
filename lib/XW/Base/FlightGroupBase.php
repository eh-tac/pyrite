<?php

namespace Pyrite\XW\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;
use Pyrite\XW\Constants;

abstract class FlightGroupBase extends PyriteBase implements Byteable
{
    use HexDecoder;
    use HexEncoder;

    /** @var integer  FLIGHTGROUPLENGTH INT */
    public const FLIGHTGROUPLENGTH = 148;
    /** @var string[] 0x000 Name CHAR */
    public $Name;
    /** @var string[] 0x010 Cargo CHAR */
    public $Cargo;
    /** @var string[] 0x020 SpecialCargo CHAR */
    public $SpecialCargo;
    /** @var integer 0x030 SpecialCargoCraft SHORT */
    public $SpecialCargoCraft;
    /** @var integer 0x032 CraftType SHORT */
    public $CraftType;
    /** @var integer 0x034 IFF SHORT */
    public $IFF;
    /** @var integer 0x036 FlightGroupStatus SHORT */
    public $FlightGroupStatus; //(unusual formatting)
    /** @var integer 0x038 NumberOfCraft SHORT */
    public $NumberOfCraft;
    /** @var integer 0x03A NumberOfWaves SHORT */
    public $NumberOfWaves;
    /** @var integer 0x03C ArrivalEvent SHORT */
    public $ArrivalEvent;
    /** @var integer 0x03E ArrivalDelay SHORT */
    public $ArrivalDelay; //(unusual formatting)
    /** @var integer 0x040 ArrivalFG SHORT */
    public $ArrivalFG; //(-1 for none)
    /** @var integer 0x042 Mothership SHORT */
    public $Mothership; //(-1 for none)
    /** @var integer 0x044 ArrivalHyperspace SHORT */
    public $ArrivalHyperspace;
    /** @var integer 0x046 DepartureHyperspace SHORT */
    public $DepartureHyperspace;
    /** @var integer[] 0x072 Waypoint SHORT */
    public $Waypoint; //(Enabled)
    /** @var integer 0x080 Formation SHORT */
    public $Formation;
    /** @var integer 0x082 PlayerCraft SHORT */
    public $PlayerCraft;
    /** @var integer 0x084 GroupAI SHORT */
    public $GroupAI;
    /** @var integer 0x086 Order SHORT */
    public $Order;
    /** @var integer 0x088 OrderValue SHORT */
    public $OrderValue; //(dock time or throttle)
    /** @var integer 0x08C Markings SHORT */
    public $Markings;
    /** @var integer 0x08E Objective SHORT */
    public $Objective;
    /** @var integer 0x090 TargetPrimary SHORT */
    public $TargetPrimary; //(-1 for none)
    /** @var integer 0x092 TargetSecondary SHORT */
    public $TargetSecondary; //(-1 for none)
    
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

        $this->Name = [];
        $offset = 0x000;
        for ($i = 0; $i < 16; $i++) {
            $t = $this->getChar($hex, $offset, 1);
            $this->Name[] = $t;
            $offset += 1;
        }
        $this->Cargo = [];
        $offset = 0x010;
        for ($i = 0; $i < 16; $i++) {
            $t = $this->getChar($hex, $offset, 1);
            $this->Cargo[] = $t;
            $offset += 1;
        }
        $this->SpecialCargo = [];
        $offset = 0x020;
        for ($i = 0; $i < 16; $i++) {
            $t = $this->getChar($hex, $offset, 1);
            $this->SpecialCargo[] = $t;
            $offset += 1;
        }
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
        $this->Waypoint = [];
        $offset = 0x072;
        for ($i = 0; $i < 7; $i++) {
            $t = $this->getShort($hex, $offset);
            $this->Waypoint[] = $t;
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
    
    public function __debugInfo()
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
            "Waypoint" => $this->Waypoint,
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
    
    public function toHexString($hex = null)
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $offset = 0x000;
        for ($i = 0; $i < 16; $i++) {
            $t = $this->Name[$i];
            $hex = $this->writeChar($t, $hex, $offset);
            $offset += 1;
        }
        $offset = 0x010;
        for ($i = 0; $i < 16; $i++) {
            $t = $this->Cargo[$i];
            $hex = $this->writeChar($t, $hex, $offset);
            $offset += 1;
        }
        $offset = 0x020;
        for ($i = 0; $i < 16; $i++) {
            $t = $this->SpecialCargo[$i];
            $hex = $this->writeChar($t, $hex, $offset);
            $offset += 1;
        }
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
        $offset = 0x072;
        for ($i = 0; $i < 7; $i++) {
            $t = $this->Waypoint[$i];
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
    
    public function getCraftTypeLabel() 
    {
        return isset($this->CraftType) && isset(Constants::$CRAFTTYPE[$this->CraftType]) ? Constants::$CRAFTTYPE[$this->CraftType] : "Unknown";
    }

    public function getIFFLabel() 
    {
        return isset($this->IFF) && isset(Constants::$IFF[$this->IFF]) ? Constants::$IFF[$this->IFF] : "Unknown";
    }

    public function getFlightGroupStatusLabel() 
    {
        return isset($this->FlightGroupStatus) && isset(Constants::$FLIGHTGROUPSTATUS[$this->FlightGroupStatus]) ? Constants::$FLIGHTGROUPSTATUS[$this->FlightGroupStatus] : "Unknown";
    }

    public function getArrivalEventLabel() 
    {
        return isset($this->ArrivalEvent) && isset(Constants::$ARRIVALEVENT[$this->ArrivalEvent]) ? Constants::$ARRIVALEVENT[$this->ArrivalEvent] : "Unknown";
    }

    public function getFormationLabel() 
    {
        return isset($this->Formation) && isset(Constants::$FORMATION[$this->Formation]) ? Constants::$FORMATION[$this->Formation] : "Unknown";
    }

    public function getGroupAILabel() 
    {
        return isset($this->GroupAI) && isset(Constants::$GROUPAI[$this->GroupAI]) ? Constants::$GROUPAI[$this->GroupAI] : "Unknown";
    }

    public function getOrderLabel() 
    {
        return isset($this->Order) && isset(Constants::$ORDER[$this->Order]) ? Constants::$ORDER[$this->Order] : "Unknown";
    }

    public function getMarkingsLabel() 
    {
        return isset($this->Markings) && isset(Constants::$MARKINGS[$this->Markings]) ? Constants::$MARKINGS[$this->Markings] : "Unknown";
    }

    public function getObjectiveLabel() 
    {
        return isset($this->Objective) && isset(Constants::$OBJECTIVE[$this->Objective]) ? Constants::$OBJECTIVE[$this->Objective] : "Unknown";
    }
    
    public function getLength()
    {
        return self::FLIGHTGROUPLENGTH;
    }
}