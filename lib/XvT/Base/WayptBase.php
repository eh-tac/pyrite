<?php

namespace Pyrite\XvT\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;

abstract class WayptBase extends PyriteBase implements Byteable
{
    use HexDecoder;
    use HexEncoder;

    /** @var integer  WAYPTLENGTH INT */
    public const WAYPTLENGTH = 44;
    /** @var integer[] 0x00 StartPoints SHORT */
    public $StartPoints;
    /** @var integer[] 0x08 Waypoints SHORT */
    public $Waypoints;
    /** @var integer 0x18 Rendezvous SHORT */
    public $Rendezvous;
    /** @var integer 0x1A Hyperspace SHORT */
    public $Hyperspace;
    /** @var integer[] 0x1C Briefings SHORT */
    public $Briefings;
    
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

        $this->StartPoints = [];
        $offset = 0x00;
        for ($i = 0; $i < 4; $i++) {
            $t = $this->getShort($hex, $offset);
            $this->StartPoints[] = $t;
            $offset += 2;
        }
        $this->Waypoints = [];
        $offset = 0x08;
        for ($i = 0; $i < 8; $i++) {
            $t = $this->getShort($hex, $offset);
            $this->Waypoints[] = $t;
            $offset += 2;
        }
        $this->Rendezvous = $this->getShort($hex, 0x18);
        $this->Hyperspace = $this->getShort($hex, 0x1A);
        $this->Briefings = [];
        $offset = 0x1C;
        for ($i = 0; $i < 8; $i++) {
            $t = $this->getShort($hex, $offset);
            $this->Briefings[] = $t;
            $offset += 2;
        }
        
        return $this;
    }
    
    public function __debugInfo()
    {
        return [
            "StartPoints" => $this->StartPoints,
            "Waypoints" => $this->Waypoints,
            "Rendezvous" => $this->Rendezvous,
            "Hyperspace" => $this->Hyperspace,
            "Briefings" => $this->Briefings
        ];
    }
    
    public function toHexString($hex = null)
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $offset = 0x00;
        for ($i = 0; $i < 4; $i++) {
            $t = $this->StartPoints[$i];
            [$hex, $offset] = $this->writeShort($t, $hex, $offset);
        }
        $offset = 0x08;
        for ($i = 0; $i < 8; $i++) {
            $t = $this->Waypoints[$i];
            [$hex, $offset] = $this->writeShort($t, $hex, $offset);
        }
        [$hex, $offset] = $this->writeShort($this->Rendezvous, $hex, 0x18);
        [$hex, $offset] = $this->writeShort($this->Hyperspace, $hex, 0x1A);
        $offset = 0x1C;
        for ($i = 0; $i < 8; $i++) {
            $t = $this->Briefings[$i];
            [$hex, $offset] = $this->writeShort($t, $hex, $offset);
        }

        return $hex;
    }
    
    
    public function getLength()
    {
        return self::WAYPTLENGTH;
    }
}