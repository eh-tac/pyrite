<?php

namespace Pyrite\XW\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\PyriteBase;
use Pyrite\XW\Constants;

abstract class FlightGroupBase extends PyriteBase implements Byteable
{
    use HexDecoder;

    /** @var integer */
    public const FLIGHTGROUPLENGTH = 148;
    /** @var string */
    public $Name;
    /** @var string */
    public $Cargo;
    /** @var string */
    public $SpecialCargo;
    /** @var integer */
    public $SpecialCargoCraft;
    /** @var integer */
    public $CraftType;
    /** @var integer */
    public $IFF;
    /** @var integer */
    public $FlightGroupStatus;
    /** @var integer */
    public $NumberOfCraft;
    /** @var integer */
    public $NumberOfWaves;
    /** @var integer */
    public $ArrivalEvent;
    /** @var integer */
    public $ArrivalDelay;
    /** @var integer */
    public $ArrivalFlightGroup;
    /** @var integer */
    public $MothershipFlightGroup;
    /** @var integer */
    public $ArriveByHyperspace;
    /** @var integer */
    public $DepartByHyperspace;
    /** @var integer[] */
    public $XCoordinates;
    /** @var integer[] */
    public $YCoordinates;
    /** @var integer[] */
    public $ZCoordinates;
    /** @var integer[] */
    public $CoordinatesEnabled;
    /** @var integer */
    public $Formation;
    /** @var integer */
    public $PlayerCraft;
    /** @var integer */
    public $CraftAI;
    /** @var integer */
    public $Order;
    /** @var integer */
    public $OrderVariable;
    /** @var integer */
    public $CraftColour;
    /** @var integer */
    public const Reserved = 0;
    /** @var integer */
    public $CraftObjective;
    /** @var integer */
    public $PrimaryTarget;
    /** @var integer */
    public $SecondaryTarget;
    
    public function __construct($hex, $tie = null)
    {
        parent::__construct($hex, $tie);
        $this->beforeConstruct();
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
    
    public function toHexString()
    {
        $hex = "";
        $offset = 0;

        $this->writeString($hex, $this->Name, 0x00);
        $this->writeString($hex, $this->Cargo, 0x10);
        $this->writeString($hex, $this->SpecialCargo, 0x20);
        $this->writeShort($hex, $this->SpecialCargoCraft, 0x30);
        $this->writeShort($hex, $this->CraftType, 0x32);
        $this->writeShort($hex, $this->IFF, 0x34);
        $this->writeShort($hex, $this->FlightGroupStatus, 0x36);
        $this->writeShort($hex, $this->NumberOfCraft, 0x38);
        $this->writeShort($hex, $this->NumberOfWaves, 0x3A);
        $this->writeShort($hex, $this->ArrivalEvent, 0x3C);
        $this->writeShort($hex, $this->ArrivalDelay, 0x3E);
        $this->writeShort($hex, $this->ArrivalFlightGroup, 0x40);
        $this->writeShort($hex, $this->MothershipFlightGroup, 0x42);
        $this->writeShort($hex, $this->ArriveByHyperspace, 0x44);
        $this->writeShort($hex, $this->DepartByHyperspace, 0x46);
        $offset = 0x48;
        for ($i = 0; $i < 7; $i++) {
            $t = $this->XCoordinates[$i];
            $this->writeShort($hex, $t, $offset);
            $offset += 2;
        }
        $offset = 0x56;
        for ($i = 0; $i < 7; $i++) {
            $t = $this->YCoordinates[$i];
            $this->writeShort($hex, $t, $offset);
            $offset += 2;
        }
        $offset = 0x64;
        for ($i = 0; $i < 7; $i++) {
            $t = $this->ZCoordinates[$i];
            $this->writeShort($hex, $t, $offset);
            $offset += 2;
        }
        $offset = 0x72;
        for ($i = 0; $i < 7; $i++) {
            $t = $this->CoordinatesEnabled[$i];
            $this->writeShort($hex, $t, $offset);
            $offset += 2;
        }
        $this->writeShort($hex, $this->Formation, 0x80);
        $this->writeShort($hex, $this->PlayerCraft, 0x82);
        $this->writeShort($hex, $this->CraftAI, 0x84);
        $this->writeShort($hex, $this->Order, 0x86);
        $this->writeShort($hex, $this->OrderVariable, 0x88);
        $this->writeShort($hex, $this->CraftColour, 0x8A);
        $this->writeShort($hex, 0, 0x8C);
        $this->writeShort($hex, $this->CraftObjective, 0x8E);
        $this->writeShort($hex, $this->PrimaryTarget, 0x90);
        $this->writeShort($hex, $this->SecondaryTarget, 0x92);

        return $hex;
    }
    
    public function getCraftTypeLabel() {
        return isset($this->CraftType) && isset(Constants::$CRAFTTYPE[$this->CraftType]) ? Constants::$CRAFTTYPE[$this->CraftType] : "Unknown";
    }

    public function getIFFLabel() {
        return isset($this->IFF) && isset(Constants::$IFF[$this->IFF]) ? Constants::$IFF[$this->IFF] : "Unknown";
    }

    public function getFlightGroupStatusLabel() {
        return isset($this->FlightGroupStatus) && isset(Constants::$FLIGHTGROUPSTATUS[$this->FlightGroupStatus]) ? Constants::$FLIGHTGROUPSTATUS[$this->FlightGroupStatus] : "Unknown";
    }

    public function getArrivalEventLabel() {
        return isset($this->ArrivalEvent) && isset(Constants::$ARRIVALEVENT[$this->ArrivalEvent]) ? Constants::$ARRIVALEVENT[$this->ArrivalEvent] : "Unknown";
    }

    public function getFormationLabel() {
        return isset($this->Formation) && isset(Constants::$FORMATION[$this->Formation]) ? Constants::$FORMATION[$this->Formation] : "Unknown";
    }

    public function getCraftAILabel() {
        return isset($this->CraftAI) && isset(Constants::$CRAFTAI[$this->CraftAI]) ? Constants::$CRAFTAI[$this->CraftAI] : "Unknown";
    }

    public function getOrderLabel() {
        return isset($this->Order) && isset(Constants::$ORDER[$this->Order]) ? Constants::$ORDER[$this->Order] : "Unknown";
    }

    public function getCraftColourLabel() {
        return isset($this->CraftColour) && isset(Constants::$CRAFTCOLOUR[$this->CraftColour]) ? Constants::$CRAFTCOLOUR[$this->CraftColour] : "Unknown";
    }

    public function getCraftObjectiveLabel() {
        return isset($this->CraftObjective) && isset(Constants::$CRAFTOBJECTIVE[$this->CraftObjective]) ? Constants::$CRAFTOBJECTIVE[$this->CraftObjective] : "Unknown";
    }
    
    public function getLength()
    {
        return self::FLIGHTGROUPLENGTH;
    }
}