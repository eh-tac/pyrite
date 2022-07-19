<?php

namespace Pyrite\XvT\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;
use Pyrite\XvT\Event;
use Pyrite\XvT\Tag;
use Pyrite\XvT\XvTString;

abstract class BriefingBase extends PyriteBase implements Byteable
{
    use HexDecoder;
    use HexEncoder;

    /** @var integer  BriefingLength INT */
    public $BriefingLength;
    /** @var integer 0x000 RunningTime SHORT */
    public $RunningTime;
    /** @var integer 0x002 Unknown1 SHORT */
    public $Unknown1;
    /** @var integer 0x004 StartEvents SHORT */
    public $StartEvents;
    /** @var integer 0x006 EventsLength INT */
    public $EventsLength;
    /** @var Event[] 0x00A Events Event */
    public $Events;
    /** @var Tag[] 0x334 Tags Tag */
    public $Tags;
    /** @var XvTString[] PV Strings XvTString */
    public $Strings;
    
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

        $this->RunningTime = $this->getShort($hex, 0x000);
        $this->Unknown1 = $this->getShort($hex, 0x002);
        $this->StartEvents = $this->getShort($hex, 0x004);
        $this->EventsLength = $this->getInt($hex, 0x006);
        $this->Events = [];
        $offset = 0x00A;
        for ($i = 0; $i < $this->EventsLength; $i++) {
            $t = (new Event(substr($hex, $offset), $this->TIE))->loadHex();
            $this->Events[] = $t;
            $offset += $t->getLength();
        }
        $this->Tags = [];
        $offset = 0x334;
        for ($i = 0; $i < 32; $i++) {
            $t = (new Tag(substr($hex, $offset), $this->TIE))->loadHex();
            $this->Tags[] = $t;
            $offset += $t->getLength();
        }
        $this->Strings = [];
        $offset = $offset;
        for ($i = 0; $i < 32; $i++) {
            $t = (new XvTString(substr($hex, $offset), $this->TIE))->loadHex();
            $this->Strings[] = $t;
            $offset += $t->getLength();
        }
        $this->BriefingLength = $offset;

        $this->hex = substr($this->hex, 0, $this->getLength());
        return $this;
    }
    
    public function __debugInfo()
    {
        return [
            "RunningTime" => $this->RunningTime,
            "Unknown1" => $this->Unknown1,
            "StartEvents" => $this->StartEvents,
            "EventsLength" => $this->EventsLength,
            "Events" => $this->Events,
            "Tags" => $this->Tags,
            "Strings" => $this->Strings
        ];
    }
    
    public function toHexString($hex = null)
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $hex = $this->writeShort($this->RunningTime, $hex, 0x000);
        $hex = $this->writeShort($this->Unknown1, $hex, 0x002);
        $hex = $this->writeShort($this->StartEvents, $hex, 0x004);
        $hex = $this->writeInt($this->EventsLength, $hex, 0x006);
        $offset = 0x00A;
        for ($i = 0; $i < $this->EventsLength; $i++) {
            $t = $this->Events[$i];
            $hex = $this->writeObject($t, $hex, $offset);
            $offset += $t->getLength();
        }
        $offset = 0x334;
        for ($i = 0; $i < 32; $i++) {
            $t = $this->Tags[$i];
            $hex = $this->writeObject($t, $hex, $offset);
            $offset += $t->getLength();
        }
        $offset = $offset;
        for ($i = 0; $i < 32; $i++) {
            $t = $this->Strings[$i];
            $hex = $this->writeObject($t, $hex, $offset);
            $offset += $t->getLength();
        }

        return $hex;
    }
    
    
    public function getLength()
    {
        return $this->BriefingLength;
    }
}