<?php

namespace Pyrite\XvT\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;
use Pyrite\PyriteModel;

abstract class PLTBattleSPRecordBase extends PyriteBase implements Byteable, PyriteModel
{
    use HexDecoder;
    use HexEncoder;

    /** @var int PLTBATTLESPRECORDLENGTH INT */
	public const PLTBATTLESPRECORDLENGTH = 36;
    /** @var int 0x0000 unknown0x0 INT */
	public int $unknown0x0;
    /** @var int 0x0004 totalCountFlown INT */
	public int $totalCountFlown;
    /** @var int 0x0008 totalCountVictory INT */
	public int $totalCountVictory;
    /** @var int 0x000C totalCountFailure INT */
	public int $totalCountFailure;
    /** @var int 0x0010 totalCount10MissionMarathonUNK INT */
	public int $totalCount10MissionMarathonUNK;
    /** @var int 0x0014 bestScore INT */
	public int $bestScore;
    /** @var int 0x0018 unknown0x18 INT */
	public int $unknown0x18;
    /** @var int 0x001C bestEvaluationMedal INT */
	public int $bestEvaluationMedal;
    /** @var int 0x0020 bestVictoryMargin INT */
	public int $bestVictoryMargin;
    
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
        $this->totalCountVictory = $this->getInt($hex, 0x0008);
        $this->totalCountFailure = $this->getInt($hex, 0x000C);
        $this->totalCount10MissionMarathonUNK = $this->getInt($hex, 0x0010);
        $this->bestScore = $this->getInt($hex, 0x0014);
        $this->unknown0x18 = $this->getInt($hex, 0x0018);
        $this->bestEvaluationMedal = $this->getInt($hex, 0x001C);
        $this->bestVictoryMargin = $this->getInt($hex, 0x0020);
        

        $this->hex = substr($this->hex, 0, $this->getLength());
        $this->afterLoadHex();
        return $this;
    }
    
    public function __debugInfo(): array
    {
        return [
            "unknown0x0" => $this->unknown0x0,
            "totalCountFlown" => $this->totalCountFlown,
            "totalCountVictory" => $this->totalCountVictory,
            "totalCountFailure" => $this->totalCountFailure,
            "totalCount10MissionMarathonUNK" => $this->totalCount10MissionMarathonUNK,
            "bestScore" => $this->bestScore,
            "unknown0x18" => $this->unknown0x18,
            "bestEvaluationMedal" => $this->bestEvaluationMedal,
            "bestVictoryMargin" => $this->bestVictoryMargin
        ];
    }
    
    public function toHexString($hex = null): string
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
        $hex = $this->writeInt($this->bestEvaluationMedal, $hex, 0x001C);
        $hex = $this->writeInt($this->bestVictoryMargin, $hex, 0x0020);

        return $hex;
    }
    
    
    public function getLength(): int
    {
        return self::PLTBATTLESPRECORDLENGTH;
    }
}