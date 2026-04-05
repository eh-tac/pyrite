<?php

namespace Pyrite\XvT\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;
use Pyrite\XvT\PLTBattleProgressState;

abstract class PLTBattleStateBase extends PyriteBase implements Byteable
{
    use HexDecoder;
    use HexEncoder;

    /** @var integer  PLTBATTLESTATELENGTH INT */
    public const PLTBATTLESTATELENGTH = 160;
    /** @var integer 0x0000 ConfigRandomSeed INT */
    public $ConfigRandomSeed;
    /** @var integer 0x0004 IsInProgressUNK INT */
    public $IsInProgressUNK;
    /** @var integer 0x0008 ConfigBattleLength INT */
    public $ConfigBattleLength;
    /** @var integer 0x000C ConfigGameRandomizeLevel INT */
    public $ConfigGameRandomizeLevel;
    /** @var PLTBattleProgressState 0x0010 saveState PLTBattleProgressState */
    public $saveState;
    /** @var integer 0x009C unknown2 INT */
    public $unknown2;
    
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

        $this->ConfigRandomSeed = $this->getInt($hex, 0x0000);
        $this->IsInProgressUNK = $this->getInt($hex, 0x0004);
        $this->ConfigBattleLength = $this->getInt($hex, 0x0008);
        $this->ConfigGameRandomizeLevel = $this->getInt($hex, 0x000C);
        $this->saveState = (new PLTBattleProgressState(substr($hex, 0x0010), $this->TIE))->loadHex();
        $this->unknown2 = $this->getInt($hex, 0x009C);
        

        $this->hex = substr($this->hex, 0, $this->getLength());
        return $this;
    }
    
    public function __debugInfo()
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
    
    public function toHexString($hex = null)
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
    
    
    public function getLength()
    {
        return self::PLTBATTLESTATELENGTH;
    }
}