<?php

namespace Pyrite\XvT\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\PyriteBase;
use Pyrite\XvT\Constants;
use Pyrite\XvT\TeamStats;

abstract class PilotFileBase extends PyriteBase implements Byteable
{
    use HexDecoder;

    /** @var integer */
    public $PilotFileLength;
    /** @var string */
    public $Name;
    /** @var integer */
    public $TotalScore;
    /** @var integer */
    public $Kills;
    /** @var integer */
    public $LasersHit;
    /** @var integer */
    public $LasersTotal;
    /** @var integer */
    public $WarheadsHit;
    /** @var integer */
    public $WarheadsTotal;
    /** @var integer */
    public $CraftLosses;
    /** @var integer */
    public $PilotRating;
    /** @var string */
    public $RatingLabel;
    /** @var TeamStats */
    public $RebelStats;
    /** @var TeamStats */
    public $ImperialStats;
    
    public function __construct($hex, $tie = null)
    {
        parent::__construct($hex, $tie);
        $this->beforeConstruct();
        $offset = 0;

        $this->Name = $this->getChar($hex, 0x0000, 12);
        $this->TotalScore = $this->getInt($hex, 0x000E);
        $this->Kills = $this->getInt($hex, 0x035E);
        $this->LasersHit = $this->getInt($hex, 0x143E);
        $this->LasersTotal = $this->getInt($hex, 0x144A);
        $this->WarheadsHit = $this->getInt($hex, 0x1456);
        $this->WarheadsTotal = $this->getInt($hex, 0x1462);
        $this->CraftLosses = $this->getInt($hex, 0x146E);
        $this->PilotRating = $this->getInt($hex, 0x2326);
        $this->RatingLabel = $this->getChar($hex, 0x2392, 32);
        $this->RebelStats = new TeamStats(substr($hex, 0x3ef2), $this->TIE);
        $offset = 0x3ef2 + $this->RebelStats->getLength();
        $this->ImperialStats = new TeamStats(substr($hex, 0x12716), $this->TIE);
        $offset = 0x12716 + $this->ImperialStats->getLength();
        $this->PilotFileLength = $offset;
    }
    
    public function __debugInfo()
    {
        return [
            "Name" => $this->Name,
            "TotalScore" => $this->TotalScore,
            "Kills" => $this->Kills,
            "LasersHit" => $this->LasersHit,
            "LasersTotal" => $this->LasersTotal,
            "WarheadsHit" => $this->WarheadsHit,
            "WarheadsTotal" => $this->WarheadsTotal,
            "CraftLosses" => $this->CraftLosses,
            "PilotRating" => $this->getPilotRatingLabel(),
            "RatingLabel" => $this->RatingLabel,
            "RebelStats" => $this->RebelStats,
            "ImperialStats" => $this->ImperialStats
        ];
    }
    
    public function toHexString()
    {
        $hex = "";
        $offset = 0;

        $this->writeChar($hex, $this->Name, 0x0000);
        $this->writeInt($hex, $this->TotalScore, 0x000E);
        $this->writeInt($hex, $this->Kills, 0x035E);
        $this->writeInt($hex, $this->LasersHit, 0x143E);
        $this->writeInt($hex, $this->LasersTotal, 0x144A);
        $this->writeInt($hex, $this->WarheadsHit, 0x1456);
        $this->writeInt($hex, $this->WarheadsTotal, 0x1462);
        $this->writeInt($hex, $this->CraftLosses, 0x146E);
        $this->writeInt($hex, $this->PilotRating, 0x2326);
        $this->writeChar($hex, $this->RatingLabel, 0x2392);
        $this->writeObject($hex, $this->RebelStats, 0x3ef2);
        $this->writeObject($hex, $this->ImperialStats, 0x12716);

        return $hex;
    }
    
    public function getPilotRatingLabel() {
        return isset($this->PilotRating) && isset(Constants::$PILOTRATING[$this->PilotRating]) ? Constants::$PILOTRATING[$this->PilotRating] : "Unknown";
    }
    
    public function getLength()
    {
        return $this->PilotFileLength;
    }
}