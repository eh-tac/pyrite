<?php

namespace Pyrite\XvT\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;
use Pyrite\PyriteModel;

abstract class PLTEarnedMedalRecordBase extends PyriteBase implements Byteable, PyriteModel
{
    use HexDecoder;
    use HexEncoder;

    /** @var int PLTEARNEDMEDALRECORDLENGTH INT */
	public const PLTEARNEDMEDALRECORDLENGTH = 96;
    /** @var array<int> 0x0000 meleePlaqueCount INT */
	public array $meleePlaqueCount;
    /** @var array<int> 0x0018 tournamentPlaqueCount INT */
	public array $tournamentPlaqueCount;
    /** @var array<int> 0x0030 exerciseBadgeCount INT */
	public array $exerciseBadgeCount;
    /** @var array<int> 0x0048 battleMedalCount INT */
	public array $battleMedalCount;
    
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

        $this->meleePlaqueCount = [];
        $offset = 0x0000;
        for ($i = 0; $i < 6; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->meleePlaqueCount[] = $t;
            $offset += 4;
        }
        $this->tournamentPlaqueCount = [];
        $offset = 0x0018;
        for ($i = 0; $i < 6; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->tournamentPlaqueCount[] = $t;
            $offset += 4;
        }
        $this->exerciseBadgeCount = [];
        $offset = 0x0030;
        for ($i = 0; $i < 6; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->exerciseBadgeCount[] = $t;
            $offset += 4;
        }
        $this->battleMedalCount = [];
        $offset = 0x0048;
        for ($i = 0; $i < 6; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->battleMedalCount[] = $t;
            $offset += 4;
        }
        

        $this->hex = substr($this->hex, 0, $this->getLength());
        return $this;
    }
    
    public function __debugInfo(): array
    {
        return [
            "meleePlaqueCount" => $this->meleePlaqueCount,
            "tournamentPlaqueCount" => $this->tournamentPlaqueCount,
            "exerciseBadgeCount" => $this->exerciseBadgeCount,
            "battleMedalCount" => $this->battleMedalCount
        ];
    }
    
    public function toHexString($hex = null): string
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $offset = 0x0000;
        for ($i = 0; $i < 6; $i++) {
            $t = $this->meleePlaqueCount[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $offset = 0x0018;
        for ($i = 0; $i < 6; $i++) {
            $t = $this->tournamentPlaqueCount[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $offset = 0x0030;
        for ($i = 0; $i < 6; $i++) {
            $t = $this->exerciseBadgeCount[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $offset = 0x0048;
        for ($i = 0; $i < 6; $i++) {
            $t = $this->battleMedalCount[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }

        return $hex;
    }
    
    
    public function getLength(): int
    {
        return self::PLTEARNEDMEDALRECORDLENGTH;
    }
}