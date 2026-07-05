<?php

namespace Pyrite\XvT\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;
use Pyrite\PyriteModel;
use Pyrite\XvT\Constants;
use Pyrite\XvT\TeamStats;

abstract class PilotFileBase extends PyriteBase implements Byteable, PyriteModel
{
    use HexDecoder;
    use HexEncoder;

    /** @var int PILOTFILELENGTH INT */
	public const PILOTFILELENGTH = 96702;
    /** @var string 0x0000 Name CHAR */
	public string $Name;
    /** @var int 0x000E totalScore INT */
	public int $totalScore;
    /** @var int 0x035E Kills INT */
	public int $Kills;
    /** @var int 0x143E LasersHit INT */
	public int $LasersHit;
    /** @var int 0x144A LasersTotal INT */
	public int $LasersTotal;
    /** @var int 0x1456 WarheadsHit INT */
	public int $WarheadsHit;
    /** @var int 0x1462 WarheadsTotal INT */
	public int $WarheadsTotal;
    /** @var int 0x146E CraftLosses INT */
	public int $CraftLosses;
    /** @var int 0x2326 PilotRating INT */
	public int $PilotRating;
    /** @var string 0x2392 RatingLabel CHAR */
	public string $RatingLabel;
    /** @var TeamStats 0x3ef2 RebelStats TeamStats */
	public TeamStats $RebelStats;
    /** @var TeamStats 0x12716 ImperialStats TeamStats */
	public TeamStats $ImperialStats;
    
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

        $this->Name = $this->getChar($hex, 0x0000, 14);
        $this->totalScore = $this->getInt($hex, 0x000E);
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
        

        $this->hex = substr($this->hex, 0, $this->getLength());
        return $this;
    }
    
    public function __debugInfo(): array
    {
        return [
            "Name" => $this->Name,
            "totalScore" => $this->totalScore,
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
    
    public function toHexString($hex = null): string
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $hex = $this->writeChar($this->Name, $hex, 0x0000);
        $hex = $this->writeInt($this->totalScore, $hex, 0x000E);
        $hex = $this->writeInt($this->Kills, $hex, 0x035E);
        $hex = $this->writeInt($this->LasersHit, $hex, 0x143E);
        $hex = $this->writeInt($this->LasersTotal, $hex, 0x144A);
        $hex = $this->writeInt($this->WarheadsHit, $hex, 0x1456);
        $hex = $this->writeInt($this->WarheadsTotal, $hex, 0x1462);
        $hex = $this->writeInt($this->CraftLosses, $hex, 0x146E);
        $hex = $this->writeInt($this->PilotRating, $hex, 0x2326);
        $hex = $this->writeChar($this->RatingLabel, $hex, 0x2392);
        $hex = $this->writeObject($this->RebelStats, $hex, 0x3ef2);
        $hex = $this->writeObject($this->ImperialStats, $hex, 0x12716);

        return $hex;
    }
    
    public function getPilotRatingLabel(): string 
    {
        return isset($this->PilotRating) && isset(Constants::$PILOTRATING[$this->PilotRating]) ? Constants::$PILOTRATING[$this->PilotRating] : "Unknown";
    }
    
    public function getLength(): int
    {
        return self::PILOTFILELENGTH;
    }
}