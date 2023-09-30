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
    /** @var string[] 0x000 Name CHAR */
    public $Name; //(ignored?)
    /** @var string[] 0x010 Cargo CHAR */
    public $Cargo; //(ignored?)
    /** @var string[] 0x020 SpecialCargo CHAR */
    public $SpecialCargo; //(ignored?)
    /** @var integer 0x030 SpecialCargoCraft SHORT */
    public $SpecialCargoCraft; //(ignored?)
    /** @var integer 0x032 CraftType SHORT */
    public $CraftType;
    /** @var integer 0x034 IFF SHORT */
    public $IFF;
    /** @var integer 0x036 ObjectFormation SHORT */
    public $ObjectFormation; //or values (unusual formatting)
    /** @var integer 0x038 NumberOfCraft SHORT */
    public $NumberOfCraft; //or values (unusual formatting)
    /** @var integer 0x03A X SHORT */
    public $X;
    /** @var integer 0x03C Y SHORT */
    public $Y;
    /** @var integer 0x03E Z SHORT */
    public $Z;
    /** @var integer 0x040 Yaw SHORT */
    public $Yaw;
    /** @var integer 0x042 Pitch SHORT */
    public $Pitch;
    /** @var integer 0x044 Roll SHORT */
    public $Roll;
    
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
        $this->ObjectFormation = $this->getShort($hex, 0x036);
        $this->NumberOfCraft = $this->getShort($hex, 0x038);
        $this->X = $this->getShort($hex, 0x03A);
        $this->Y = $this->getShort($hex, 0x03C);
        $this->Z = $this->getShort($hex, 0x03E);
        $this->Yaw = $this->getShort($hex, 0x040);
        $this->Pitch = $this->getShort($hex, 0x042);
        $this->Roll = $this->getShort($hex, 0x044);
        

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
            "ObjectFormation" => $this->getObjectFormationLabel(),
            "NumberOfCraft" => $this->NumberOfCraft,
            "X" => $this->X,
            "Y" => $this->Y,
            "Z" => $this->Z,
            "Yaw" => $this->Yaw,
            "Pitch" => $this->Pitch,
            "Roll" => $this->Roll
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
        $hex = $this->writeShort($this->ObjectFormation, $hex, 0x036);
        $hex = $this->writeShort($this->NumberOfCraft, $hex, 0x038);
        $hex = $this->writeShort($this->X, $hex, 0x03A);
        $hex = $this->writeShort($this->Y, $hex, 0x03C);
        $hex = $this->writeShort($this->Z, $hex, 0x03E);
        $hex = $this->writeShort($this->Yaw, $hex, 0x040);
        $hex = $this->writeShort($this->Pitch, $hex, 0x042);
        $hex = $this->writeShort($this->Roll, $hex, 0x044);

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

    public function getObjectFormationLabel() 
    {
        return isset($this->ObjectFormation) && isset(Constants::$OBJECTFORMATION[$this->ObjectFormation]) ? Constants::$OBJECTFORMATION[$this->ObjectFormation] : "Unknown";
    }
    
    public function getLength()
    {
        return self::OBJECTGROUPLENGTH;
    }
}