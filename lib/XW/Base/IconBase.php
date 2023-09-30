<?php

namespace Pyrite\XW\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;

abstract class IconBase extends PyriteBase implements Byteable
{
    use HexDecoder;
    use HexEncoder;

    /** @var integer  ICONLENGTH INT */
    public const ICONLENGTH = 64;
    /** @var integer 0x000 CraftType SHORT */
    public $CraftType;
    /** @var integer 0x002 IFF SHORT */
    public $IFF;
    /** @var integer 0x004 NumberOfCraft SHORT */
    public $NumberOfCraft;
    /** @var integer 0x006 NumberOfWaves SHORT */
    public $NumberOfWaves;
    /** @var string[] 0x008 Name CHAR */
    public $Name;
    /** @var string[] 0x018 Cargo CHAR */
    public $Cargo;
    /** @var string[] 0x028 SpecialCargo CHAR */
    public $SpecialCargo;
    /** @var integer 0x038 SpecialCargoCraft SHORT */
    public $SpecialCargoCraft;
    /** @var integer 0x03A Yaw SHORT */
    public $Yaw;
    /** @var integer 0x03C Pitch SHORT */
    public $Pitch;
    /** @var integer 0x03E Roll SHORT */
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

        $this->CraftType = $this->getShort($hex, 0x000);
        $this->IFF = $this->getShort($hex, 0x002);
        $this->NumberOfCraft = $this->getShort($hex, 0x004);
        $this->NumberOfWaves = $this->getShort($hex, 0x006);
        $this->Name = [];
        $offset = 0x008;
        for ($i = 0; $i < 16; $i++) {
            $t = $this->getChar($hex, $offset, 1);
            $this->Name[] = $t;
            $offset += 1;
        }
        $this->Cargo = [];
        $offset = 0x018;
        for ($i = 0; $i < 16; $i++) {
            $t = $this->getChar($hex, $offset, 1);
            $this->Cargo[] = $t;
            $offset += 1;
        }
        $this->SpecialCargo = [];
        $offset = 0x028;
        for ($i = 0; $i < 16; $i++) {
            $t = $this->getChar($hex, $offset, 1);
            $this->SpecialCargo[] = $t;
            $offset += 1;
        }
        $this->SpecialCargoCraft = $this->getShort($hex, 0x038);
        $this->Yaw = $this->getShort($hex, 0x03A);
        $this->Pitch = $this->getShort($hex, 0x03C);
        $this->Roll = $this->getShort($hex, 0x03E);
        

        $this->hex = substr($this->hex, 0, $this->getLength());
        return $this;
    }
    
    public function __debugInfo()
    {
        return [
            "CraftType" => $this->CraftType,
            "IFF" => $this->IFF,
            "NumberOfCraft" => $this->NumberOfCraft,
            "NumberOfWaves" => $this->NumberOfWaves,
            "Name" => $this->Name,
            "Cargo" => $this->Cargo,
            "SpecialCargo" => $this->SpecialCargo,
            "SpecialCargoCraft" => $this->SpecialCargoCraft,
            "Yaw" => $this->Yaw,
            "Pitch" => $this->Pitch,
            "Roll" => $this->Roll
        ];
    }
    
    public function toHexString($hex = null)
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $hex = $this->writeShort($this->CraftType, $hex, 0x000);
        $hex = $this->writeShort($this->IFF, $hex, 0x002);
        $hex = $this->writeShort($this->NumberOfCraft, $hex, 0x004);
        $hex = $this->writeShort($this->NumberOfWaves, $hex, 0x006);
        $offset = 0x008;
        for ($i = 0; $i < 16; $i++) {
            $t = $this->Name[$i];
            $hex = $this->writeChar($t, $hex, $offset);
            $offset += 1;
        }
        $offset = 0x018;
        for ($i = 0; $i < 16; $i++) {
            $t = $this->Cargo[$i];
            $hex = $this->writeChar($t, $hex, $offset);
            $offset += 1;
        }
        $offset = 0x028;
        for ($i = 0; $i < 16; $i++) {
            $t = $this->SpecialCargo[$i];
            $hex = $this->writeChar($t, $hex, $offset);
            $offset += 1;
        }
        $hex = $this->writeShort($this->SpecialCargoCraft, $hex, 0x038);
        $hex = $this->writeShort($this->Yaw, $hex, 0x03A);
        $hex = $this->writeShort($this->Pitch, $hex, 0x03C);
        $hex = $this->writeShort($this->Roll, $hex, 0x03E);

        return $hex;
    }
    
    
    public function getLength()
    {
        return self::ICONLENGTH;
    }
}