<?php

namespace Pyrite\XWA\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;

abstract class RegionBase extends PyriteBase implements Byteable
{
    use HexDecoder;
    use HexEncoder;

    /** @var integer  REGIONLENGTH INT */
    public const REGIONLENGTH = 132;
    /** @var string 0x00 Name STR */
    public $Name;
    /** @var integer 0x40 ID INT */
    public $ID;
    
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
        $this->ID = $this->getInt($hex, 0x40);
        

        $this->hex = substr($this->hex, 0, $this->getLength());
        return $this;
    }
    
    public function __debugInfo()
    {
        return [
            "Name" => $this->Name,
            "ID" => $this->ID
        ];
    }
    
    public function toHexString($hex = null)
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $hex = $this->writeString($this->Name, $hex, 0x00);
        $hex = $this->writeInt($this->ID, $hex, 0x40);

        return $hex;
    }
    
    
    public function getLength()
    {
        return self::REGIONLENGTH;
    }
}