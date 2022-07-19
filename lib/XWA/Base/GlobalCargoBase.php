<?php

namespace Pyrite\XWA\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;

abstract class GlobalCargoBase extends PyriteBase implements Byteable
{
    use HexDecoder;
    use HexEncoder;

    /** @var integer  GLOBALCARGOLENGTH INT */
    public const GLOBALCARGOLENGTH = 140;
    /** @var string 0x00 Cargo STR */
    public $Cargo;
    /** @var boolean 0x44 Unknown1 BOOL */
    public $Unknown1;
    /** @var integer 0x48 Unknown2 BYTE */
    public $Unknown2;
    /** @var integer 0x49 Unknown3 BYTE */
    public $Unknown3;
    /** @var integer 0x4A Unknown4 BYTE */
    public $Unknown4;
    /** @var integer 0x4B Unknown5 BYTE */
    public $Unknown5;
    
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

        $this->Cargo = $this->getString($hex, 0x00);
        $this->Unknown1 = $this->getBool($hex, 0x44);
        $this->Unknown2 = $this->getByte($hex, 0x48);
        $this->Unknown3 = $this->getByte($hex, 0x49);
        $this->Unknown4 = $this->getByte($hex, 0x4A);
        $this->Unknown5 = $this->getByte($hex, 0x4B);
        

        $this->hex = substr($this->hex, 0, $this->getLength());
        return $this;
    }
    
    public function __debugInfo()
    {
        return [
            "Cargo" => $this->Cargo,
            "Unknown1" => $this->Unknown1,
            "Unknown2" => $this->Unknown2,
            "Unknown3" => $this->Unknown3,
            "Unknown4" => $this->Unknown4,
            "Unknown5" => $this->Unknown5
        ];
    }
    
    public function toHexString($hex = null)
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $hex = $this->writeString($this->Cargo, $hex, 0x00);
        $hex = $this->writeBool($this->Unknown1, $hex, 0x44);
        $hex = $this->writeByte($this->Unknown2, $hex, 0x48);
        $hex = $this->writeByte($this->Unknown3, $hex, 0x49);
        $hex = $this->writeByte($this->Unknown4, $hex, 0x4A);
        $hex = $this->writeByte($this->Unknown5, $hex, 0x4B);

        return $hex;
    }
    
    
    public function getLength()
    {
        return self::GLOBALCARGOLENGTH;
    }
}