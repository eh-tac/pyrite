<?php

namespace Pyrite\XvT\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;

abstract class PLTEarnedMedalRecordBase extends PyriteBase implements Byteable
{
    use HexDecoder;
    use HexEncoder;

    /** @var integer  PLTEARNEDMEDALRECORDLENGTH INT */
    public const PLTEARNEDMEDALRECORDLENGTH = 96;
    /** @var integer[] 0x0000 meleePlaqueCount INT */
    public $meleePlaqueCount;
    /** @var integer[] 0x0018 tournamentPlaqueCount INT */
    public $tournamentPlaqueCount;
    /** @var integer[] 0x0030 exerciseBadgeCount INT */
    public $exerciseBadgeCount;
    /** @var integer[] 0x0048 battleMedalCount INT */
    public $battleMedalCount;
    
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
    
    public function __debugInfo()
    {
        return [
            "meleePlaqueCount" => $this->meleePlaqueCount,
            "tournamentPlaqueCount" => $this->tournamentPlaqueCount,
            "exerciseBadgeCount" => $this->exerciseBadgeCount,
            "battleMedalCount" => $this->battleMedalCount
        ];
    }
    
    public function toHexString($hex = null)
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
    
    
    public function getLength()
    {
        return self::PLTEARNEDMEDALRECORDLENGTH;
    }
}