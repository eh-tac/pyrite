<?php

namespace Pyrite\TIE\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\PyriteBase;
use Pyrite\TIE\Briefing;
use Pyrite\TIE\FileHeader;
use Pyrite\TIE\FlightGroup;
use Pyrite\TIE\GlobalGoal;
use Pyrite\TIE\Message;
use Pyrite\TIE\PostMissionQuestions;
use Pyrite\TIE\PreMissionQuestions;

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
    /** @var Briefing */
    public $Briefing;
    /** @var PreMissionQuestions[] */
    public $PreMissionQuestions;
    /** @var PostMissionQuestions[] */
    public $PostMissionQuestions;
    /** @var integer */
    public const End = 255;
    
    public function __construct($hex, $tie = null)
    {
        parent::__construct($hex, $tie);
        $this->beforeConstruct();
        $offset = 0;

        $this->FileHeader = new FileHeader(substr($hex, 0x000), $this->TIE);
        $this->FlightGroups = [];
        $offset = 0x1CA;
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
        for ($i = 0; $i < 3; $i++) {
            $t = new GlobalGoal(substr($hex, $offset), $this->TIE);
            $this->GlobalGoals[] = $t;
            $offset += $t->getLength();
        }
        $this->Briefing = new Briefing(substr($hex, $offset), $this->TIE);
        $offset += $this->Briefing->getLength();
        $this->PreMissionQuestions = [];
        $offset = $offset;
        for ($i = 0; $i < 10; $i++) {
            $t = new PreMissionQuestions(substr($hex, $offset), $this->TIE);
            $this->PreMissionQuestions[] = $t;
            $offset += $t->getLength();
        }
        $this->PostMissionQuestions = [];
        $offset = $offset;
        for ($i = 0; $i < 10; $i++) {
            $t = new PostMissionQuestions(substr($hex, $offset), $this->TIE);
            $this->PostMissionQuestions[] = $t;
            $offset += $t->getLength();
        }
        // static BYTE value End = 255
        $offset += 1;
        $this->MissionLength = $offset;
    }
    
    public function __debugInfo()
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
    
    public function toHexString()
    {
        $hex = "";
        $offset = 0;

        $this->writeObject($hex, $this->FileHeader, 0x000);
        $offset = 0x1CA;
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
        for ($i = 0; $i < 3; $i++) {
            $t = $this->GlobalGoals[$i];
            $this->writeObject($hex, $t, $offset);
            $offset += $t->getLength();
        }
        $this->writeObject($hex, $this->Briefing, $offset);
        $offset = $offset;
        for ($i = 0; $i < 10; $i++) {
            $t = $this->PreMissionQuestions[$i];
            $this->writeObject($hex, $t, $offset);
            $offset += $t->getLength();
        }
        $offset = $offset;
        for ($i = 0; $i < 10; $i++) {
            $t = $this->PostMissionQuestions[$i];
            $this->writeObject($hex, $t, $offset);
            $offset += $t->getLength();
        }
        $this->writeByte($hex, 255, $offset);

        return $hex;
    }
    
    
    public function getLength()
    {
        return $this->MissionLength;
    }
}