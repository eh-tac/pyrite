<?php

namespace Pyrite\TIE\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;
use Pyrite\PyriteModel;
use Pyrite\TIE\Briefing;
use Pyrite\TIE\FileHeader;
use Pyrite\TIE\FlightGroup;
use Pyrite\TIE\GlobalGoal;
use Pyrite\TIE\Message;
use Pyrite\TIE\PostMissionQuestions;
use Pyrite\TIE\PreMissionQuestions;

abstract class MissionBase extends PyriteBase implements Byteable, PyriteModel
{
    use HexDecoder;
    use HexEncoder;

    /** @var int MissionLength INT */
	public int $MissionLength;
    /** @var FileHeader 0x000 FileHeader FileHeader */
	public FileHeader $FileHeader;
    /** @var array<FlightGroup> 0x1CA FlightGroups FlightGroup */
	public array $FlightGroups;
    /** @var array<Message> PV Messages Message */
	public array $Messages;
    /** @var array<GlobalGoal> PV GlobalGoals GlobalGoal */
	public array $GlobalGoals;
    /** @var Briefing PV Briefing Briefing */
	public Briefing $Briefing;
    /** @var array<PreMissionQuestions> PV PreMissionQuestions PreMissionQuestions */
	public array $PreMissionQuestions;
    /** @var array<PostMissionQuestions> PV PostMissionQuestions PostMissionQuestions */
	public array $PostMissionQuestions;
    /** @var int PV End BYTE */
	public const End = 255;
    
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

        $this->FileHeader = (new FileHeader(substr($hex, 0x000), $this->TIE))->loadHex();
        $this->FlightGroups = [];
        $offset = 0x1CA;
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
        for ($i = 0; $i < 3; $i++) {
            $t = (new GlobalGoal(substr($hex, $offset), $this->TIE))->loadHex();
            $this->GlobalGoals[] = $t;
            $offset += $t->getLength();
        }
        $this->Briefing = (new Briefing(substr($hex, $offset), $this->TIE))->loadHex();
        $offset += $this->Briefing->getLength();
        $this->PreMissionQuestions = [];
        $offset = $offset;
        for ($i = 0; $i < 10; $i++) {
            $t = (new PreMissionQuestions(substr($hex, $offset), $this->TIE))->loadHex();
            $this->PreMissionQuestions[] = $t;
            $offset += $t->getLength();
        }
        $this->PostMissionQuestions = [];
        $offset = $offset;
        for ($i = 0; $i < 10; $i++) {
            $t = (new PostMissionQuestions(substr($hex, $offset), $this->TIE))->loadHex();
            $this->PostMissionQuestions[] = $t;
            $offset += $t->getLength();
        }
        // static BYTE value End = 255
        $offset += 1;
        $this->MissionLength = $offset;

        $this->hex = substr($this->hex, 0, $this->getLength());
        return $this;
    }
    
    public function __debugInfo(): array
    {
        return [
            "FileHeader" => $this->FileHeader,
            "FlightGroups" => $this->FlightGroups,
            "Messages" => $this->Messages,
            "GlobalGoals" => $this->GlobalGoals,
            "Briefing" => $this->Briefing,
            "PreMissionQuestions" => $this->PreMissionQuestions,
            "PostMissionQuestions" => $this->PostMissionQuestions
        ];
    }
    
    public function toHexString($hex = null): string
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $hex = $this->writeObject($this->FileHeader, $hex, 0x000);
        $offset = 0x1CA;
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
        for ($i = 0; $i < 3; $i++) {
            $t = $this->GlobalGoals[$i];
            $hex = $this->writeObject($t, $hex, $offset);
            $offset += $t->getLength();
        }
        $hex = $this->writeObject($this->Briefing, $hex, $offset);
        $offset = $offset;
        for ($i = 0; $i < 10; $i++) {
            $t = $this->PreMissionQuestions[$i];
            $hex = $this->writeObject($t, $hex, $offset);
            $offset += $t->getLength();
        }
        $offset = $offset;
        for ($i = 0; $i < 10; $i++) {
            $t = $this->PostMissionQuestions[$i];
            $hex = $this->writeObject($t, $hex, $offset);
            $offset += $t->getLength();
        }
        $hex = $this->writeByte(255, $hex, $offset);

        return $hex;
    }
    
    
    public function getLength(): int
    {
        return $this->MissionLength;
    }
}