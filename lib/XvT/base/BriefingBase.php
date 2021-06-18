<?php

namespace Pyrite\XvT\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\PyriteBase;
use Pyrite\XvT\Event;
use Pyrite\XvT\Tag;
use Pyrite\XvT\XvTString;

abstract class BriefingBase extends PyriteBase implements Byteable
{
    use HexDecoder;

    /** @var integer */
    public $BriefingLength;
    /** @var integer */
    public $RunningTime;
    /** @var integer */
    public $Unknown1;
    /** @var integer */
    public $StartEvents;
    /** @var integer */
    public $EventsLength;
    /** @var Event[] */
    public $Events;
    /** @var Tag[] */
    public $Tags;
    /** @var XvTString[] */
    public $Strings;
    
    public function __construct($hex, $tie = null)
    {
        parent::__construct($hex, $tie);
        $this->beforeConstruct();
        $offset = 0;

        $this->RunningTime = $this->getShort($hex, 0x000);
        $this->Unknown1 = $this->getShort($hex, 0x002);
        $this->StartEvents = $this->getShort($hex, 0x004);
        $this->EventsLength = $this->getInt($hex, 0x006);
        $this->Events = [];
        $offset = 0x00A;
        for ($i = 0; $i < $this->EventsLength; $i++) {
            $t = new Event(substr($hex, $offset), $this->TIE);
            $this->Events[] = $t;
            $offset += $t->getLength();
        }
        $this->Tags = [];
        $offset = 0x334;
        for ($i = 0; $i < 32; $i++) {
            $t = new Tag(substr($hex, $offset), $this->TIE);
            $this->Tags[] = $t;
            $offset += $t->getLength();
        }
        $this->Strings = [];
        $offset = $offset;
        for ($i = 0; $i < 32; $i++) {
            $t = new XvTString(substr($hex, $offset), $this->TIE);
            $this->Strings[] = $t;
            $offset += $t->getLength();
        }
        $this->BriefingLength = $offset;
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
    
    public function toHexString()
    {
        $hex = "";
        $offset = 0;

        $this->writeShort($hex, $this->RunningTime, 0x000);
        $this->writeShort($hex, $this->Unknown1, 0x002);
        $this->writeShort($hex, $this->StartEvents, 0x004);
        $this->writeInt($hex, $this->EventsLength, 0x006);
        $offset = 0x00A;
        for ($i = 0; $i < $this->EventsLength; $i++) {
            $t = $this->Events[$i];
            $this->writeObject($hex, $t, $offset);
            $offset += $t->getLength();
        }
        $offset = 0x334;
        for ($i = 0; $i < 32; $i++) {
            $t = $this->Tags[$i];
            $this->writeObject($hex, $t, $offset);
            $offset += $t->getLength();
        }
        $offset = $offset;
        for ($i = 0; $i < 32; $i++) {
            $t = $this->Strings[$i];
            $this->writeObject($hex, $t, $offset);
            $offset += $t->getLength();
        }

        return $hex;
    }
    
    
    public function getLength()
    {
        return $this->BriefingLength;
    }
}