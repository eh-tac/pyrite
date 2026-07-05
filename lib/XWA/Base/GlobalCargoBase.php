<?php

namespace Pyrite\XWA\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;
use Pyrite\PyriteModel;

abstract class GlobalCargoBase extends PyriteBase implements Byteable, PyriteModel
{
    use HexDecoder;
    use HexEncoder;

    /** @var int GLOBALCARGOLENGTH INT */
	public const GLOBALCARGOLENGTH = 140;
    /** @var string 0x00 Cargo STR */
	public string $Cargo;
    /** @var int 0x40 ID INT */
	public int $ID;
    /** @var int 0x44 Count INT */
	public int $Count; // (was Unknown1)
    /** @var int 0x48 Type BYTE */
	public int $Type; // (was Unknown2) {solid, liquid, gas}
    /** @var int 0x49 Volume BYTE */
	public int $Volume; // (was Unknown3)
    /** @var int 0x4A Value BYTE */
	public int $Value; // (was Unknown4)
    /** @var int 0x4B Volatility BYTE */
	public int $Volatility; // (was Unknown5) {low, med, high, kaboom!}
    
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

        $this->Cargo = $this->getString($hex, 0x00);
        $this->ID = $this->getInt($hex, 0x40);
        $this->Count = $this->getInt($hex, 0x44);
        $this->Type = $this->getByte($hex, 0x48);
        $this->Volume = $this->getByte($hex, 0x49);
        $this->Value = $this->getByte($hex, 0x4A);
        $this->Volatility = $this->getByte($hex, 0x4B);
        

        $this->hex = substr($this->hex, 0, $this->getLength());
        return $this;
    }
    
    public function __debugInfo(): array
    {
        return [
            "Cargo" => $this->Cargo,
            "ID" => $this->ID,
            "Count" => $this->Count,
            "Type" => $this->Type,
            "Volume" => $this->Volume,
            "Value" => $this->Value,
            "Volatility" => $this->Volatility
        ];
    }
    
    public function toHexString($hex = null): string
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $hex = $this->writeString($this->Cargo, $hex, 0x00);
        $hex = $this->writeInt($this->ID, $hex, 0x40);
        $hex = $this->writeInt($this->Count, $hex, 0x44);
        $hex = $this->writeByte($this->Type, $hex, 0x48);
        $hex = $this->writeByte($this->Volume, $hex, 0x49);
        $hex = $this->writeByte($this->Value, $hex, 0x4A);
        $hex = $this->writeByte($this->Volatility, $hex, 0x4B);

        return $hex;
    }
    
    
    public function getLength(): int
    {
        return self::GLOBALCARGOLENGTH;
    }
}