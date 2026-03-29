<?php

namespace Pyrite\XvT\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;

abstract class PLTBattleMPRecordBase extends PyriteBase implements Byteable
{
    use HexDecoder;
    use HexEncoder;

    /** @var integer  PLTBATTLEMPRECORDLENGTH INT */
    public const PLTBATTLEMPRECORDLENGTH = 40;
    /** @var integer 0x0000 unknown0x0 INT */
    public $unknown0x0;
    /** @var integer 0x0004 totalCountFlown INT */
    public $totalCountFlown;
    /** @var integer 0x0008 totalCountVictory INT */
    public $totalCountVictory;
    /** @var integer 0x000C totalCountFailure INT */
    public $totalCountFailure;
    /** @var integer 0x0010 totalCount10MissionMarathonUNK INT */
    public $totalCount10MissionMarathonUNK;
    /** @var integer 0x0014 bestScore INT */
    public $bestScore;
    /** @var integer 0x0018 unknown0x18 INT */
    public $unknown0x18;
    /** @var integer 0x001C unknown0x1C INT */
    public $unknown0x1C;
    /** @var integer 0x0020 bestEvaluationMedal INT */
    public $bestEvaluationMedal;
    /** @var integer 0x0024 bestVictoryMargin INT */
    public $bestVictoryMargin;
    
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
        $this->totalCount10MissionMarathonUNK = $this->getInt($hex, 0x0010);
        $this->bestScore = $this->getInt($hex, 0x0014);
        $this->unknown0x18 = $this->getInt($hex, 0x0018);
        $this->unknown0x1C = $this->getInt($hex, 0x001C);
        $this->bestEvaluationMedal = $this->getInt($hex, 0x0020);
        $this->bestVictoryMargin = $this->getInt($hex, 0x0024);
        

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
            "totalCount10MissionMarathonUNK" => $this->totalCount10MissionMarathonUNK,
            "bestScore" => $this->bestScore,
            "unknown0x18" => $this->unknown0x18,
            "unknown0x1C" => $this->unknown0x1C,
            "bestEvaluationMedal" => $this->bestEvaluationMedal,
            "bestVictoryMargin" => $this->bestVictoryMargin
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
        $hex = $this->writeInt($this->totalCount10MissionMarathonUNK, $hex, 0x0010);
        $hex = $this->writeInt($this->bestScore, $hex, 0x0014);
        $hex = $this->writeInt($this->unknown0x18, $hex, 0x0018);
        $hex = $this->writeInt($this->unknown0x1C, $hex, 0x001C);
        $hex = $this->writeInt($this->bestEvaluationMedal, $hex, 0x0020);
        $hex = $this->writeInt($this->bestVictoryMargin, $hex, 0x0024);

        return $hex;
    }
    
    
    public function getLength()
    {
        return self::PLTBATTLEMPRECORDLENGTH;
    }
}