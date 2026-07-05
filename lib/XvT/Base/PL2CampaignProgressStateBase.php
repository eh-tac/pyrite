<?php

namespace Pyrite\XvT\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;
use Pyrite\PyriteModel;

abstract class PL2CampaignProgressStateBase extends PyriteBase implements Byteable, PyriteModel
{
    use HexDecoder;
    use HexEncoder;

    /** @var int PL2CAMPAIGNPROGRESSSTATELENGTH INT */
	public const PL2CAMPAIGNPROGRESSSTATELENGTH = 24;
    /** @var int 0x0000 unknown1 INT */
	public int $unknown1;
    /** @var int 0x0004 CurrentMissionNumber INT */
	public int $CurrentMissionNumber;
    /** @var int 0x0008 totalMissionCount INT */
	public int $totalMissionCount;
    /** @var int 0x000C CurrentMissionComplete INT */
	public int $CurrentMissionComplete;
    /** @var int 0x0010 PlayerCount INT */
	public int $PlayerCount;
    /** @var int 0x0014 totalScore INT */
	public int $totalScore;
    
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

        $this->unknown1 = $this->getInt($hex, 0x0000);
        $this->CurrentMissionNumber = $this->getInt($hex, 0x0004);
        $this->totalMissionCount = $this->getInt($hex, 0x0008);
        $this->CurrentMissionComplete = $this->getInt($hex, 0x000C);
        $this->PlayerCount = $this->getInt($hex, 0x0010);
        $this->totalScore = $this->getInt($hex, 0x0014);
        

        $this->hex = substr($this->hex, 0, $this->getLength());
        return $this;
    }
    
    public function __debugInfo(): array
    {
        return [
            "unknown1" => $this->unknown1,
            "CurrentMissionNumber" => $this->CurrentMissionNumber,
            "totalMissionCount" => $this->totalMissionCount,
            "CurrentMissionComplete" => $this->CurrentMissionComplete,
            "PlayerCount" => $this->PlayerCount,
            "totalScore" => $this->totalScore
        ];
    }
    
    public function toHexString($hex = null): string
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $hex = $this->writeInt($this->unknown1, $hex, 0x0000);
        $hex = $this->writeInt($this->CurrentMissionNumber, $hex, 0x0004);
        $hex = $this->writeInt($this->totalMissionCount, $hex, 0x0008);
        $hex = $this->writeInt($this->CurrentMissionComplete, $hex, 0x000C);
        $hex = $this->writeInt($this->PlayerCount, $hex, 0x0010);
        $hex = $this->writeInt($this->totalScore, $hex, 0x0014);

        return $hex;
    }
    
    
    public function getLength(): int
    {
        return self::PL2CAMPAIGNPROGRESSSTATELENGTH;
    }
}