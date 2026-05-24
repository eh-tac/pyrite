<?php

namespace Pyrite\XWA\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;

abstract class GlobalUnitBase extends PyriteBase implements Byteable
{
    use HexDecoder;
    use HexEncoder;

    /** @var integer  GLOBALUNITLENGTH INT */
    public const GLOBALUNITLENGTH = 87;
    /** @var string 0x00 Name STR */
    public $Name;
    /** @var integer 0x40 Leader BYTE */
    public $Leader;
    /** @var integer 0x41 SpecialCargoCraft BYTE */
    public $SpecialCargoCraft;
    /** @var string 0x42 SpecialCargo STR */
    public $SpecialCargo;
    /** @var boolean 0x56 RandSpecCraft BOOL */
    public $RandSpecCraft;
    
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
        $this->Leader = $this->getByte($hex, 0x40);
        $this->SpecialCargoCraft = $this->getByte($hex, 0x41);
        $this->SpecialCargo = $this->getString($hex, 0x42);
        $this->RandSpecCraft = $this->getBool($hex, 0x56);
        

        $this->hex = substr($this->hex, 0, $this->getLength());
        return $this;
    }
    
    public function __debugInfo()
    {
        return [
            "Name" => $this->Name,
            "Leader" => $this->Leader,
            "SpecialCargoCraft" => $this->SpecialCargoCraft,
            "SpecialCargo" => $this->SpecialCargo,
            "RandSpecCraft" => $this->RandSpecCraft
        ];
    }
    
    public function toHexString($hex = null)
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
    
    
    public function getLength()
    {
        return self::GLOBALUNITLENGTH;
    }
}