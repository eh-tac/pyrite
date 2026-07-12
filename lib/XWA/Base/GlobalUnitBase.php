<?php

namespace Pyrite\XWA\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;
use Pyrite\PyriteModel;

abstract class GlobalUnitBase extends PyriteBase implements Byteable, PyriteModel
{
    use HexDecoder;
    use HexEncoder;

    /** @var int GLOBALUNITLENGTH INT */
	public const GLOBALUNITLENGTH = 87;
    /** @var string 0x00 Name STR */
	public string $Name;
    /** @var int 0x40 Leader BYTE */
	public int $Leader;
    /** @var int 0x41 SpecialCargoCraft BYTE */
	public int $SpecialCargoCraft;
    /** @var string 0x42 SpecialCargo STR */
	public string $SpecialCargo;
    /** @var bool 0x56 RandSpecCraft BOOL */
	public bool $RandSpecCraft;
    
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

        $this->Name = $this->getString($hex, 0x00);
        $this->Leader = $this->getByte($hex, 0x40);
        $this->SpecialCargoCraft = $this->getByte($hex, 0x41);
        $this->SpecialCargo = $this->getString($hex, 0x42);
        $this->RandSpecCraft = $this->getBool($hex, 0x56);
        

        $this->hex = substr($this->hex, 0, $this->getLength());
        $this->afterLoadHex();
        return $this;
    }
    
    public function __debugInfo(): array
    {
        return [
            "Name" => $this->Name,
            "Leader" => $this->Leader,
            "SpecialCargoCraft" => $this->SpecialCargoCraft,
            "SpecialCargo" => $this->SpecialCargo,
            "RandSpecCraft" => $this->RandSpecCraft
        ];
    }
    
    public function toHexString($hex = null): string
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $hex = $this->writeString($this->Name, $hex, 0x00);
        $hex = $this->writeByte($this->Leader, $hex, 0x40);
        $hex = $this->writeByte($this->SpecialCargoCraft, $hex, 0x41);
        $hex = $this->writeString($this->SpecialCargo, $hex, 0x42);
        $hex = $this->writeBool($this->RandSpecCraft, $hex, 0x56);

        return $hex;
    }
    
    
    public function getLength(): int
    {
        return self::GLOBALUNITLENGTH;
    }
}