<?php

namespace Pyrite\XvT\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
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

    /** @var integer */
    public $MissionBOPLength;
    /** @var FileHeader */
    public $FileHeader;
    /** @var FlightGroup[] */
    public $FlightGroups;
    /** @var Message[] */
    public $Messages;
    /** @var GlobalGoal[] */
    public $GlobalGoals;
    /** @var Team[] */
    public $Teams;
    /** @var Briefing[] */
    public $Briefing;
    /** @var string[] */
    public $FGGoalStrings;
    /** @var string[] */
    public $GlobalGoalStrings;
    /** @var string[] */
    public $MissionDescriptions;
    
    public function __construct($hex, $tie = null)
    {
        parent::__construct($hex, $tie);
        $this->beforeConstruct();
        $offset = 0;

        $this->FileHeader = new FileHeader(substr($hex, 0x000), $this->TIE);
        $this->FlightGroups = [];
        $offset = $offset;
        for ($i = 0; $i < $this->FileHeader->NumFGs; $i++) {
            $t = new FlightGroup(substr($hex, $offset), $this->TIE);
            $this->FlightGroups[] = $t;
            $offset += $t->getLength();
        }
        $this->Messages = [];
        $offset = $offset;
        for ($i = 0; $i < $this->FileHeader->NumMessages; $i++) {
            $t = new Message(substr($hex, $offset), $this->TIE);
            $this->Messages[] = $t;
            $offset += $t->getLength();
        }
        $this->GlobalGoals = [];
        $offset = $offset;
        for ($i = 0; $i < 10; $i++) {
            $t = new GlobalGoal(substr($hex, $offset), $this->TIE);
            $this->GlobalGoals[] = $t;
            $offset += $t->getLength();
        }
        $this->Teams = [];
        $offset = $offset;
        for ($i = 0; $i < 10; $i++) {
            $t = new Team(substr($hex, $offset), $this->TIE);
            $this->Teams[] = $t;
            $offset += $t->getLength();
        }
        $this->Briefing = [];
        $offset = $offset;
        for ($i = 0; $i < 8; $i++) {
            $t = new Briefing(substr($hex, $offset), $this->TIE);
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
    
    public function toHexString()
    {
        $hex = "";
        $offset = 0;

        $this->writeObject($hex, $this->FileHeader, 0x000);
        $offset = $offset;
        for ($i = 0; $i < $this->FileHeader->NumFGs; $i++) {
            $t = $this->FlightGroups[$i];
            $this->writeObject($hex, $t, $offset);
            $offset += $t->getLength();
        }
        $offset = $offset;
        for ($i = 0; $i < $this->FileHeader->NumMessages; $i++) {
            $t = $this->Messages[$i];
            $this->writeObject($hex, $t, $offset);
            $offset += $t->getLength();
        }
        $offset = $offset;
        for ($i = 0; $i < 10; $i++) {
            $t = $this->GlobalGoals[$i];
            $this->writeObject($hex, $t, $offset);
            $offset += $t->getLength();
        }
        $offset = $offset;
        for ($i = 0; $i < 10; $i++) {
            $t = $this->Teams[$i];
            $this->writeObject($hex, $t, $offset);
            $offset += $t->getLength();
        }
        $offset = $offset;
        for ($i = 0; $i < 8; $i++) {
            $t = $this->Briefing[$i];
            $this->writeObject($hex, $t, $offset);
            $offset += $t->getLength();
        }
        $offset = $offset;
        for ($i = 0; $i < $this->FGGoalStringCount(); $i++) {
            $t = $this->FGGoalStrings[$i];
            $this->writeString($hex, $t, $offset);
            $offset += strlen($t);
        }
        $offset = $offset;
        for ($i = 0; $i < 360; $i++) {
            $t = $this->GlobalGoalStrings[$i];
            $this->writeString($hex, $t, $offset);
            $offset += strlen($t);
        }
        $offset = $offset;
        for ($i = 0; $i < 3; $i++) {
            $t = $this->MissionDescriptions[$i];
            $this->writeString($hex, $t, $offset);
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