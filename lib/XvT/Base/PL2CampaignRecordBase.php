<?php

namespace Pyrite\XvT\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;
use Pyrite\PyriteModel;

abstract class PL2CampaignRecordBase extends PyriteBase implements Byteable, PyriteModel
{
    use HexDecoder;
    use HexEncoder;

    /** @var int PL2CAMPAIGNRECORDLENGTH INT */
	public const PL2CAMPAIGNRECORDLENGTH = 32;
    /** @var int 0x0000 IDNumber INT */
	public int $IDNumber;
    /** @var int 0x0004 totalCountFlown INT */
	public int $totalCountFlown;
    /** @var int 0x0008 isMissionCompleteWithoutCheat INT */
	public int $isMissionCompleteWithoutCheat;
    /** @var int 0x000C bestScore INT */
	public int $bestScore;
    /** @var int 0x0010 bestEvaluationBadge INT */
	public int $bestEvaluationBadge;
    /** @var int 0x0014 bestTimeAsSeconds INT */
	public int $bestTimeAsSeconds;
    /** @var int 0x0018 isMissionComplete INT */
	public int $isMissionComplete;
    /** @var int 0x001C UIFrameTimerHelper INT */
	public int $UIFrameTimerHelper;
    
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

        $this->IDNumber = $this->getInt($hex, 0x0000);
        $this->totalCountFlown = $this->getInt($hex, 0x0004);
        $this->isMissionCompleteWithoutCheat = $this->getInt($hex, 0x0008);
        $this->bestScore = $this->getInt($hex, 0x000C);
        $this->bestEvaluationBadge = $this->getInt($hex, 0x0010);
        $this->bestTimeAsSeconds = $this->getInt($hex, 0x0014);
        $this->isMissionComplete = $this->getInt($hex, 0x0018);
        $this->UIFrameTimerHelper = $this->getInt($hex, 0x001C);
        

        $this->hex = substr($this->hex, 0, $this->getLength());
        $this->afterLoadHex();
        return $this;
    }
    
    public function __debugInfo(): array
    {
        return [
            "IDNumber" => $this->IDNumber,
            "totalCountFlown" => $this->totalCountFlown,
            "isMissionCompleteWithoutCheat" => $this->isMissionCompleteWithoutCheat,
            "bestScore" => $this->bestScore,
            "bestEvaluationBadge" => $this->bestEvaluationBadge,
            "bestTimeAsSeconds" => $this->bestTimeAsSeconds,
            "isMissionComplete" => $this->isMissionComplete,
            "UIFrameTimerHelper" => $this->UIFrameTimerHelper
        ];
    }
    
    public function toHexString($hex = null): string
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $hex = $this->writeInt($this->IDNumber, $hex, 0x0000);
        $hex = $this->writeInt($this->totalCountFlown, $hex, 0x0004);
        $hex = $this->writeInt($this->isMissionCompleteWithoutCheat, $hex, 0x0008);
        $hex = $this->writeInt($this->bestScore, $hex, 0x000C);
        $hex = $this->writeInt($this->bestEvaluationBadge, $hex, 0x0010);
        $hex = $this->writeInt($this->bestTimeAsSeconds, $hex, 0x0014);
        $hex = $this->writeInt($this->isMissionComplete, $hex, 0x0018);
        $hex = $this->writeInt($this->UIFrameTimerHelper, $hex, 0x001C);

        return $hex;
    }
    
    
    public function getLength(): int
    {
        return self::PL2CAMPAIGNRECORDLENGTH;
    }
}