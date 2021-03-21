<?php

namespace Pyrite\XW\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\PyriteBase;
use Pyrite\XW\Constants;

abstract class ObjectGroupBase extends PyriteBase implements Byteable
{
    use HexDecoder;

    /** @var integer */
    public const OBJECTGROUPLENGTH = 70;
    /** @var string */
    public $Name;
    /** @var string */
    public $Cargo;
    /** @var string */
    public $SpecialCargo;
    /** @var integer */
    public const Reserved = 0;
    /** @var integer */
    public $ObjectType;
    /** @var integer */
    public $IFF;
    /** @var integer */
    public $Objective;
    /** @var integer */
    public $NumberOfObjects;
    /** @var integer */
    public $PositionX;
    /** @var integer */
    public $PositionY;
    /** @var integer */
    public $PositionZ;
    /** @var integer */
    public const Unknown1 = 0;
    /** @var integer */
    public const Unknown2 = 64;
    /** @var integer */
    public const Unknown3 = 0;
    
    public function __construct($hex, $tie = null)
    {
        parent::__construct($hex, $tie);
        $this->beforeConstruct();
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
        
    }
    
    public function __debugInfo()
    {
        return [
            "Name" => $this->Name,
            "Cargo" => $this->Cargo,
            "SpecialCargo" => $this->SpecialCargo,
            "ObjectType" => $this->ObjectType,
            "IFF" => $this->getIFFLabel(),
            "Objective" => $this->Objective,
            "NumberOfObjects" => $this->NumberOfObjects,
            "PositionX" => $this->PositionX,
            "PositionY" => $this->PositionY,
            "PositionZ" => $this->PositionZ
        ];
    }
    
    public function toHexString()
    {
        $hex = "";
        $offset = 0;

        $this->writeString($hex, $this->Name, 0x00);
        $this->writeString($hex, $this->Cargo, 0x10);
        $this->writeString($hex, $this->SpecialCargo, 0x20);
        $this->writeShort($hex, 0, 0x30);
        $this->writeShort($hex, $this->ObjectType, 0x32);
        $this->writeShort($hex, $this->IFF, 0x34);
        $this->writeShort($hex, $this->Objective, 0x36);
        $this->writeShort($hex, $this->NumberOfObjects, 0x38);
        $this->writeShort($hex, $this->PositionX, 0x3A);
        $this->writeShort($hex, $this->PositionY, 0x3C);
        $this->writeShort($hex, $this->PositionZ, 0x3E);
        $this->writeShort($hex, 0, 0x40);
        $this->writeShort($hex, 64, 0x42);
        $this->writeShort($hex, 0, 0x44);

        return $hex;
    }
    
    public function getIFFLabel() {
        return isset($this->IFF) && isset(Constants::$IFF[$this->IFF]) ? Constants::$IFF[$this->IFF] : "Unknown";
    }
    
    public function getLength()
    {
        return self::OBJECTGROUPLENGTH;
    }
}