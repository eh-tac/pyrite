<?php

namespace Pyrite\XWA\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;

abstract class MissionDataBase extends PyriteBase implements Byteable
{
    use HexDecoder;
    use HexEncoder;

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

        $hex .= $this->writeInt($this->UnkA, 0x00);
        $hex .= $this->writeInt($this->AttemptCount, 0x04);
        $hex .= $this->writeInt($this->UnkB, 0x08);
        $hex .= $this->writeInt($this->UnkC, 0x0C);
        $hex .= $this->writeInt($this->UnkD, 0x10);
        $hex .= $this->writeInt($this->WinCount, 0x14);
        $hex .= $this->writeInt($this->UnkE, 0x18);
        $hex .= $this->writeInt($this->Score, 0x1C);
        $hex .= $this->writeInt($this->Time, 0x20);
        $hex .= $this->writeInt($this->UnkF, 0x24);
        $hex .= $this->writeInt($this->UnkG, 0x28);
        $hex .= $this->writeInt($this->BonusScoreTen, 0x2C);

        return $hex;
    }


    public function getLength()
    {
        return self::MISSIONDATALENGTH;
    }

    public function empty()
    {
        $this->UnkA = $this->UnkB = $this->UnkC = $this->UnkD = $this->UnkE = $this->UnkF = $this->UnkG = 0;
        $this->AttemptCount = 0;
        $this->WinCount = 0;
        $this->Score = 0;
        $this->Time = 0;
        $this->BonusScoreTen = 0;
        return $this;
    }

    public function skip()
    {
        $this->WinCount = 1;
        return $this;
    }
}
