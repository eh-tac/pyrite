<?php

namespace Pyrite\TIE\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;
use Pyrite\TIE\Constants;

abstract class EventBase extends PyriteBase implements Byteable
{
    use HexDecoder;
    use HexEncoder;

    /** @var integer  EventLength INT */
    public $EventLength;
    /** @var integer 0x0 Time SHORT */
    public $Time;
    /** @var integer 0x2 EventType SHORT */
    public $EventType;
    /** @var integer[] 0x4 Variables SHORT */
    public $Variables;
    
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
        return $this;
    }
    
    public function __debugInfo()
    {
        return [
            "Time" => $this->Time,
            "EventType" => $this->getEventTypeLabel(),
            "Variables" => $this->Variables
        ];
    }
    
    public function toHexString($hex = null)
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $hex = $this->writeShort($this->Time, $hex, 0x0);
        $hex = $this->writeShort($this->EventType, $hex, 0x2);
        $offset = 0x4;
        for ($i = 0; $i < $this->VariableCount(); $i++) {
            $t = $this->Variables[$i];
            $hex = $this->writeShort($t, $hex, $offset);
            $offset += 2;
        }

        return $hex;
    }
    
    public function getEventTypeLabel() 
    {
        return isset($this->EventType) && isset(Constants::$EVENTTYPE[$this->EventType]) ? Constants::$EVENTTYPE[$this->EventType] : "Unknown";
    }
    protected abstract function VariableCount();
    public function getLength()
    {
        return $this->EventLength;
    }
}