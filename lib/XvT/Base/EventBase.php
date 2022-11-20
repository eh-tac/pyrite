<?php

namespace Pyrite\XvT\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;
use Pyrite\XvT\Constants;

abstract class EventBase extends PyriteBase implements Byteable
{
    use HexDecoder;
    use HexEncoder;

    /** @var integer  EventLength INT */
    public $EventLength;
    /** @var integer 0x0 Time SHORT */
    public $Time;
    /** @var integer 0x2 Type SHORT */
    public $Type;
    /** @var integer 0x4 Variables SHORT */
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
        $this->Type = $this->getShort($hex, 0x2);
        $this->Variables = $this->getShort($hex, 0x4);
        $offset += 2;
        $this->EventLength = $offset;
        return $this;
    }
    
    public function __debugInfo()
    {
        return [
            "Time" => $this->Time,
            "Type" => $this->getTypeLabel(),
            "Variables" => $this->Variables
        ];
    }
    
    public function toHexString($hex = null)
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        [$hex, $offset] = $this->writeShort($this->Time, $hex, 0x0);
        [$hex, $offset] = $this->writeShort($this->Type, $hex, 0x2);
        [$hex, $offset] = $this->writeShort($this->Variables, $hex, 0x4);

        return $hex;
    }
    
    public function getTypeLabel() 
    {
        return isset($this->Type) && isset(Constants::$EVENTTYPE[$this->Type]) ? Constants::$EVENTTYPE[$this->Type] : "Unknown";
    }
    
    public function getLength()
    {
        return $this->EventLength;
    }
}