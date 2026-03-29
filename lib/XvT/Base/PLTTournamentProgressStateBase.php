<?php

namespace Pyrite\XvT\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;
use Pyrite\XvT\PLTTournTeamRecord;

abstract class PLTTournamentProgressStateBase extends PyriteBase implements Byteable
{
    use HexDecoder;
    use HexEncoder;

    /** @var integer  PLTTOURNAMENTPROGRESSSTATELENGTH INT */
    public const PLTTOURNAMENTPROGRESSSTATELENGTH = 256;
    /** @var string 0x0000 unknown1 CHAR */
    public $unknown1;
    /** @var integer 0x0024 completedMissionCount INT */
    public $completedMissionCount;
    /** @var integer 0x0028 totalMissionCount INT */
    public $totalMissionCount;
    /** @var PLTTournTeamRecord[] 0x002C teamRecord PLTTournTeamRecord */
    public $teamRecord;
    /** @var integer 0x00F4 playersActive INT */
    public $playersActive;
    /** @var integer 0x00F8 teamsActive INT */
    public $teamsActive;
    /** @var integer 0x00FC unknown2 INT */
    public $unknown2;
    
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

        $this->unknown1 = $this->getChar($hex, 0x0000, 36);
        $this->completedMissionCount = $this->getInt($hex, 0x0024);
        $this->totalMissionCount = $this->getInt($hex, 0x0028);
        $this->teamRecord = [];
        $offset = 0x002C;
        for ($i = 0; $i < 10; $i++) {
            $t = (new PLTTournTeamRecord(substr($hex, $offset), $this->TIE))->loadHex();
            $this->teamRecord[] = $t;
            $offset += $t->getLength();
        }
        $this->playersActive = $this->getInt($hex, 0x00F4);
        $this->teamsActive = $this->getInt($hex, 0x00F8);
        $this->unknown2 = $this->getInt($hex, 0x00FC);
        

        $this->hex = substr($this->hex, 0, $this->getLength());
        return $this;
    }
    
    public function __debugInfo()
    {
        return [
            "unknown1" => $this->unknown1,
            "completedMissionCount" => $this->completedMissionCount,
            "totalMissionCount" => $this->totalMissionCount,
            "teamRecord" => $this->teamRecord,
            "playersActive" => $this->playersActive,
            "teamsActive" => $this->teamsActive,
            "unknown2" => $this->unknown2
        ];
    }
    
    public function toHexString($hex = null)
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $hex = $this->writeChar($this->unknown1, $hex, 0x0000);
        $hex = $this->writeInt($this->completedMissionCount, $hex, 0x0024);
        $hex = $this->writeInt($this->totalMissionCount, $hex, 0x0028);
        $offset = 0x002C;
        for ($i = 0; $i < 10; $i++) {
            $t = $this->teamRecord[$i];
            $hex = $this->writeObject($t, $hex, $offset);
            $offset += $t->getLength();
        }
        $hex = $this->writeInt($this->playersActive, $hex, 0x00F4);
        $hex = $this->writeInt($this->teamsActive, $hex, 0x00F8);
        $hex = $this->writeInt($this->unknown2, $hex, 0x00FC);

        return $hex;
    }
    
    
    public function getLength()
    {
        return self::PLTTOURNAMENTPROGRESSSTATELENGTH;
    }
}