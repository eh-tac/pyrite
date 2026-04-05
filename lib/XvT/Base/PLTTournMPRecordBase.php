<?php

namespace Pyrite\XvT\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;

abstract class PLTTournMPRecordBase extends PyriteBase implements Byteable
{
    use HexDecoder;
    use HexEncoder;

    /** @var integer  PLTTOURNMPRECORDLENGTH INT */
    public const PLTTOURNMPRECORDLENGTH = 44;
    /** @var integer 0x0000 unknown0x0 INT */
    public $unknown0x0;
    /** @var integer 0x0004 totalCountFlown INT */
    public $totalCountFlown;
    /** @var integer 0x0008 numberOfFinishesAnyUNK INT */
    public $numberOfFinishesAnyUNK;
    /** @var integer 0x000C numberOfFinishesFirst INT */
    public $numberOfFinishesFirst;
    /** @var integer 0x0010 numberOfFinishesSecond INT */
    public $numberOfFinishesSecond;
    /** @var integer 0x0014 numberOfFinishesThird INT */
    public $numberOfFinishesThird;
    /** @var integer 0x0018 bestScore INT */
    public $bestScore;
    /** @var integer 0x001C bestFinish INT */
    public $bestFinish;
    /** @var integer 0x0020 unknown0x20 INT */
    public $unknown0x20;
    /** @var integer 0x0024 bestEvaluationMedal INT */
    public $bestEvaluationMedal;
    /** @var integer 0x0028 bestFinishPointMargin INT */
    public $bestFinishPointMargin;
    
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
        $this->numberOfFinishesAnyUNK = $this->getInt($hex, 0x0008);
        $this->numberOfFinishesFirst = $this->getInt($hex, 0x000C);
        $this->numberOfFinishesSecond = $this->getInt($hex, 0x0010);
        $this->numberOfFinishesThird = $this->getInt($hex, 0x0014);
        $this->bestScore = $this->getInt($hex, 0x0018);
        $this->bestFinish = $this->getInt($hex, 0x001C);
        $this->unknown0x20 = $this->getInt($hex, 0x0020);
        $this->bestEvaluationMedal = $this->getInt($hex, 0x0024);
        $this->bestFinishPointMargin = $this->getInt($hex, 0x0028);
        

        $this->hex = substr($this->hex, 0, $this->getLength());
        return $this;
    }
    
    public function __debugInfo()
    {
        return [
            "unknown0x0" => $this->unknown0x0,
            "totalCountFlown" => $this->totalCountFlown,
            "numberOfFinishesAnyUNK" => $this->numberOfFinishesAnyUNK,
            "numberOfFinishesFirst" => $this->numberOfFinishesFirst,
            "numberOfFinishesSecond" => $this->numberOfFinishesSecond,
            "numberOfFinishesThird" => $this->numberOfFinishesThird,
            "bestScore" => $this->bestScore,
            "bestFinish" => $this->bestFinish,
            "unknown0x20" => $this->unknown0x20,
            "bestEvaluationMedal" => $this->bestEvaluationMedal,
            "bestFinishPointMargin" => $this->bestFinishPointMargin
        ];
    }
    
    public function toHexString($hex = null)
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $hex = $this->writeInt($this->unknown0x0, $hex, 0x0000);
        $hex = $this->writeInt($this->totalCountFlown, $hex, 0x0004);
        $hex = $this->writeInt($this->numberOfFinishesAnyUNK, $hex, 0x0008);
        $hex = $this->writeInt($this->numberOfFinishesFirst, $hex, 0x000C);
        $hex = $this->writeInt($this->numberOfFinishesSecond, $hex, 0x0010);
        $hex = $this->writeInt($this->numberOfFinishesThird, $hex, 0x0014);
        $hex = $this->writeInt($this->bestScore, $hex, 0x0018);
        $hex = $this->writeInt($this->bestFinish, $hex, 0x001C);
        $hex = $this->writeInt($this->unknown0x20, $hex, 0x0020);
        $hex = $this->writeInt($this->bestEvaluationMedal, $hex, 0x0024);
        $hex = $this->writeInt($this->bestFinishPointMargin, $hex, 0x0028);

        return $hex;
    }
    
    
    public function getLength()
    {
        return self::PLTTOURNMPRECORDLENGTH;
    }
}