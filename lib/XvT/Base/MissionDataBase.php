<?php

namespace Pyrite\XvT\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\PyriteBase;
use Pyrite\XvT\Constants;

abstract class MissionDataBase extends PyriteBase implements Byteable
{
    use HexDecoder;

    /** @var integer */
    public const MISSIONDATALENGTH = 36;
    /** @var integer */
    public $AttemptCount;
    /** @var integer */
    public $WinCount;
    /** @var integer */
    public $LossCount;
    /** @var integer */
    public $BestScore;
    /** @var integer */
    public $BestTime;
    /** @var integer */
    public $BestTimeSecond;
    /** @var integer */
    public $BestRating;
    /** @var integer */
    public $Something;
    /** @var integer */
    public $Other;
    
    public function __construct($hex, $tie = null)
    {
        parent::__construct($hex, $tie);
        $this->beforeConstruct();
        $offset = 0;

        $this->AttemptCount = $this->getInt($hex, 0x00);
        $this->WinCount = $this->getInt($hex, 0x04);
        $this->LossCount = $this->getInt($hex, 0x08);
        $this->BestScore = $this->getInt($hex, 0x0C);
        $this->BestTime = $this->getInt($hex, 0x10);
        $this->BestTimeSecond = $this->getInt($hex, 0x14);
        $this->BestRating = $this->getInt($hex, 0x18);
        $this->Something = $this->getInt($hex, 0x1C);
        $this->Other = $this->getInt($hex, 0x20);
        
    }
    
    public function __debugInfo()
    {
        return [
            "AttemptCount" => $this->AttemptCount,
            "WinCount" => $this->WinCount,
            "LossCount" => $this->LossCount,
            "BestScore" => $this->BestScore,
            "BestTime" => $this->BestTime,
            "BestTimeSecond" => $this->BestTimeSecond,
            "BestRating" => $this->getBestRatingLabel(),
            "Something" => $this->Something,
            "Other" => $this->Other
        ];
    }
    
    public function toHexString()
    {
        $hex = "";
        $offset = 0;

        $this->writeInt($hex, $this->AttemptCount, 0x00);
        $this->writeInt($hex, $this->WinCount, 0x04);
        $this->writeInt($hex, $this->LossCount, 0x08);
        $this->writeInt($hex, $this->BestScore, 0x0C);
        $this->writeInt($hex, $this->BestTime, 0x10);
        $this->writeInt($hex, $this->BestTimeSecond, 0x14);
        $this->writeInt($hex, $this->BestRating, 0x18);
        $this->writeInt($hex, $this->Something, 0x1C);
        $this->writeInt($hex, $this->Other, 0x20);

        return $hex;
    }
    
    public function getBestRatingLabel() {
        return isset($this->BestRating) && isset(Constants::$BESTRATING[$this->BestRating]) ? Constants::$BESTRATING[$this->BestRating] : "Unknown";
    }
    
    public function getLength()
    {
        return self::MISSIONDATALENGTH;
    }
}