<?php

namespace Pyrite\XWA\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\PyriteBase;
use Pyrite\XWA\Briefing;
use Pyrite\XWA\FileHeader;
use Pyrite\XWA\FlightGroup;
use Pyrite\XWA\GlobalGoal;
use Pyrite\XWA\Message;
use Pyrite\XWA\Team;
use Pyrite\XWA\XWAString;

abstract class MissionBase extends PyriteBase implements Byteable
{
    use HexDecoder;

    /** @var integer */
    public $MissionLength;
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
    public $Briefings;
    /** @var string */
    public $EditorNotes;
    /** @var string[] */
    public $BriefingStringNotes;
    /** @var string[] */
    public $MessageNotes;
    /** @var string[] */
    public $EomNotes;
    /** @var integer[] */
    public $Unknown;
    /** @var string[] */
    public $DescriptionNotes;
    /** @var XWAString[] */
    public $FGGoalStrings;
    /** @var XWAString[] */
    public $GlobalGoalStrings;
    /** @var XWAString[] */
    public $OrderStrings;
    /** @var string[] */
    public $Descriptions;
    
    public function __construct($hex, $tie = null)
    {
        parent::__construct($hex, $tie);
        $this->beforeConstruct();
        $offset = 0;

        $this->FileHeader = new FileHeader(substr($hex, 0x0000), $this->TIE);
        $this->FlightGroups = [];
        $offset = 0x23F0;
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
        $this->Briefings = [];
        $offset = $offset;
        for ($i = 0; $i < 2; $i++) {
            $t = new Briefing(substr($hex, $offset), $this->TIE);
            $this->Briefings[] = $t;
            $offset += $t->getLength();
        }
        $this->EditorNotes = $this->getString($hex, $offset);
        $this->BriefingStringNotes = [];
        $offset = $offset;
        for ($i = 0; $i < 128; $i++) {
            $t = $this->getString($hex, $offset);
            $this->BriefingStringNotes[] = $t;
            $offset += strlen($t);
        }
        $this->MessageNotes = [];
        $offset = $offset;
        for ($i = 0; $i < 64; $i++) {
            $t = $this->getString($hex, $offset);
            $this->MessageNotes[] = $t;
            $offset += strlen($t);
        }
        $this->EomNotes = [];
        $offset = $offset;
        for ($i = 0; $i < 30; $i++) {
            $t = $this->getString($hex, $offset);
            $this->EomNotes[] = $t;
            $offset += strlen($t);
        }
        $this->Unknown = [];
        $offset = $offset;
        for ($i = 0; $i < 480; $i++) {
            $t = $this->getByte($hex, $offset);
            $this->Unknown[] = $t;
            $offset += 1;
        }
        $this->DescriptionNotes = [];
        $offset = $offset;
        for ($i = 0; $i < 3; $i++) {
            $t = $this->getString($hex, $offset);
            $this->DescriptionNotes[] = $t;
            $offset += strlen($t);
        }
        $this->FGGoalStrings = [];
        $offset = $offset;
        for ($i = 0; $i < $this->FGGoalStringCount(); $i++) {
            $t = new XWAString(substr($hex, $offset), $this->TIE);
            $this->FGGoalStrings[] = $t;
            $offset += $t->getLength();
        }
        $this->GlobalGoalStrings = [];
        $offset = $offset;
        for ($i = 0; $i < 360; $i++) {
            $t = new XWAString(substr($hex, $offset), $this->TIE);
            $this->GlobalGoalStrings[] = $t;
            $offset += $t->getLength();
        }
        $this->OrderStrings = [];
        $offset = $offset;
        for ($i = 0; $i < 3072; $i++) {
            $t = new XWAString(substr($hex, $offset), $this->TIE);
            $this->OrderStrings[] = $t;
            $offset += $t->getLength();
        }
        $this->Descriptions = [];
        $offset = $offset;
        for ($i = 0; $i < 3; $i++) {
            $t = $this->getString($hex, $offset);
            $this->Descriptions[] = $t;
            $offset += strlen($t);
        }
        $this->MissionLength = $offset;
    }
    
    public function __debugInfo()
    {
        return [
            "FileHeader" => $this->FileHeader,
            "FlightGroups" => $this->FlightGroups,
            "Messages" => $this->Messages,
            "GlobalGoals" => $this->GlobalGoals,
            "Teams" => $this->Teams,
            "Briefings" => $this->Briefings,
            "EditorNotes" => $this->EditorNotes,
            "BriefingStringNotes" => $this->BriefingStringNotes,
            "MessageNotes" => $this->MessageNotes,
            "EomNotes" => $this->EomNotes,
            "Unknown" => $this->Unknown,
            "DescriptionNotes" => $this->DescriptionNotes,
            "FGGoalStrings" => $this->FGGoalStrings,
            "GlobalGoalStrings" => $this->GlobalGoalStrings,
            "OrderStrings" => $this->OrderStrings,
            "Descriptions" => $this->Descriptions
        ];
    }
    
    public function toHexString()
    {
        $hex = "";
        $offset = 0;

        $this->writeObject($hex, $this->FileHeader, 0x0000);
        $offset = 0x23F0;
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
        for ($i = 0; $i < 2; $i++) {
            $t = $this->Briefings[$i];
            $this->writeObject($hex, $t, $offset);
            $offset += $t->getLength();
        }
        $this->writeString($hex, $this->EditorNotes, $offset);
        $offset = $offset;
        for ($i = 0; $i < 128; $i++) {
            $t = $this->BriefingStringNotes[$i];
            $this->writeString($hex, $t, $offset);
            $offset += strlen($t);
        }
        $offset = $offset;
        for ($i = 0; $i < 64; $i++) {
            $t = $this->MessageNotes[$i];
            $this->writeString($hex, $t, $offset);
            $offset += strlen($t);
        }
        $offset = $offset;
        for ($i = 0; $i < 30; $i++) {
            $t = $this->EomNotes[$i];
            $this->writeString($hex, $t, $offset);
            $offset += strlen($t);
        }
        $offset = $offset;
        for ($i = 0; $i < 480; $i++) {
            $t = $this->Unknown[$i];
            $this->writeByte($hex, $t, $offset);
            $offset += 1;
        }
        $offset = $offset;
        for ($i = 0; $i < 3; $i++) {
            $t = $this->DescriptionNotes[$i];
            $this->writeString($hex, $t, $offset);
            $offset += strlen($t);
        }
        $offset = $offset;
        for ($i = 0; $i < $this->FGGoalStringCount(); $i++) {
            $t = $this->FGGoalStrings[$i];
            $this->writeObject($hex, $t, $offset);
            $offset += $t->getLength();
        }
        $offset = $offset;
        for ($i = 0; $i < 360; $i++) {
            $t = $this->GlobalGoalStrings[$i];
            $this->writeObject($hex, $t, $offset);
            $offset += $t->getLength();
        }
        $offset = $offset;
        for ($i = 0; $i < 3072; $i++) {
            $t = $this->OrderStrings[$i];
            $this->writeObject($hex, $t, $offset);
            $offset += $t->getLength();
        }
        $offset = $offset;
        for ($i = 0; $i < 3; $i++) {
            $t = $this->Descriptions[$i];
            $this->writeString($hex, $t, $offset);
            $offset += strlen($t);
        }

        return $hex;
    }
    
    protected abstract function FGGoalStringCount();
    public function getLength()
    {
        return $this->MissionLength;
    }
}