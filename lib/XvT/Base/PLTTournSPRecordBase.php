<?php

namespace Pyrite\XvT\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;
use Pyrite\PyriteModel;

abstract class PLTTournSPRecordBase extends PyriteBase implements Byteable, PyriteModel
{
    use HexDecoder;
    use HexEncoder;

    /** @var int PLTTOURNSPRECORDLENGTH INT */
	public const PLTTOURNSPRECORDLENGTH = 40;
    /** @var int 0x0000 unknown0x0 INT */
	public int $unknown0x0;
    /** @var int 0x0004 totalCountFlown INT */
	public int $totalCountFlown;
    /** @var int 0x0008 numberOfFinishesAnyUNK INT */
	public int $numberOfFinishesAnyUNK;
    /** @var int 0x000C numberOfFinishesFirst INT */
	public int $numberOfFinishesFirst;
    /** @var int 0x0010 numberOfFinishesSecond INT */
	public int $numberOfFinishesSecond;
    /** @var int 0x0014 numberOfFinishesThird INT */
	public int $numberOfFinishesThird;
    /** @var int 0x0018 bestScore INT */
	public int $bestScore;
    /** @var int 0x001C bestFinish INT */
	public int $bestFinish;
    /** @var int 0x0020 bestEvaluationMedal INT */
	public int $bestEvaluationMedal;
    /** @var int 0x0024 bestFinishPointMargin INT */
	public int $bestFinishPointMargin;
    
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
        $this->numberOfFinishesAnyUNK = $this->getInt($hex, 0x0008);
        $this->numberOfFinishesFirst = $this->getInt($hex, 0x000C);
        $this->numberOfFinishesSecond = $this->getInt($hex, 0x0010);
        $this->numberOfFinishesThird = $this->getInt($hex, 0x0014);
        $this->bestScore = $this->getInt($hex, 0x0018);
        $this->bestFinish = $this->getInt($hex, 0x001C);
        $this->bestEvaluationMedal = $this->getInt($hex, 0x0020);
        $this->bestFinishPointMargin = $this->getInt($hex, 0x0024);
        

        $this->hex = substr($this->hex, 0, $this->getLength());
        return $this;
    }
    
    public function __debugInfo(): array
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
            "bestEvaluationMedal" => $this->bestEvaluationMedal,
            "bestFinishPointMargin" => $this->bestFinishPointMargin
        ];
    }
    
    public function toHexString($hex = null): string
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
        $hex = $this->writeInt($this->bestEvaluationMedal, $hex, 0x0020);
        $hex = $this->writeInt($this->bestFinishPointMargin, $hex, 0x0024);

        return $hex;
    }
    
    
    public function getLength(): int
    {
        return self::PLTTOURNSPRECORDLENGTH;
    }
}