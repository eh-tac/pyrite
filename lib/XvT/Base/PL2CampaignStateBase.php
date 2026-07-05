<?php

namespace Pyrite\XvT\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;
use Pyrite\PyriteModel;
use Pyrite\XvT\PL2CampaignProgressState;

abstract class PL2CampaignStateBase extends PyriteBase implements Byteable, PyriteModel
{
    use HexDecoder;
    use HexEncoder;

    /** @var int PL2CAMPAIGNSTATELENGTH INT */
	public const PL2CAMPAIGNSTATELENGTH = 40;
    /** @var int 0x0000 ConfigRandomSeed INT */
	public int $ConfigRandomSeed;
    /** @var int 0x0004 IsInProgressUNK INT */
	public int $IsInProgressUNK;
    /** @var int 0x0008 ConfigGameRandomizeLevel INT */
	public int $ConfigGameRandomizeLevel;
    /** @var PL2CampaignProgressState 0x000C saveState PL2CampaignProgressState */
	public PL2CampaignProgressState $saveState;
    /** @var int 0x0024 unknown2 INT */
	public int $unknown2;
    
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

        $this->ConfigRandomSeed = $this->getInt($hex, 0x0000);
        $this->IsInProgressUNK = $this->getInt($hex, 0x0004);
        $this->ConfigGameRandomizeLevel = $this->getInt($hex, 0x0008);
        $this->saveState = (new PL2CampaignProgressState(substr($hex, 0x000C), $this->TIE))->loadHex();
        $this->unknown2 = $this->getInt($hex, 0x0024);
        

        $this->hex = substr($this->hex, 0, $this->getLength());
        return $this;
    }
    
    public function __debugInfo(): array
    {
        return [
            "ConfigRandomSeed" => $this->ConfigRandomSeed,
            "IsInProgressUNK" => $this->IsInProgressUNK,
            "ConfigGameRandomizeLevel" => $this->ConfigGameRandomizeLevel,
            "saveState" => $this->saveState,
            "unknown2" => $this->unknown2
        ];
    }
    
    public function toHexString($hex = null): string
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $hex = $this->writeInt($this->ConfigRandomSeed, $hex, 0x0000);
        $hex = $this->writeInt($this->IsInProgressUNK, $hex, 0x0004);
        $hex = $this->writeInt($this->ConfigGameRandomizeLevel, $hex, 0x0008);
        $hex = $this->writeObject($this->saveState, $hex, 0x000C);
        $hex = $this->writeInt($this->unknown2, $hex, 0x0024);

        return $hex;
    }
    
    
    public function getLength(): int
    {
        return self::PL2CAMPAIGNSTATELENGTH;
    }
}