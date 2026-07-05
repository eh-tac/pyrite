<?php

namespace Pyrite\XW\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;
use Pyrite\PyriteModel;
use Pyrite\XW\Constants;

abstract class ObjectGroupBase extends PyriteBase implements Byteable, PyriteModel
{
    use HexDecoder;
    use HexEncoder;

    /** @var int OBJECTGROUPLENGTH INT */
	public const OBJECTGROUPLENGTH = 70;
    /** @var string 0x000 Name CHAR */
	public string $Name; // (ignored?)
    /** @var string 0x010 Cargo CHAR */
	public string $Cargo; // (ignored?)
    /** @var string 0x020 SpecialCargo CHAR */
	public string $SpecialCargo; // (ignored?)
    /** @var int 0x030 SpecialCargoCraft SHORT */
	public int $SpecialCargoCraft; // (ignored?)
    /** @var int 0x032 CraftType SHORT */
	public int $CraftType;
    /** @var int 0x034 IFF SHORT */
	public int $IFF;
    /** @var int 0x036 ObjectFormation SHORT */
	public int $ObjectFormation; // or values (unusual formatting)
    /** @var int 0x038 NumberOfCraft SHORT */
	public int $NumberOfCraft; // or values (unusual formatting)
    /** @var int 0x03A X SHORT */
	public int $X;
    /** @var int 0x03C Y SHORT */
	public int $Y;
    /** @var int 0x03E Z SHORT */
	public int $Z;
    /** @var int 0x040 Yaw SHORT */
	public int $Yaw;
    /** @var int 0x042 Pitch SHORT */
	public int $Pitch;
    /** @var int 0x044 Roll SHORT */
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

        $this->Name = $this->getChar($hex, 0x000, 16);
        $this->Cargo = $this->getChar($hex, 0x010, 16);
        $this->SpecialCargo = $this->getChar($hex, 0x020, 16);
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
    
    public function __debugInfo(): array
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
    
    public function getCraftTypeLabel(): string 
    {
        return isset($this->CraftType) && isset(Constants::$CRAFTTYPE[$this->CraftType]) ? Constants::$CRAFTTYPE[$this->CraftType] : "Unknown";
    }

    public function getIFFLabel(): string 
    {
        return isset($this->IFF) && isset(Constants::$IFF[$this->IFF]) ? Constants::$IFF[$this->IFF] : "Unknown";
    }

    public function getObjectFormationLabel(): string 
    {
        return isset($this->ObjectFormation) && isset(Constants::$OBJECTFORMATION[$this->ObjectFormation]) ? Constants::$OBJECTFORMATION[$this->ObjectFormation] : "Unknown";
    }
    
    public function getLength(): int
    {
        return self::OBJECTGROUPLENGTH;
    }
}