<?php

namespace Pyrite\XvT\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;
use Pyrite\XvT\Briefing;
use Pyrite\XvT\FileHeader;
use Pyrite\XvT\FlightGroup;
use Pyrite\XvT\GlobalGoal;
use Pyrite\XvT\Message;
use Pyrite\XvT\Team;

abstract class MissionBOPBase extends PyriteBase implements Byteable
{
    use HexDecoder;
    use HexEncoder;

    /** @var integer  MissionBOPLength INT */
    public $MissionBOPLength;
    /** @var FileHeader 0x000 FileHeader FileHeader */
    public $FileHeader;
    /** @var FlightGroup[] PV FlightGroups FlightGroup */
    public $FlightGroups;
    /** @var Message[] PV Messages Message */
    public $Messages;
    /** @var GlobalGoal[] PV GlobalGoals GlobalGoal */
    public $GlobalGoals;
    /** @var Team[] PV Teams Team */
    public $Teams;
    /** @var Briefing[] PV Briefing Briefing */
    public $Briefing;
    /** @var string[] PV FGGoalStrings STR */
    public $FGGoalStrings;
    /** @var string[] PV GlobalGoalStrings STR */
    public $GlobalGoalStrings;
    /** @var string[] PV MissionDescriptions STR */
    public $MissionDescriptions;
    
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

        $this->FileHeader = (new FileHeader(substr($hex, 0x000), $this->TIE))->loadHex();
        $this->FlightGroups = [];
        $offset = $offset;
        for ($i = 0; $i < $this->FileHeader->NumFGs; $i++) {
            $t = (new FlightGroup(substr($hex, $offset), $this->TIE))->loadHex();
            $this->FlightGroups[] = $t;
            $offset += $t->getLength();
        }
        $this->Messages = [];
        $offset = $offset;
        for ($i = 0; $i < $this->FileHeader->NumMessages; $i++) {
            $t = (new Message(substr($hex, $offset), $this->TIE))->loadHex();
            $this->Messages[] = $t;
            $offset += $t->getLength();
        }
        $this->GlobalGoals = [];
        $offset = $offset;
        for ($i = 0; $i < 10; $i++) {
            $t = (new GlobalGoal(substr($hex, $offset), $this->TIE))->loadHex();
            $this->GlobalGoals[] = $t;
            $offset += $t->getLength();
        }
        $this->Teams = [];
        $offset = $offset;
        for ($i = 0; $i < 10; $i++) {
            $t = (new Team(substr($hex, $offset), $this->TIE))->loadHex();
            $this->Teams[] = $t;
            $offset += $t->getLength();
        }
        $this->Briefing = [];
        $offset = $offset;
        for ($i = 0; $i < 8; $i++) {
            $t = (new Briefing(substr($hex, $offset), $this->TIE))->loadHex();
            $this->Briefing[] = $t;
            $offset += $t->getLength();
        }
        $this->FGGoalStrings = [];
        $offset = $offset;
        for ($i = 0; $i < $this->FGGoalStringCount(); $i++) {
            $t = $this->getString($hex, $offset);
            $this->FGGoalStrings[] = $t;
            $offset += strlen($t);
        }
        $this->GlobalGoalStrings = [];
        $offset = $offset;
        for ($i = 0; $i < 360; $i++) {
            $t = $this->getString($hex, $offset);
            $this->GlobalGoalStrings[] = $t;
            $offset += strlen($t);
        }
        $this->MissionDescriptions = [];
        $offset = $offset;
        for ($i = 0; $i < 3; $i++) {
            $t = $this->getString($hex, $offset);
            $this->MissionDescriptions[] = $t;
            $offset += strlen($t);
        }
        $this->MissionBOPLength = $offset;

        $this->hex = substr($this->hex, 0, $this->getLength());
        return $this;
    }
    
    public function __debugInfo()
    {
        return [
            "FileHeader" => $this->FileHeader,
            "FlightGroups" => $this->FlightGroups,
            "Messages" => $this->Messages,
            "GlobalGoals" => $this->GlobalGoals,
            "Teams" => $this->Teams,
            "Briefing" => $this->Briefing,
            "FGGoalStrings" => $this->FGGoalStrings,
            "GlobalGoalStrings" => $this->GlobalGoalStrings,
            "MissionDescriptions" => $this->MissionDescriptions
        ];
    }
    
    public function toHexString($hex = null)
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $hex = $this->writeObject($this->FileHeader, $hex, 0x000);
        $offset = $offset;
        for ($i = 0; $i < $this->FileHeader->NumFGs; $i++) {
            $t = $this->FlightGroups[$i];
            $hex = $this->writeObject($t, $hex, $offset);
            $offset += $t->getLength();
        }
        $offset = $offset;
        for ($i = 0; $i < $this->FileHeader->NumMessages; $i++) {
            $t = $this->Messages[$i];
            $hex = $this->writeObject($t, $hex, $offset);
            $offset += $t->getLength();
        }
        $offset = $offset;
        for ($i = 0; $i < 10; $i++) {
            $t = $this->GlobalGoals[$i];
            $hex = $this->writeObject($t, $hex, $offset);
            $offset += $t->getLength();
        }
        $offset = $offset;
        for ($i = 0; $i < 10; $i++) {
            $t = $this->Teams[$i];
            $hex = $this->writeObject($t, $hex, $offset);
            $offset += $t->getLength();
        }
        $offset = $offset;
        for ($i = 0; $i < 8; $i++) {
            $t = $this->Briefing[$i];
            $hex = $this->writeObject($t, $hex, $offset);
            $offset += $t->getLength();
        }
        $offset = $offset;
        for ($i = 0; $i < $this->FGGoalStringCount(); $i++) {
            $t = $this->FGGoalStrings[$i];
            $hex = $this->writeString($t, $hex, $offset);
            $offset += strlen($t);
        }
        $offset = $offset;
        for ($i = 0; $i < 360; $i++) {
            $t = $this->GlobalGoalStrings[$i];
            $hex = $this->writeString($t, $hex, $offset);
            $offset += strlen($t);
        }
        $offset = $offset;
        for ($i = 0; $i < 3; $i++) {
            $t = $this->MissionDescriptions[$i];
            $hex = $this->writeString($t, $hex, $offset);
            $offset += strlen($t);
        }

        return $hex;
    }
    
    protected abstract function FGGoalStringCount();
    public function getLength()
    {
        return $this->MissionBOPLength;
    }
}