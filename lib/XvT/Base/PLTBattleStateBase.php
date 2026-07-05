<?php

namespace Pyrite\XvT\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;
use Pyrite\PyriteModel;
use Pyrite\XvT\PLTBattleProgressState;

abstract class PLTBattleStateBase extends PyriteBase implements Byteable, PyriteModel
{
    use HexDecoder;
    use HexEncoder;

    /** @var int PLTBATTLESTATELENGTH INT */
	public const PLTBATTLESTATELENGTH = 160;
    /** @var int 0x0000 ConfigRandomSeed INT */
	public int $ConfigRandomSeed;
    /** @var int 0x0004 IsInProgressUNK INT */
	public int $IsInProgressUNK;
    /** @var int 0x0008 ConfigBattleLength INT */
	public int $ConfigBattleLength;
    /** @var int 0x000C ConfigGameRandomizeLevel INT */
	public int $ConfigGameRandomizeLevel;
    /** @var PLTBattleProgressState 0x0010 saveState PLTBattleProgressState */
	public PLTBattleProgressState $saveState;
    /** @var int 0x009C unknown2 INT */
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
        $this->ConfigBattleLength = $this->getInt($hex, 0x0008);
        $this->ConfigGameRandomizeLevel = $this->getInt($hex, 0x000C);
        $this->saveState = (new PLTBattleProgressState(substr($hex, 0x0010), $this->TIE))->loadHex();
        $this->unknown2 = $this->getInt($hex, 0x009C);
        

        $this->hex = substr($this->hex, 0, $this->getLength());
        return $this;
    }
    
    public function __debugInfo(): array
    {
        return [
            "ConfigRandomSeed" => $this->ConfigRandomSeed,
            "IsInProgressUNK" => $this->IsInProgressUNK,
            "ConfigBattleLength" => $this->ConfigBattleLength,
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
        $hex = $this->writeInt($this->ConfigBattleLength, $hex, 0x0008);
        $hex = $this->writeInt($this->ConfigGameRandomizeLevel, $hex, 0x000C);
        $hex = $this->writeObject($this->saveState, $hex, 0x0010);
        $hex = $this->writeInt($this->unknown2, $hex, 0x009C);

        return $hex;
    }
    
    
    public function getLength(): int
    {
        return self::PLTBATTLESTATELENGTH;
    }
}