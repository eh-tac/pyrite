<?php

namespace Pyrite\XW\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;
use Pyrite\XW\Constants;

abstract class ObjectGroupBase extends PyriteBase implements Byteable
{
    use HexDecoder;
    use HexEncoder;

    /** @var integer  OBJECTGROUPLENGTH INT */
    public const OBJECTGROUPLENGTH = 70;
    /** @var string 0x00 Name STR */
    public $Name;
    /** @var string 0x10 Cargo STR */
    public $Cargo;
    /** @var string 0x20 SpecialCargo STR */
    public $SpecialCargo;
    /** @var integer 0x30 Reserved SHORT */
    public const Reserved = 0;
    /** @var integer 0x32 ObjectType SHORT */
    public $ObjectType;
    /** @var integer 0x34 IFF SHORT */
    public $IFF;
    /** @var integer 0x36 Objective SHORT */
    public $Objective;
    /** @var integer 0x38 NumberOfObjects SHORT */
    public $NumberOfObjects;
    /** @var integer 0x3A PositionX SHORT */
    public $PositionX;
    /** @var integer 0x3C PositionY SHORT */
    public $PositionY;
    /** @var integer 0x3E PositionZ SHORT */
    public $PositionZ;
    /** @var integer 0x40 Unknown1 SHORT */
    public const Unknown1 = 0;
    /** @var integer 0x42 Unknown2 SHORT */
    public const Unknown2 = 64;
    /** @var integer 0x44 Unknown3 SHORT */
    public const Unknown3 = 0;
    
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
        // static SHORT value Reserved = 0
        $this->ObjectType = $this->getShort($hex, 0x32);
        $this->IFF = $this->getShort($hex, 0x34);
        $this->Objective = $this->getShort($hex, 0x36);
        $this->NumberOfObjects = $this->getShort($hex, 0x38);
        $this->PositionX = $this->getShort($hex, 0x3A);
        $this->PositionY = $this->getShort($hex, 0x3C);
        $this->PositionZ = $this->getShort($hex, 0x3E);
        // static SHORT value Unknown1 = 0
        // static SHORT value Unknown2 = 64
        // static SHORT value Unknown3 = 0
        
        return $this;
    }
    
    public function __debugInfo()
    {
        return [
            "Name" => $this->Name,
            "Cargo" => $this->Cargo,
            "SpecialCargo" => $this->SpecialCargo,
            "ObjectType" => $this->getObjectTypeLabel(),
            "IFF" => $this->getIFFLabel(),
            "Objective" => $this->getObjectiveLabel(),
            "NumberOfObjects" => $this->NumberOfObjects,
            "PositionX" => $this->PositionX,
            "PositionY" => $this->PositionY,
            "PositionZ" => $this->PositionZ
        ];
    }
    
    public function toHexString($hex = null)
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $hex = $this->writeString($this->Name, $hex, 0x00);
        $hex = $this->writeString($this->Cargo, $hex, 0x10);
        $hex = $this->writeString($this->SpecialCargo, $hex, 0x20);
        $hex = $this->writeShort(0, $hex, 0x30);
        $hex = $this->writeShort($this->ObjectType, $hex, 0x32);
        $hex = $this->writeShort($this->IFF, $hex, 0x34);
        $hex = $this->writeShort($this->Objective, $hex, 0x36);
        $hex = $this->writeShort($this->NumberOfObjects, $hex, 0x38);
        $hex = $this->writeShort($this->PositionX, $hex, 0x3A);
        $hex = $this->writeShort($this->PositionY, $hex, 0x3C);
        $hex = $this->writeShort($this->PositionZ, $hex, 0x3E);
        $hex = $this->writeShort(0, $hex, 0x40);
        $hex = $this->writeShort(64, $hex, 0x42);
        $hex = $this->writeShort(0, $hex, 0x44);

        return $hex;
    }
    
    public function getObjectTypeLabel() 
    {
        return isset($this->ObjectType) && isset(Constants::$OBJECTTYPE[$this->ObjectType]) ? Constants::$OBJECTTYPE[$this->ObjectType] : "Unknown";
    }

    public function getIFFLabel() 
    {
        return isset($this->IFF) && isset(Constants::$IFF[$this->IFF]) ? Constants::$IFF[$this->IFF] : "Unknown";
    }

    public function getObjectiveLabel() 
    {
        return isset($this->Objective) && isset(Constants::$OBJECTIVE[$this->Objective]) ? Constants::$OBJECTIVE[$this->Objective] : "Unknown";
    }
    
    public function getLength()
    {
        return self::OBJECTGROUPLENGTH;
    }
}