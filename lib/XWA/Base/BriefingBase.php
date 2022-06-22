<?php

namespace Pyrite\XWA\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;
use Pyrite\XWA\Event;
use Pyrite\XWA\LengthString;
use Pyrite\XWA\Tag;

abstract class BriefingBase extends PyriteBase implements Byteable
{
    use HexDecoder;
    use HexEncoder;

    /** @var integer  BriefingLength INT */
    public $BriefingLength;
    /** @var integer 0x0000 RunningTime SHORT */
    public $RunningTime;
    /** @var integer 0x0002 Unknown1 SHORT */
    public $Unknown1;
    /** @var integer 0x0004 StartLength SHORT */
    public $StartLength;
    /** @var integer 0x0006 EventsLength INT */
    public $EventsLength;
    /** @var Event 0x000A Events Event */
    public $Events;
    /** @var boolean[] 0x440A ShowToTeams BOOL */
    public $ShowToTeams;
    /** @var Tag[] 0x4414 Tags Tag */
    public $Tags;
    /** @var LengthString[] PV Strings LengthString */
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

        $this->RunningTime = $this->getShort($hex, 0x0000);
        $this->Unknown1 = $this->getShort($hex, 0x0002);
        $this->StartLength = $this->getShort($hex, 0x0004);
        $this->EventsLength = $this->getInt($hex, 0x0006);
        $this->Events = (new Event(substr($hex, 0x000A), $this->TIE))->loadHex();
        $offset = 0x000A + $this->Events->getLength();
        $this->ShowToTeams = [];
        $offset = 0x440A;
        for ($i = 0; $i < 10; $i++) {
            $t = $this->getBool($hex, $offset);
            $this->ShowToTeams[] = $t;
            $offset += 1;
        }
        $this->Tags = [];
        $offset = 0x4414;
        for ($i = 0; $i < 128; $i++) {
            $t = (new Tag(substr($hex, $offset), $this->TIE))->loadHex();
            $this->Tags[] = $t;
            $offset += $t->getLength();
        }
        $this->Strings = [];
        $offset = $offset;
        for ($i = 0; $i < 128; $i++) {
            $t = (new LengthString(substr($hex, $offset), $this->TIE))->loadHex();
            $this->Strings[] = $t;
            $offset += $t->getLength();
        }
        $this->BriefingLength = $offset;
        return $this;
    }
    
    public function __debugInfo()
    {
        return [
            "RunningTime" => $this->RunningTime,
            "Unknown1" => $this->Unknown1,
            "StartLength" => $this->StartLength,
            "EventsLength" => $this->EventsLength,
            "Events" => $this->Events,
            "ShowToTeams" => $this->ShowToTeams,
            "Tags" => $this->Tags,
            "Strings" => $this->Strings
        ];
    }
    
    public function toHexString($hex = null)
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $hex = $this->writeShort($this->RunningTime, $hex, 0x0000);
        $hex = $this->writeShort($this->Unknown1, $hex, 0x0002);
        $hex = $this->writeShort($this->StartLength, $hex, 0x0004);
        $hex = $this->writeInt($this->EventsLength, $hex, 0x0006);
        $hex = $this->writeObject($this->Events, $hex, 0x000A);
        $offset = 0x440A;
        for ($i = 0; $i < 10; $i++) {
            $t = $this->ShowToTeams[$i];
            $hex = $this->writeBool($t, $hex, $offset);
            $offset += 1;
        }
        $offset = 0x4414;
        for ($i = 0; $i < 128; $i++) {
            $t = $this->Tags[$i];
            $hex = $this->writeObject($t, $hex, $offset);
            $offset += $t->getLength();
        }
        $offset = $offset;
        for ($i = 0; $i < 128; $i++) {
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