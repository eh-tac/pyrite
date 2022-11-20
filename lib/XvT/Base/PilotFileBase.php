<?php

namespace Pyrite\XvT\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;
use Pyrite\XvT\Constants;
use Pyrite\XvT\TeamStats;

abstract class PilotFileBase extends PyriteBase implements Byteable
{
    use HexDecoder;
    use HexEncoder;

    /** @var integer  PilotFileLength INT */
    public $PilotFileLength;
    /** @var string 0x0000 Name CHAR */
    public $Name;
    /** @var integer 0x000E TotalScore INT */
    public $TotalScore;
    /** @var integer 0x035E Kills INT */
    public $Kills;
    /** @var integer 0x143E LasersHit INT */
    public $LasersHit;
    /** @var integer 0x144A LasersTotal INT */
    public $LasersTotal;
    /** @var integer 0x1456 WarheadsHit INT */
    public $WarheadsHit;
    /** @var integer 0x1462 WarheadsTotal INT */
    public $WarheadsTotal;
    /** @var integer 0x146E CraftLosses INT */
    public $CraftLosses;
    /** @var integer 0x2326 PilotRating INT */
    public $PilotRating;
    /** @var string 0x2392 RatingLabel CHAR */
    public $RatingLabel;
    /** @var TeamStats 0x3ef2 RebelStats TeamStats */
    public $RebelStats;
    /** @var TeamStats 0x12716 ImperialStats TeamStats */
    public $ImperialStats;
    
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
        $this->RebelStats = (new TeamStats(substr($hex, 0x3ef2), $this->TIE))->loadHex();
        $this->ImperialStats = (new TeamStats(substr($hex, 0x12716), $this->TIE))->loadHex();
        $offset += $this->ImperialStats->getLength();
        $this->PilotFileLength = $offset;
        return $this;
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
    
    public function toHexString($hex = null)
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        [$hex, $offset] = $this->writeChar($this->Name, $hex, 0x0000);
        [$hex, $offset] = $this->writeInt($this->TotalScore, $hex, 0x000E);
        [$hex, $offset] = $this->writeInt($this->Kills, $hex, 0x035E);
        [$hex, $offset] = $this->writeInt($this->LasersHit, $hex, 0x143E);
        [$hex, $offset] = $this->writeInt($this->LasersTotal, $hex, 0x144A);
        [$hex, $offset] = $this->writeInt($this->WarheadsHit, $hex, 0x1456);
        [$hex, $offset] = $this->writeInt($this->WarheadsTotal, $hex, 0x1462);
        [$hex, $offset] = $this->writeInt($this->CraftLosses, $hex, 0x146E);
        [$hex, $offset] = $this->writeInt($this->PilotRating, $hex, 0x2326);
        [$hex, $offset] = $this->writeChar($this->RatingLabel, $hex, 0x2392);
        [$hex, $offset] = $this->writeObject($this->RebelStats, $hex, 0x3ef2);
        [$hex, $offset] = $this->writeObject($this->ImperialStats, $hex, 0x12716);

        return $hex;
    }
    
    public function getPilotRatingLabel() 
    {
        return isset($this->PilotRating) && isset(Constants::$PILOTRATING[$this->PilotRating]) ? Constants::$PILOTRATING[$this->PilotRating] : "Unknown";
    }
    
    public function getLength()
    {
        return $this->PilotFileLength;
    }
}