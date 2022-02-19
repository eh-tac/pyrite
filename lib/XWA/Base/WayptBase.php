<?php

namespace Pyrite\XWA\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\PyriteBase;

abstract class WayptBase extends PyriteBase implements Byteable
{
    use HexDecoder;

    /** @var integer */
    public const WAYPTLENGTH = 8;
    /** @var integer */
    public $X;
    /** @var integer */
    public $Y;
    /** @var integer */
    public $Z;
    /** @var boolean */
    public $Enabled;
    
    public function __construct($hex, $tie = null)
    {
        parent::__construct($hex, $tie);
        $this->beforeConstruct();
        $offset = 0;

        $this->X = $this->getShort($hex, 0x0);
        $this->Y = $this->getShort($hex, 0x2);
        $this->Z = $this->getShort($hex, 0x4);
        $this->Enabled = $this->getBool($hex, 0x6);
        
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
    
    public function toHexString()
    {
        $hex = "";
        $offset = 0;

        $this->writeShort($hex, $this->X, 0x0);
        $this->writeShort($hex, $this->Y, 0x2);
        $this->writeShort($hex, $this->Z, 0x4);
        $this->writeBool($hex, $this->Enabled, 0x6);

        return $hex;
    }
    
    
    public function getLength()
    {
        return self::WAYPTLENGTH;
    }
}