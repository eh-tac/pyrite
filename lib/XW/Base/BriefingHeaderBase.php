<?php

namespace Pyrite\XW\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;

abstract class BriefingHeaderBase extends PyriteBase implements Byteable
{
    use HexDecoder;
    use HexEncoder;

    /** @var integer  BRIEFINGHEADERLENGTH INT */
    public const BRIEFINGHEADERLENGTH = 6;
    /** @var integer 0x00 PlatformID SHORT */
    public $PlatformID; //(2)
    /** @var integer 0x02 IconCount SHORT */
    public $IconCount;
    /** @var integer 0x04 CoordinateCount SHORT */
    public $CoordinateCount;
    
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

        $this->PlatformID = $this->getShort($hex, 0x00);
        $this->IconCount = $this->getShort($hex, 0x02);
        $this->CoordinateCount = $this->getShort($hex, 0x04);
        

        $this->hex = substr($this->hex, 0, $this->getLength());
        return $this;
    }
    
    public function __debugInfo()
    {
        return [
            "PlatformID" => $this->PlatformID,
            "IconCount" => $this->IconCount,
            "CoordinateCount" => $this->CoordinateCount
        ];
    }
    
    public function toHexString($hex = null)
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $hex = $this->writeShort($this->PlatformID, $hex, 0x00);
        $hex = $this->writeShort($this->IconCount, $hex, 0x02);
        $hex = $this->writeShort($this->CoordinateCount, $hex, 0x04);

        return $hex;
    }
    
    
    public function getLength()
    {
        return self::BRIEFINGHEADERLENGTH;
    }
}