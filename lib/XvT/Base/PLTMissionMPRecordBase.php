<?php

namespace Pyrite\XvT\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;
use Pyrite\PyriteModel;

abstract class PLTMissionMPRecordBase extends PyriteBase implements Byteable, PyriteModel
{
    use HexDecoder;
    use HexEncoder;

    /** @var int PLTMISSIONMPRECORDLENGTH INT */
	public const PLTMISSIONMPRECORDLENGTH = 48;
    /** @var int 0x0000 unknown0x0 INT */
	public int $unknown0x0;
    /** @var int 0x0004 totalCountFlown INT */
	public int $totalCountFlown;
    /** @var int 0x0008 totalCountFinishedFirst INT */
	public int $totalCountFinishedFirst;
    /** @var int 0x000C totalCountFinishedSecond INT */
	public int $totalCountFinishedSecond;
    /** @var int 0x0010 totalCountFinishedThird INT */
	public int $totalCountFinishedThird;
    /** @var int 0x0014 totalCountVictory INT */
	public int $totalCountVictory;
    /** @var int 0x0018 totalCountFailure INT */
	public int $totalCountFailure;
    /** @var int 0x001C bestScore INT */
	public int $bestScore;
    /** @var int 0x0020 bestTimeAsSeconds INT */
	public int $bestTimeAsSeconds;
    /** @var int 0x0024 bestFinishPlace INT */
	public int $bestFinishPlace;
    /** @var int 0x0028 bestEvaluationBadge INT */
	public int $bestEvaluationBadge;
    /** @var int 0x002C bestWinningMargin INT */
	public int $bestWinningMargin;
    
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

        $this->unknown0x0 = $this->getInt($hex, 0x0000);
        $this->totalCountFlown = $this->getInt($hex, 0x0004);
        $this->totalCountFinishedFirst = $this->getInt($hex, 0x0008);
        $this->totalCountFinishedSecond = $this->getInt($hex, 0x000C);
        $this->totalCountFinishedThird = $this->getInt($hex, 0x0010);
        $this->totalCountVictory = $this->getInt($hex, 0x0014);
        $this->totalCountFailure = $this->getInt($hex, 0x0018);
        $this->bestScore = $this->getInt($hex, 0x001C);
        $this->bestTimeAsSeconds = $this->getInt($hex, 0x0020);
        $this->bestFinishPlace = $this->getInt($hex, 0x0024);
        $this->bestEvaluationBadge = $this->getInt($hex, 0x0028);
        $this->bestWinningMargin = $this->getInt($hex, 0x002C);
        

        $this->hex = substr($this->hex, 0, $this->getLength());
        return $this;
    }
    
    public function __debugInfo(): array
    {
        return [
            "unknown0x0" => $this->unknown0x0,
            "totalCountFlown" => $this->totalCountFlown,
            "totalCountFinishedFirst" => $this->totalCountFinishedFirst,
            "totalCountFinishedSecond" => $this->totalCountFinishedSecond,
            "totalCountFinishedThird" => $this->totalCountFinishedThird,
            "totalCountVictory" => $this->totalCountVictory,
            "totalCountFailure" => $this->totalCountFailure,
            "bestScore" => $this->bestScore,
            "bestTimeAsSeconds" => $this->bestTimeAsSeconds,
            "bestFinishPlace" => $this->bestFinishPlace,
            "bestEvaluationBadge" => $this->bestEvaluationBadge,
            "bestWinningMargin" => $this->bestWinningMargin
        ];
    }
    
    public function toHexString($hex = null): string
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $hex = $this->writeInt($this->unknown0x0, $hex, 0x0000);
        $hex = $this->writeInt($this->totalCountFlown, $hex, 0x0004);
        $hex = $this->writeInt($this->totalCountFinishedFirst, $hex, 0x0008);
        $hex = $this->writeInt($this->totalCountFinishedSecond, $hex, 0x000C);
        $hex = $this->writeInt($this->totalCountFinishedThird, $hex, 0x0010);
        $hex = $this->writeInt($this->totalCountVictory, $hex, 0x0014);
        $hex = $this->writeInt($this->totalCountFailure, $hex, 0x0018);
        $hex = $this->writeInt($this->bestScore, $hex, 0x001C);
        $hex = $this->writeInt($this->bestTimeAsSeconds, $hex, 0x0020);
        $hex = $this->writeInt($this->bestFinishPlace, $hex, 0x0024);
        $hex = $this->writeInt($this->bestEvaluationBadge, $hex, 0x0028);
        $hex = $this->writeInt($this->bestWinningMargin, $hex, 0x002C);

        return $hex;
    }
    
    
    public function getLength(): int
    {
        return self::PLTMISSIONMPRECORDLENGTH;
    }
}