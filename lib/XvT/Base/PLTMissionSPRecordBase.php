<?php

namespace Pyrite\XvT\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;

abstract class PLTMissionSPRecordBase extends PyriteBase implements Byteable
{
    use HexDecoder;
    use HexEncoder;

    /** @var integer  PLTMISSIONSPRECORDLENGTH INT */
    public const PLTMISSIONSPRECORDLENGTH = 36;
    /** @var integer 0x0000 unknown0x0 INT */
    public $unknown0x0;
    /** @var integer 0x0004 totalCountFlown INT */
    public $totalCountFlown;
    /** @var integer 0x0008 totalCountVictory INT */
    public $totalCountVictory;
    /** @var integer 0x000C totalCountFailure INT */
    public $totalCountFailure;
    /** @var integer 0x0010 bestScore INT */
    public $bestScore;
    /** @var integer 0x0014 bestTimeAsSeconds INT */
    public $bestTimeAsSeconds;
    /** @var integer 0x0018 bestFinishRank INT */
    public $bestFinishRank;
    /** @var integer 0x001C bestEvaluationBadge INT */
    public $bestEvaluationBadge;
    /** @var integer 0x0020 bestWinningMargin INT */
    public $bestWinningMargin;
    
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

        $this->unknown0x0 = $this->getInt($hex, 0x0000);
        $this->totalCountFlown = $this->getInt($hex, 0x0004);
        $this->totalCountVictory = $this->getInt($hex, 0x0008);
        $this->totalCountFailure = $this->getInt($hex, 0x000C);
        $this->bestScore = $this->getInt($hex, 0x0010);
        $this->bestTimeAsSeconds = $this->getInt($hex, 0x0014);
        $this->bestFinishRank = $this->getInt($hex, 0x0018);
        $this->bestEvaluationBadge = $this->getInt($hex, 0x001C);
        $this->bestWinningMargin = $this->getInt($hex, 0x0020);
        

        $this->hex = substr($this->hex, 0, $this->getLength());
        return $this;
    }
    
    public function __debugInfo()
    {
        return [
            "unknown0x0" => $this->unknown0x0,
            "totalCountFlown" => $this->totalCountFlown,
            "totalCountVictory" => $this->totalCountVictory,
            "totalCountFailure" => $this->totalCountFailure,
            "bestScore" => $this->bestScore,
            "bestTimeAsSeconds" => $this->bestTimeAsSeconds,
            "bestFinishRank" => $this->bestFinishRank,
            "bestEvaluationBadge" => $this->bestEvaluationBadge,
            "bestWinningMargin" => $this->bestWinningMargin
        ];
    }
    
    public function toHexString($hex = null)
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $hex = $this->writeInt($this->unknown0x0, $hex, 0x0000);
        $hex = $this->writeInt($this->totalCountFlown, $hex, 0x0004);
        $hex = $this->writeInt($this->totalCountVictory, $hex, 0x0008);
        $hex = $this->writeInt($this->totalCountFailure, $hex, 0x000C);
        $hex = $this->writeInt($this->bestScore, $hex, 0x0010);
        $hex = $this->writeInt($this->bestTimeAsSeconds, $hex, 0x0014);
        $hex = $this->writeInt($this->bestFinishRank, $hex, 0x0018);
        $hex = $this->writeInt($this->bestEvaluationBadge, $hex, 0x001C);
        $hex = $this->writeInt($this->bestWinningMargin, $hex, 0x0020);

        return $hex;
    }
    
    
    public function getLength()
    {
        return self::PLTMISSIONSPRECORDLENGTH;
    }
}