<?php

namespace Pyrite\XWA\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
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
    use HexEncoder;

    /** @var integer  MissionLength INT */
    public $MissionLength;
    /** @var FileHeader 0x0000 FileHeader FileHeader */
    public $FileHeader;
    /** @var FlightGroup[] 0x23F0 FlightGroups FlightGroup */
    public $FlightGroups;
    /** @var Message[] PV Messages Message */
    public $Messages;
    /** @var GlobalGoal[] PV GlobalGoals GlobalGoal */
    public $GlobalGoals;
    /** @var Team[] PV Teams Team */
    public $Teams;
    /** @var Briefing[] PV Briefings Briefing */
    public $Briefings;
    /** @var string PV EditorNotes STR */
    public $EditorNotes;
    /** @var string[] PV BriefingStringNotes STR */
    public $BriefingStringNotes;
    /** @var string[] PV MessageNotes STR */
    public $MessageNotes;
    /** @var string[] PV EomNotes STR */
    public $EomNotes;
    /** @var integer[] PV Unknown BYTE */
    public $Unknown;
    /** @var string[] PV DescriptionNotes STR */
    public $DescriptionNotes;
    /** @var XWAString[] PV FGGoalStrings XWAString */
    public $FGGoalStrings;
    /** @var XWAString[] PV GlobalGoalStrings XWAString */
    public $GlobalGoalStrings;
    /** @var XWAString[] PV OrderStrings XWAString */
    public $OrderStrings;
    /** @var string[] PV Descriptions STR */
    public $Descriptions;
    
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

        $this->FileHeader = (new FileHeader(substr($hex, 0x0000), $this->TIE))->loadHex();
        $this->FlightGroups = [];
        $offset = 0x23F0;
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
        $this->Briefings = [];
        $offset = $offset;
        for ($i = 0; $i < 2; $i++) {
            $t = (new Briefing(substr($hex, $offset), $this->TIE))->loadHex();
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
            $t = (new XWAString(substr($hex, $offset), $this->TIE))->loadHex();
            $this->FGGoalStrings[] = $t;
            $offset += $t->getLength();
        }
        $this->GlobalGoalStrings = [];
        $offset = $offset;
        for ($i = 0; $i < 360; $i++) {
            $t = (new XWAString(substr($hex, $offset), $this->TIE))->loadHex();
            $this->GlobalGoalStrings[] = $t;
            $offset += $t->getLength();
        }
        $this->OrderStrings = [];
        $offset = $offset;
        for ($i = 0; $i < 3072; $i++) {
            $t = (new XWAString(substr($hex, $offset), $this->TIE))->loadHex();
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
        $offset += strlen($t);
        $this->MissionLength = $offset;
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
    
    public function toHexString($hex = null)
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        [$hex, $offset] = $this->writeObject($this->FileHeader, $hex, 0x0000);
        $offset = 0x23F0;
        for ($i = 0; $i < $this->FileHeader->NumFGs; $i++) {
            $t = $this->FlightGroups[$i];
            [$hex, $offset] = $this->writeObject($t, $hex, $offset);
        }
        $offset = $offset;
        for ($i = 0; $i < $this->FileHeader->NumMessages; $i++) {
            $t = $this->Messages[$i];
            [$hex, $offset] = $this->writeObject($t, $hex, $offset);
        }
        $offset = $offset;
        for ($i = 0; $i < 10; $i++) {
            $t = $this->GlobalGoals[$i];
            [$hex, $offset] = $this->writeObject($t, $hex, $offset);
        }
        $offset = $offset;
        for ($i = 0; $i < 10; $i++) {
            $t = $this->Teams[$i];
            [$hex, $offset] = $this->writeObject($t, $hex, $offset);
        }
        $offset = $offset;
        for ($i = 0; $i < 2; $i++) {
            $t = $this->Briefings[$i];
            [$hex, $offset] = $this->writeObject($t, $hex, $offset);
        }
        [$hex, $offset] = $this->writeString($this->EditorNotes, $hex, $offset);
        $offset = $offset;
        for ($i = 0; $i < 128; $i++) {
            $t = $this->BriefingStringNotes[$i];
            [$hex, $offset] = $this->writeString($t, $hex, $offset);
        }
        $offset = $offset;
        for ($i = 0; $i < 64; $i++) {
            $t = $this->MessageNotes[$i];
            [$hex, $offset] = $this->writeString($t, $hex, $offset);
        }
        $offset = $offset;
        for ($i = 0; $i < 30; $i++) {
            $t = $this->EomNotes[$i];
            [$hex, $offset] = $this->writeString($t, $hex, $offset);
        }
        $offset = $offset;
        for ($i = 0; $i < 480; $i++) {
            $t = $this->Unknown[$i];
            [$hex, $offset] = $this->writeByte($t, $hex, $offset);
        }
        $offset = $offset;
        for ($i = 0; $i < 3; $i++) {
            $t = $this->DescriptionNotes[$i];
            [$hex, $offset] = $this->writeString($t, $hex, $offset);
        }
        $offset = $offset;
        for ($i = 0; $i < $this->FGGoalStringCount(); $i++) {
            $t = $this->FGGoalStrings[$i];
            [$hex, $offset] = $this->writeObject($t, $hex, $offset);
        }
        $offset = $offset;
        for ($i = 0; $i < 360; $i++) {
            $t = $this->GlobalGoalStrings[$i];
            [$hex, $offset] = $this->writeObject($t, $hex, $offset);
        }
        $offset = $offset;
        for ($i = 0; $i < 3072; $i++) {
            $t = $this->OrderStrings[$i];
            [$hex, $offset] = $this->writeObject($t, $hex, $offset);
        }
        $offset = $offset;
        for ($i = 0; $i < 3; $i++) {
            $t = $this->Descriptions[$i];
            [$hex, $offset] = $this->writeString($t, $hex, $offset);
        }

        return $hex;
    }
    
    protected abstract function FGGoalStringCount();
    public function getLength()
    {
        return $this->MissionLength;
    }
}