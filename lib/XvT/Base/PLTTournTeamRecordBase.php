<?php

namespace Pyrite\XvT\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;

abstract class PLTTournTeamRecordBase extends PyriteBase implements Byteable
{
    use HexDecoder;
    use HexEncoder;

    /** @var integer  PLTTOURNTEAMRECORDLENGTH INT */
    public const PLTTOURNTEAMRECORDLENGTH = 20;
    /** @var integer 0x0000 teamParticipationState INT */
    public $teamParticipationState;
    /** @var integer 0x0004 totalTeamScore INT */
    public $totalTeamScore;
    /** @var integer 0x0008 numberOfMeleeRankingsFirst INT */
    public $numberOfMeleeRankingsFirst;
    /** @var integer 0x000C numberOfMeleeRankingsSecond INT */
    public $numberOfMeleeRankingsSecond;
    /** @var integer 0x0010 numberOfMeleeRankingsThird INT */
    public $numberOfMeleeRankingsThird;
    
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

        $this->teamParticipationState = $this->getInt($hex, 0x0000);
        $this->totalTeamScore = $this->getInt($hex, 0x0004);
        $this->numberOfMeleeRankingsFirst = $this->getInt($hex, 0x0008);
        $this->numberOfMeleeRankingsSecond = $this->getInt($hex, 0x000C);
        $this->numberOfMeleeRankingsThird = $this->getInt($hex, 0x0010);
        

        $this->hex = substr($this->hex, 0, $this->getLength());
        return $this;
    }
    
    public function __debugInfo()
    {
        return [
            "teamParticipationState" => $this->teamParticipationState,
            "totalTeamScore" => $this->totalTeamScore,
            "numberOfMeleeRankingsFirst" => $this->numberOfMeleeRankingsFirst,
            "numberOfMeleeRankingsSecond" => $this->numberOfMeleeRankingsSecond,
            "numberOfMeleeRankingsThird" => $this->numberOfMeleeRankingsThird
        ];
    }
    
    public function toHexString($hex = null)
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $hex = $this->writeInt($this->teamParticipationState, $hex, 0x0000);
        $hex = $this->writeInt($this->totalTeamScore, $hex, 0x0004);
        $hex = $this->writeInt($this->numberOfMeleeRankingsFirst, $hex, 0x0008);
        $hex = $this->writeInt($this->numberOfMeleeRankingsSecond, $hex, 0x000C);
        $hex = $this->writeInt($this->numberOfMeleeRankingsThird, $hex, 0x0010);

        return $hex;
    }
    
    
    public function getLength()
    {
        return self::PLTTOURNTEAMRECORDLENGTH;
    }
}