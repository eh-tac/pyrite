<?php

namespace Pyrite\XvT\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;
use Pyrite\PyriteModel;
use Pyrite\XvT\Constants;

abstract class MissionDataBase extends PyriteBase implements Byteable, PyriteModel
{
    use HexDecoder;
    use HexEncoder;

    /** @var int MISSIONDATALENGTH INT */
	public const MISSIONDATALENGTH = 36;
    /** @var int 0x00 AttemptCount INT */
	public int $AttemptCount;
    /** @var int 0x04 WinCount INT */
	public int $WinCount;
    /** @var int 0x08 LossCount INT */
	public int $LossCount;
    /** @var int 0x0C BestScore INT */
	public int $BestScore;
    /** @var int 0x10 BestTime INT */
	public int $BestTime;
    /** @var int 0x14 BestTimeSecond INT */
	public int $BestTimeSecond;
    /** @var int 0x18 BestRating INT */
	public int $BestRating;
    /** @var int 0x1C Something INT */
	public int $Something;
    /** @var int 0x20 Other INT */
	public int $Other;
    
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

        $this->AttemptCount = $this->getInt($hex, 0x00);
        $this->WinCount = $this->getInt($hex, 0x04);
        $this->LossCount = $this->getInt($hex, 0x08);
        $this->BestScore = $this->getInt($hex, 0x0C);
        $this->BestTime = $this->getInt($hex, 0x10);
        $this->BestTimeSecond = $this->getInt($hex, 0x14);
        $this->BestRating = $this->getInt($hex, 0x18);
        $this->Something = $this->getInt($hex, 0x1C);
        $this->Other = $this->getInt($hex, 0x20);
        

        $this->hex = substr($this->hex, 0, $this->getLength());
        return $this;
    }
    
    public function __debugInfo(): array
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
    
    public function toHexString($hex = null): string
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $hex = $this->writeInt($this->AttemptCount, $hex, 0x00);
        $hex = $this->writeInt($this->WinCount, $hex, 0x04);
        $hex = $this->writeInt($this->LossCount, $hex, 0x08);
        $hex = $this->writeInt($this->BestScore, $hex, 0x0C);
        $hex = $this->writeInt($this->BestTime, $hex, 0x10);
        $hex = $this->writeInt($this->BestTimeSecond, $hex, 0x14);
        $hex = $this->writeInt($this->BestRating, $hex, 0x18);
        $hex = $this->writeInt($this->Something, $hex, 0x1C);
        $hex = $this->writeInt($this->Other, $hex, 0x20);

        return $hex;
    }
    
    public function getBestRatingLabel(): string 
    {
        return isset($this->BestRating) && isset(Constants::$BESTRATING[$this->BestRating]) ? Constants::$BESTRATING[$this->BestRating] : "Unknown";
    }
    
    public function getLength(): int
    {
        return self::MISSIONDATALENGTH;
    }
}