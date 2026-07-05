<?php

namespace Pyrite\XW\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;
use Pyrite\PyriteModel;

abstract class IconBase extends PyriteBase implements Byteable, PyriteModel
{
    use HexDecoder;
    use HexEncoder;

    /** @var int ICONLENGTH INT */
	public const ICONLENGTH = 64;
    /** @var int 0x000 CraftType SHORT */
	public int $CraftType;
    /** @var int 0x002 IFF SHORT */
	public int $IFF;
    /** @var int 0x004 NumberOfCraft SHORT */
	public int $NumberOfCraft;
    /** @var int 0x006 NumberOfWaves SHORT */
	public int $NumberOfWaves;
    /** @var string 0x008 Name CHAR */
	public string $Name;
    /** @var string 0x018 Cargo CHAR */
	public string $Cargo;
    /** @var string 0x028 SpecialCargo CHAR */
	public string $SpecialCargo;
    /** @var int 0x038 SpecialCargoCraft SHORT */
	public int $SpecialCargoCraft;
    /** @var int 0x03A Yaw SHORT */
	public int $Yaw;
    /** @var int 0x03C Pitch SHORT */
	public int $Pitch;
    /** @var int 0x03E Roll SHORT */
	public int $Roll;
    
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

        $this->CraftType = $this->getShort($hex, 0x000);
        $this->IFF = $this->getShort($hex, 0x002);
        $this->NumberOfCraft = $this->getShort($hex, 0x004);
        $this->NumberOfWaves = $this->getShort($hex, 0x006);
        $this->Name = $this->getChar($hex, 0x008, 16);
        $this->Cargo = $this->getChar($hex, 0x018, 16);
        $this->SpecialCargo = $this->getChar($hex, 0x028, 16);
        $this->SpecialCargoCraft = $this->getShort($hex, 0x038);
        $this->Yaw = $this->getShort($hex, 0x03A);
        $this->Pitch = $this->getShort($hex, 0x03C);
        $this->Roll = $this->getShort($hex, 0x03E);
        

        $this->hex = substr($this->hex, 0, $this->getLength());
        return $this;
    }
    
    public function __debugInfo(): array
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
    
    public function toHexString($hex = null): string
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $hex = $this->writeShort($this->CraftType, $hex, 0x000);
        $hex = $this->writeShort($this->IFF, $hex, 0x002);
        $hex = $this->writeShort($this->NumberOfCraft, $hex, 0x004);
        $hex = $this->writeShort($this->NumberOfWaves, $hex, 0x006);
        $hex = $this->writeChar($this->Name, $hex, 0x008);
        $hex = $this->writeChar($this->Cargo, $hex, 0x018);
        $hex = $this->writeChar($this->SpecialCargo, $hex, 0x028);
        $hex = $this->writeShort($this->SpecialCargoCraft, $hex, 0x038);
        $hex = $this->writeShort($this->Yaw, $hex, 0x03A);
        $hex = $this->writeShort($this->Pitch, $hex, 0x03C);
        $hex = $this->writeShort($this->Roll, $hex, 0x03E);

        return $hex;
    }
    
    
    public function getLength(): int
    {
        return self::ICONLENGTH;
    }
}