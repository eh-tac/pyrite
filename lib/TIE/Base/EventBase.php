<?php

namespace Pyrite\TIE\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\PyriteBase;
use Pyrite\TIE\Constants;

abstract class EventBase extends PyriteBase implements Byteable
{
    use HexDecoder;

    /** @var integer */
    public $EventLength;
    /** @var integer */
    public $Time;
    /** @var integer */
    public $EventType;
    /** @var integer[] */
    public $Variables;
    
    public function __construct($hex, $tie = null)
    {
        parent::__construct($hex, $tie);
        $this->beforeConstruct();
        $offset = 0;

        $this->Time = $this->getShort($hex, 0x0);
        $this->EventType = $this->getShort($hex, 0x2);
        $this->Variables = [];
        $offset = 0x4;
        for ($i = 0; $i < $this->VariableCount(); $i++) {
            $t = $this->getShort($hex, $offset);
            $this->Variables[] = $t;
            $offset += 2;
        }
        $this->EventLength = $offset;
    }
    
    public function __debugInfo()
    {
        return [
            "Time" => $this->Time,
            "EventType" => $this->getEventTypeLabel(),
            "Variables" => $this->Variables
        ];
    }
    
    public function toHexString()
    {
        $hex = "";
        $offset = 0;

        $this->writeShort($hex, $this->Time, 0x0);
        $this->writeShort($hex, $this->EventType, 0x2);
        $offset = 0x4;
        for ($i = 0; $i < $this->VariableCount(); $i++) {
            $t = $this->Variables[$i];
            $this->writeShort($hex, $t, $offset);
            $offset += 2;
        }

        return $hex;
    }
    
    public function getEventTypeLabel() {
        return isset($this->EventType) && isset(Constants::$EVENTTYPE[$this->EventType]) ? Constants::$EVENTTYPE[$this->EventType] : "Unknown";
    }
    protected abstract function VariableCount();
    public function getLength()
    {
        return $this->EventLength;
    }
}