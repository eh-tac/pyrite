<?php

namespace Pyrite\XWA\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;
use Pyrite\PyriteModel;
use Pyrite\XWA\Briefing;
use Pyrite\XWA\FileHeader;
use Pyrite\XWA\FlightGroup;
use Pyrite\XWA\GlobalGoal;
use Pyrite\XWA\Message;
use Pyrite\XWA\Team;
use Pyrite\XWA\XWAString;

abstract class MissionBase extends PyriteBase implements Byteable, PyriteModel
{
    use HexDecoder;
    use HexEncoder;

    /** @var int MissionLength INT */
	public int $MissionLength;
    /** @var FileHeader 0x0000 FileHeader FileHeader */
	public FileHeader $FileHeader;
    /** @var array<FlightGroup> 0x23F0 FlightGroups FlightGroup */
	public array $FlightGroups;
    /** @var array<Message> PV Messages Message */
	public array $Messages;
    /** @var array<GlobalGoal> PV GlobalGoals GlobalGoal */
	public array $GlobalGoals;
    /** @var array<Team> PV Teams Team */
	public array $Teams;
    /** @var array<Briefing> PV Briefings Briefing */
	public array $Briefings;
    /** @var string PV EditorNotes STR */
	public string $EditorNotes;
    /** @var array<string> PV BriefingStringNotes STR */
	public array $BriefingStringNotes;
    /** @var array<string> PV MessageNotes STR */
	public array $MessageNotes;
    /** @var array<string> PV EomNotes STR */
	public array $EomNotes;
    /** @var array<string> PV DescriptionNotes STR */
	public array $DescriptionNotes;
    /** @var array<XWAString> PV FGGoalStrings XWAString */
	public array $FGGoalStrings;
    /** @var array<XWAString> PV GlobalGoalStrings XWAString */
	public array $GlobalGoalStrings;
    /** @var array<XWAString> PV OrderStrings XWAString */
	public array $OrderStrings;
    /** @var array<string> PV Descriptions STR */
	public array $Descriptions;
    
    public function __construct(string $hex = null, ?PyriteModel $TIE = null)
    {
        parent::__construct($hex, $TIE);
    }

    /**
     * Process the $hex string provided in the constructor.
     * Separating the constructor and loading allows for the objects to be made from scratch.
     * @return $this 
     */
    public function loadHex(): static
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
        for ($i = 0; $i < 70; $i++) {
            $t = $this->getString($hex, $offset);
            $this->EomNotes[] = $t;
            $offset += strlen($t);
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
        for ($i = 0; $i < 840; $i++) {
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
        $this->MissionLength = $offset;

        $this->hex = substr($this->hex, 0, $this->getLength());
        $this->afterLoadHex();
        return $this;
    }
    
    public function __debugInfo(): array
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
            "DescriptionNotes" => $this->DescriptionNotes,
            "FGGoalStrings" => $this->FGGoalStrings,
            "GlobalGoalStrings" => $this->GlobalGoalStrings,
            "OrderStrings" => $this->OrderStrings,
            "Descriptions" => $this->Descriptions
        ];
    }
    
    public function toHexString($hex = null): string
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $hex = $this->writeObject($this->FileHeader, $hex, 0x0000);
        $offset = 0x23F0;
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
        for ($i = 0; $i < 2; $i++) {
            $t = $this->Briefings[$i];
            $hex = $this->writeObject($t, $hex, $offset);
            $offset += $t->getLength();
        }
        $hex = $this->writeString($this->EditorNotes, $hex, $offset);
        $offset = $offset;
        for ($i = 0; $i < 128; $i++) {
            $t = $this->BriefingStringNotes[$i];
            $hex = $this->writeString($t, $hex, $offset);
            $offset += strlen($t);
        }
        $offset = $offset;
        for ($i = 0; $i < 64; $i++) {
            $t = $this->MessageNotes[$i];
            $hex = $this->writeString($t, $hex, $offset);
            $offset += strlen($t);
        }
        $offset = $offset;
        for ($i = 0; $i < 70; $i++) {
            $t = $this->EomNotes[$i];
            $hex = $this->writeString($t, $hex, $offset);
            $offset += strlen($t);
        }
        $offset = $offset;
        for ($i = 0; $i < 3; $i++) {
            $t = $this->DescriptionNotes[$i];
            $hex = $this->writeString($t, $hex, $offset);
            $offset += strlen($t);
        }
        $offset = $offset;
        for ($i = 0; $i < $this->FGGoalStringCount(); $i++) {
            $t = $this->FGGoalStrings[$i];
            $hex = $this->writeObject($t, $hex, $offset);
            $offset += $t->getLength();
        }
        $offset = $offset;
        for ($i = 0; $i < 840; $i++) {
            $t = $this->GlobalGoalStrings[$i];
            $hex = $this->writeObject($t, $hex, $offset);
            $offset += $t->getLength();
        }
        $offset = $offset;
        for ($i = 0; $i < 3072; $i++) {
            $t = $this->OrderStrings[$i];
            $hex = $this->writeObject($t, $hex, $offset);
            $offset += $t->getLength();
        }
        $offset = $offset;
        for ($i = 0; $i < 3; $i++) {
            $t = $this->Descriptions[$i];
            $hex = $this->writeString($t, $hex, $offset);
            $offset += strlen($t);
        }

        return $hex;
    }
    
    protected abstract function FGGoalStringCount();
    public function getLength(): int
    {
        return $this->MissionLength;
    }
}