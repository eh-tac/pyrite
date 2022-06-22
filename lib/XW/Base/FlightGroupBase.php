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
    /** @var string 0x00 Name STR */
    public $Name;
    /** @var string 0x10 Cargo STR */
    public $Cargo;
    /** @var string 0x20 SpecialCargo STR */
    public $SpecialCargo;
    /** @var integer 0x30 SpecialCargoCraft SHORT */
    public $SpecialCargoCraft;
    /** @var integer 0x32 CraftType SHORT */
    public $CraftType;
    /** @var integer 0x34 IFF SHORT */
    public $IFF;
    /** @var integer 0x36 FlightGroupStatus SHORT */
    public $FlightGroupStatus;
    /** @var integer 0x38 NumberOfCraft SHORT */
    public $NumberOfCraft;
    /** @var integer 0x3A NumberOfWaves SHORT */
    public $NumberOfWaves;
    /** @var integer 0x3C ArrivalEvent SHORT */
    public $ArrivalEvent;
    /** @var integer 0x3E ArrivalDelay SHORT */
    public $ArrivalDelay;
    /** @var integer 0x40 ArrivalFlightGroup SHORT */
    public $ArrivalFlightGroup;
    /** @var integer 0x42 MothershipFlightGroup SHORT */
    public $MothershipFlightGroup;
    /** @var integer 0x44 ArriveByHyperspace SHORT */
    public $ArriveByHyperspace;
    /** @var integer 0x46 DepartByHyperspace SHORT */
    public $DepartByHyperspace;
    /** @var integer[] 0x48 XCoordinates SHORT */
    public $XCoordinates;
    /** @var integer[] 0x56 YCoordinates SHORT */
    public $YCoordinates;
    /** @var integer[] 0x64 ZCoordinates SHORT */
    public $ZCoordinates;
    /** @var integer[] 0x72 CoordinatesEnabled SHORT */
    public $CoordinatesEnabled;
    /** @var integer 0x80 Formation SHORT */
    public $Formation;
    /** @var integer 0x82 PlayerCraft SHORT */
    public $PlayerCraft;
    /** @var integer 0x84 CraftAI SHORT */
    public $CraftAI;
    /** @var integer 0x86 Order SHORT */
    public $Order;
    /** @var integer 0x88 OrderVariable SHORT */
    public $OrderVariable;
    /** @var integer 0x8A CraftColour SHORT */
    public $CraftColour;
    /** @var integer 0x8C Reserved SHORT */
    public const Reserved = 0;
    /** @var integer 0x8E CraftObjective SHORT */
    public $CraftObjective;
    /** @var integer 0x90 PrimaryTarget SHORT */
    public $PrimaryTarget;
    /** @var integer 0x92 SecondaryTarget SHORT */
    public $SecondaryTarget;
    
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

        $this->Name = $this->getString($hex, 0x00);
        $this->Cargo = $this->getString($hex, 0x10);
        $this->SpecialCargo = $this->getString($hex, 0x20);
        $this->SpecialCargoCraft = $this->getShort($hex, 0x30);
        $this->CraftType = $this->getShort($hex, 0x32);
        $this->IFF = $this->getShort($hex, 0x34);
        $this->FlightGroupStatus = $this->getShort($hex, 0x36);
        $this->NumberOfCraft = $this->getShort($hex, 0x38);
        $this->NumberOfWaves = $this->getShort($hex, 0x3A);
        $this->ArrivalEvent = $this->getShort($hex, 0x3C);
        $this->ArrivalDelay = $this->getShort($hex, 0x3E);
        $this->ArrivalFlightGroup = $this->getShort($hex, 0x40);
        $this->MothershipFlightGroup = $this->getShort($hex, 0x42);
        $this->ArriveByHyperspace = $this->getShort($hex, 0x44);
        $this->DepartByHyperspace = $this->getShort($hex, 0x46);
        $this->XCoordinates = [];
        $offset = 0x48;
        for ($i = 0; $i < 7; $i++) {
            $t = $this->getShort($hex, $offset);
            $this->XCoordinates[] = $t;
            $offset += 2;
        }
        $this->YCoordinates = [];
        $offset = 0x56;
        for ($i = 0; $i < 7; $i++) {
            $t = $this->getShort($hex, $offset);
            $this->YCoordinates[] = $t;
            $offset += 2;
        }
        $this->ZCoordinates = [];
        $offset = 0x64;
        for ($i = 0; $i < 7; $i++) {
            $t = $this->getShort($hex, $offset);
            $this->ZCoordinates[] = $t;
            $offset += 2;
        }
        $this->CoordinatesEnabled = [];
        $offset = 0x72;
        for ($i = 0; $i < 7; $i++) {
            $t = $this->getShort($hex, $offset);
            $this->CoordinatesEnabled[] = $t;
            $offset += 2;
        }
        $this->Formation = $this->getShort($hex, 0x80);
        $this->PlayerCraft = $this->getShort($hex, 0x82);
        $this->CraftAI = $this->getShort($hex, 0x84);
        $this->Order = $this->getShort($hex, 0x86);
        $this->OrderVariable = $this->getShort($hex, 0x88);
        $this->CraftColour = $this->getShort($hex, 0x8A);
        // static SHORT value Reserved = 0
        $this->CraftObjective = $this->getShort($hex, 0x8E);
        $this->PrimaryTarget = $this->getShort($hex, 0x90);
        $this->SecondaryTarget = $this->getShort($hex, 0x92);
        
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
            "ArrivalFlightGroup" => $this->ArrivalFlightGroup,
            "MothershipFlightGroup" => $this->MothershipFlightGroup,
            "ArriveByHyperspace" => $this->ArriveByHyperspace,
            "DepartByHyperspace" => $this->DepartByHyperspace,
            "XCoordinates" => $this->XCoordinates,
            "YCoordinates" => $this->YCoordinates,
            "ZCoordinates" => $this->ZCoordinates,
            "CoordinatesEnabled" => $this->CoordinatesEnabled,
            "Formation" => $this->getFormationLabel(),
            "PlayerCraft" => $this->PlayerCraft,
            "CraftAI" => $this->getCraftAILabel(),
            "Order" => $this->getOrderLabel(),
            "OrderVariable" => $this->OrderVariable,
            "CraftColour" => $this->getCraftColourLabel(),
            "CraftObjective" => $this->getCraftObjectiveLabel(),
            "PrimaryTarget" => $this->PrimaryTarget,
            "SecondaryTarget" => $this->SecondaryTarget
        ];
    }
    
    public function toHexString($hex = null)
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $hex = $this->writeString($this->Name, $hex, 0x00);
        $hex = $this->writeString($this->Cargo, $hex, 0x10);
        $hex = $this->writeString($this->SpecialCargo, $hex, 0x20);
        $hex = $this->writeShort($this->SpecialCargoCraft, $hex, 0x30);
        $hex = $this->writeShort($this->CraftType, $hex, 0x32);
        $hex = $this->writeShort($this->IFF, $hex, 0x34);
        $hex = $this->writeShort($this->FlightGroupStatus, $hex, 0x36);
        $hex = $this->writeShort($this->NumberOfCraft, $hex, 0x38);
        $hex = $this->writeShort($this->NumberOfWaves, $hex, 0x3A);
        $hex = $this->writeShort($this->ArrivalEvent, $hex, 0x3C);
        $hex = $this->writeShort($this->ArrivalDelay, $hex, 0x3E);
        $hex = $this->writeShort($this->ArrivalFlightGroup, $hex, 0x40);
        $hex = $this->writeShort($this->MothershipFlightGroup, $hex, 0x42);
        $hex = $this->writeShort($this->ArriveByHyperspace, $hex, 0x44);
        $hex = $this->writeShort($this->DepartByHyperspace, $hex, 0x46);
        $offset = 0x48;
        for ($i = 0; $i < 7; $i++) {
            $t = $this->XCoordinates[$i];
            $hex = $this->writeShort($t, $hex, $offset);
            $offset += 2;
        }
        $offset = 0x56;
        for ($i = 0; $i < 7; $i++) {
            $t = $this->YCoordinates[$i];
            $hex = $this->writeShort($t, $hex, $offset);
            $offset += 2;
        }
        $offset = 0x64;
        for ($i = 0; $i < 7; $i++) {
            $t = $this->ZCoordinates[$i];
            $hex = $this->writeShort($t, $hex, $offset);
            $offset += 2;
        }
        $offset = 0x72;
        for ($i = 0; $i < 7; $i++) {
            $t = $this->CoordinatesEnabled[$i];
            $hex = $this->writeShort($t, $hex, $offset);
            $offset += 2;
        }
        $hex = $this->writeShort($this->Formation, $hex, 0x80);
        $hex = $this->writeShort($this->PlayerCraft, $hex, 0x82);
        $hex = $this->writeShort($this->CraftAI, $hex, 0x84);
        $hex = $this->writeShort($this->Order, $hex, 0x86);
        $hex = $this->writeShort($this->OrderVariable, $hex, 0x88);
        $hex = $this->writeShort($this->CraftColour, $hex, 0x8A);
        $hex = $this->writeShort(0, $hex, 0x8C);
        $hex = $this->writeShort($this->CraftObjective, $hex, 0x8E);
        $hex = $this->writeShort($this->PrimaryTarget, $hex, 0x90);
        $hex = $this->writeShort($this->SecondaryTarget, $hex, 0x92);

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

    public function getCraftAILabel() 
    {
        return isset($this->CraftAI) && isset(Constants::$CRAFTAI[$this->CraftAI]) ? Constants::$CRAFTAI[$this->CraftAI] : "Unknown";
    }

    public function getOrderLabel() 
    {
        return isset($this->Order) && isset(Constants::$ORDER[$this->Order]) ? Constants::$ORDER[$this->Order] : "Unknown";
    }

    public function getCraftColourLabel() 
    {
        return isset($this->CraftColour) && isset(Constants::$CRAFTCOLOUR[$this->CraftColour]) ? Constants::$CRAFTCOLOUR[$this->CraftColour] : "Unknown";
    }

    public function getCraftObjectiveLabel() 
    {
        return isset($this->CraftObjective) && isset(Constants::$CRAFTOBJECTIVE[$this->CraftObjective]) ? Constants::$CRAFTOBJECTIVE[$this->CraftObjective] : "Unknown";
    }
    
    public function getLength()
    {
        return self::FLIGHTGROUPLENGTH;
    }
}