<?php

namespace Pyrite\XW\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;
use Pyrite\XW\Constants;

abstract class MissionHeaderBase extends PyriteBase implements Byteable
{
    use HexDecoder;
    use HexEncoder;

    /** @var integer  MISSIONHEADERLENGTH INT */
    public const MISSIONHEADERLENGTH = 200;
    /** @var integer 0x00 TimeLimitMinutes SHORT */
    public $TimeLimitMinutes;
    /** @var integer 0x02 EndEvent SHORT */
    public $EndEvent;
    /** @var integer 0x04 RndSeed SHORT */
    public $RndSeed; //(unused)
    /** @var integer 0x06 Location SHORT */
    public $Location;
    /** @var string[] 0x08 EndOfMissionMessages CHAR */
    public $EndOfMissionMessages;
    
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

        $this->TimeLimitMinutes = $this->getShort($hex, 0x00);
        $this->EndEvent = $this->getShort($hex, 0x02);
        $this->RndSeed = $this->getShort($hex, 0x04);
        $this->Location = $this->getShort($hex, 0x06);
        $this->EndOfMissionMessages = [];
        $offset = 0x08;
        for ($i = 0; $i < 64; $i++) {
            $t = $this->getChar($hex, $offset, 1);
            $this->EndOfMissionMessages[] = $t;
            $offset += 1;
        }
        

        $this->hex = substr($this->hex, 0, $this->getLength());
        return $this;
    }
    
    public function __debugInfo()
    {
        return [
            "TimeLimitMinutes" => $this->TimeLimitMinutes,
            "EndEvent" => $this->getEndEventLabel(),
            "RndSeed" => $this->RndSeed,
            "Location" => $this->getLocationLabel(),
            "EndOfMissionMessages" => $this->EndOfMissionMessages
        ];
    }
    
    public function toHexString($hex = null)
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $hex = $this->writeShort($this->TimeLimitMinutes, $hex, 0x00);
        $hex = $this->writeShort($this->EndEvent, $hex, 0x02);
        $hex = $this->writeShort($this->RndSeed, $hex, 0x04);
        $hex = $this->writeShort($this->Location, $hex, 0x06);
        $offset = 0x08;
        for ($i = 0; $i < 64; $i++) {
            $t = $this->EndOfMissionMessages[$i];
            $hex = $this->writeChar($t, $hex, $offset);
            $offset += 1;
        }

        return $hex;
    }
    
    public function getEndEventLabel() 
    {
        return isset($this->EndEvent) && isset(Constants::$ENDEVENT[$this->EndEvent]) ? Constants::$ENDEVENT[$this->EndEvent] : "Unknown";
    }

    public function getLocationLabel() 
    {
        return isset($this->Location) && isset(Constants::$LOCATION[$this->Location]) ? Constants::$LOCATION[$this->Location] : "Unknown";
    }
    
    public function getLength()
    {
        return self::MISSIONHEADERLENGTH;
    }
}