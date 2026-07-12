<?php

namespace Pyrite\XWA\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;
use Pyrite\PyriteModel;

abstract class MissionDataBase extends PyriteBase implements Byteable, PyriteModel
{
    use HexDecoder;
    use HexEncoder;

    /** @var int MISSIONDATALENGTH INT */
	public const MISSIONDATALENGTH = 48;
    /** @var int 0x00 UnkA INT */
	public int $UnkA;
    /** @var int 0x04 AttemptCount INT */
	public int $AttemptCount;
    /** @var int 0x08 UnkB INT */
	public int $UnkB;
    /** @var int 0x0C UnkC INT */
	public int $UnkC;
    /** @var int 0x10 UnkD INT */
	public int $UnkD;
    /** @var int 0x14 WinCount INT */
	public int $WinCount;
    /** @var int 0x18 UnkE INT */
	public int $UnkE;
    /** @var int 0x1C Score INT */
	public int $Score;
    /** @var int 0x20 Time INT */
	public int $Time;
    /** @var int 0x24 UnkF INT */
	public int $UnkF;
    /** @var int 0x28 UnkG INT */
	public int $UnkG;
    /** @var int 0x2C BonusScoreTen INT */
	public int $BonusScoreTen;
    
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
        

        $this->hex = substr($this->hex, 0, $this->getLength());
        $this->afterLoadHex();
        return $this;
    }
    
    public function __debugInfo(): array
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
    
    public function toHexString($hex = null): string
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $hex = $this->writeInt($this->UnkA, $hex, 0x00);
        $hex = $this->writeInt($this->AttemptCount, $hex, 0x04);
        $hex = $this->writeInt($this->UnkB, $hex, 0x08);
        $hex = $this->writeInt($this->UnkC, $hex, 0x0C);
        $hex = $this->writeInt($this->UnkD, $hex, 0x10);
        $hex = $this->writeInt($this->WinCount, $hex, 0x14);
        $hex = $this->writeInt($this->UnkE, $hex, 0x18);
        $hex = $this->writeInt($this->Score, $hex, 0x1C);
        $hex = $this->writeInt($this->Time, $hex, 0x20);
        $hex = $this->writeInt($this->UnkF, $hex, 0x24);
        $hex = $this->writeInt($this->UnkG, $hex, 0x28);
        $hex = $this->writeInt($this->BonusScoreTen, $hex, 0x2C);

        return $hex;
    }
    
    
    public function getLength(): int
    {
        return self::MISSIONDATALENGTH;
    }
}