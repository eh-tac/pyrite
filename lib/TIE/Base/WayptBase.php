<?php

namespace Pyrite\TIE\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\PyriteBase;

abstract class WayptBase extends PyriteBase implements Byteable
{
    use HexDecoder;

    /** @var integer */
    public const WAYPTLENGTH = 30;
    /** @var integer[] */
    public $StartPoints;
    /** @var integer[] */
    public $Waypoints;
    /** @var integer */
    public $Rendezvous;
    /** @var integer */
    public $Hyperspace;
    /** @var integer */
    public $Briefing;
    
    public function __construct($hex, $tie = null)
    {
        parent::__construct($hex, $tie);
        $this->beforeConstruct();
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
        $this->Briefing = $this->getShort($hex, 0x1C);
        
    }
    
    public function __debugInfo()
    {
        return [
            "StartPoints" => $this->StartPoints,
            "Waypoints" => $this->Waypoints,
            "Rendezvous" => $this->Rendezvous,
            "Hyperspace" => $this->Hyperspace,
            "Briefing" => $this->Briefing
        ];
    }
    
    public function toHexString()
    {
        $hex = "";
        $offset = 0;

        $offset = 0x00;
        for ($i = 0; $i < 4; $i++) {
            $t = $this->StartPoints[$i];
            $this->writeShort($hex, $t, $offset);
            $offset += 2;
        }
        $offset = 0x08;
        for ($i = 0; $i < 8; $i++) {
            $t = $this->Waypoints[$i];
            $this->writeShort($hex, $t, $offset);
            $offset += 2;
        }
        $this->writeShort($hex, $this->Rendezvous, 0x18);
        $this->writeShort($hex, $this->Hyperspace, 0x1A);
        $this->writeShort($hex, $this->Briefing, 0x1C);

        return $hex;
    }
    
    
    public function getLength()
    {
        return self::WAYPTLENGTH;
    }
}