<?php

namespace Pyrite\XW\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;

abstract class PageBase extends PyriteBase implements Byteable
{
    use HexDecoder;
    use HexEncoder;

    /** @var integer  PageLength INT */
    public $PageLength;
    /** @var integer 0x00 Duration SHORT */
    public $Duration; //(ticks)
    /** @var integer 0x02 EventsLength SHORT */
    public $EventsLength;
    /** @var integer 0x04 CoordinateSet SHORT */
    public $CoordinateSet;
    /** @var integer 0x06 PageType SHORT */
    public $PageType;
    /** @var integer[] 0x08 Events SHORT */
    public $Events;
    
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

        $this->Duration = $this->getShort($hex, 0x00);
        $this->EventsLength = $this->getShort($hex, 0x02);
        $this->CoordinateSet = $this->getShort($hex, 0x04);
        $this->PageType = $this->getShort($hex, 0x06);
        $this->Events = [];
        $offset = 0x08;
        for ($i = 0; $i < $this->EventsLength; $i++) {
            $t = $this->getShort($hex, $offset);
            $this->Events[] = $t;
            $offset += 2;
        }
        $this->PageLength = $offset;

        $this->hex = substr($this->hex, 0, $this->getLength());
        return $this;
    }
    
    public function __debugInfo()
    {
        return [
            "Duration" => $this->Duration,
            "EventsLength" => $this->EventsLength,
            "CoordinateSet" => $this->CoordinateSet,
            "PageType" => $this->PageType,
            "Events" => $this->Events
        ];
    }
    
    public function toHexString($hex = null)
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $hex = $this->writeShort($this->Duration, $hex, 0x00);
        $hex = $this->writeShort($this->EventsLength, $hex, 0x02);
        $hex = $this->writeShort($this->CoordinateSet, $hex, 0x04);
        $hex = $this->writeShort($this->PageType, $hex, 0x06);
        $offset = 0x08;
        for ($i = 0; $i < $this->EventsLength; $i++) {
            $t = $this->Events[$i];
            $hex = $this->writeShort($t, $hex, $offset);
            $offset += 2;
        }

        return $hex;
    }
    
    
    public function getLength()
    {
        return $this->PageLength;
    }
}