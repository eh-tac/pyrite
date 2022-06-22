<?php

namespace Pyrite\XWA\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;

abstract class WayptBase extends PyriteBase implements Byteable
{
    use HexDecoder;
    use HexEncoder;

    /** @var integer  WAYPTLENGTH INT */
    public const WAYPTLENGTH = 8;
    /** @var integer 0x0 X SHORT */
    public $X;
    /** @var integer 0x2 Y SHORT */
    public $Y;
    /** @var integer 0x4 Z SHORT */
    public $Z;
    /** @var boolean 0x6 Enabled BOOL */
    public $Enabled;
    
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

        $this->X = $this->getShort($hex, 0x0);
        $this->Y = $this->getShort($hex, 0x2);
        $this->Z = $this->getShort($hex, 0x4);
        $this->Enabled = $this->getBool($hex, 0x6);
        
        return $this;
    }
    
    public function __debugInfo()
    {
        return [
            "X" => $this->X,
            "Y" => $this->Y,
            "Z" => $this->Z,
            "Enabled" => $this->Enabled
        ];
    }
    
    public function toHexString($hex = null)
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $hex = $this->writeShort($this->X, $hex, 0x0);
        $hex = $this->writeShort($this->Y, $hex, 0x2);
        $hex = $this->writeShort($this->Z, $hex, 0x4);
        $hex = $this->writeBool($this->Enabled, $hex, 0x6);

        return $hex;
    }
    
    
    public function getLength()
    {
        return self::WAYPTLENGTH;
    }
}