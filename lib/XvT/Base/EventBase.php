<?php

namespace Pyrite\XvT\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\PyriteBase;
use Pyrite\XvT\Constants;

abstract class EventBase extends PyriteBase implements Byteable
{
    use HexDecoder;

    /** @var integer */
    public $EventLength;
    /** @var integer */
    public $Time;
    /** @var integer */
    public $Type;
    /** @var integer */
    public $Variables;
    
    public function __construct($hex, $tie = null)
    {
        parent::__construct($hex, $tie);
        $this->beforeConstruct();
        $offset = 0;

        $this->Time = $this->getShort($hex, 0x0);
        $this->Type = $this->getShort($hex, 0x2);
        $this->Variables = $this->getShort($hex, 0x4);
        $this->EventLength = $offset;
    }
    
    public function __debugInfo()
    {
        return [
            "Time" => $this->Time,
            "Type" => $this->getTypeLabel(),
            "Variables" => $this->Variables
        ];
    }
    
    public function toHexString()
    {
        $hex = "";
        $offset = 0;

        $this->writeShort($hex, $this->Time, 0x0);
        $this->writeShort($hex, $this->Type, 0x2);
        $this->writeShort($hex, $this->Variables, 0x4);

        return $hex;
    }
    
    public function getTypeLabel() {
        return isset($this->Type) && isset(Constants::$EVENTTYPE[$this->Type]) ? Constants::$EVENTTYPE[$this->Type] : "Unknown";
    }
    
    public function getLength()
    {
        return $this->EventLength;
    }
}