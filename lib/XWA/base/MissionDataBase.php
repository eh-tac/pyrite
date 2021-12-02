<?php

namespace Pyrite\XWA\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\PyriteBase;

abstract class MissionDataBase extends PyriteBase implements Byteable
{
    use HexDecoder;

    /** @var integer */
    public const MISSIONDATALENGTH = 48;
    /** @var integer */
    public $UnkA;
    /** @var integer */
    public $AttemptCount;
    /** @var integer */
    public $UnkB;
    /** @var integer */
    public $UnkC;
    /** @var integer */
    public $UnkD;
    /** @var integer */
    public $WinCount;
    /** @var integer */
    public $UnkE;
    /** @var integer */
    public $Score;
    /** @var integer */
    public $Time;
    /** @var integer */
    public $UnkF;
    /** @var integer */
    public $UnkG;
    /** @var integer */
    public $BonusScoreTen;
    
    public function __construct($hex, $tie = null)
    {
        parent::__construct($hex, $tie);
        $this->beforeConstruct();
        $offset = 0;

        $this->UnkA = $this->getInt($hex, 0x00);
        $this->AttemptCount = $this->getInt($hex, 0x04);
        $this->UnkB = $this->getInt($hex, 0x08);
        $this->UnkC = $this->getInt($hex, 0x0C);
        $this->UnkD = $this->getInt($hex, 0x10);
        $this->WinCount = $this->getInt($hex, 0x14);
        $this->UnkE = $this->getInt($hex, 0x18);
        $this->Score = $this->getInt($hex, 0x1C);
        $this->Time = $this->getInt($hex, 0x20);
        $this->UnkF = $this->getInt($hex, 0x24);
        $this->UnkG = $this->getInt($hex, 0x28);
        $this->BonusScoreTen = $this->getInt($hex, 0x2C);
        
    }
    
    public function __debugInfo()
    {
        return [
            "UnkA" => $this->UnkA,
            "AttemptCount" => $this->AttemptCount,
            "UnkB" => $this->UnkB,
            "UnkC" => $this->UnkC,
            "UnkD" => $this->UnkD,
            "WinCount" => $this->WinCount,
            "UnkE" => $this->UnkE,
            "Score" => $this->Score,
            "Time" => $this->Time,
            "UnkF" => $this->UnkF,
            "UnkG" => $this->UnkG,
            "BonusScoreTen" => $this->BonusScoreTen
        ];
    }
    
    public function toHexString()
    {
        $hex = "";
        $offset = 0;

        $this->writeInt($hex, $this->UnkA, 0x00);
        $this->writeInt($hex, $this->AttemptCount, 0x04);
        $this->writeInt($hex, $this->UnkB, 0x08);
        $this->writeInt($hex, $this->UnkC, 0x0C);
        $this->writeInt($hex, $this->UnkD, 0x10);
        $this->writeInt($hex, $this->WinCount, 0x14);
        $this->writeInt($hex, $this->UnkE, 0x18);
        $this->writeInt($hex, $this->Score, 0x1C);
        $this->writeInt($hex, $this->Time, 0x20);
        $this->writeInt($hex, $this->UnkF, 0x24);
        $this->writeInt($hex, $this->UnkG, 0x28);
        $this->writeInt($hex, $this->BonusScoreTen, 0x2C);

        return $hex;
    }
    
    
    public function getLength()
    {
        return self::MISSIONDATALENGTH;
    }
}