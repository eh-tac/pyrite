<?php

namespace Pyrite\XvT\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;

abstract class PLTPlayerRankCountRecordBase extends PyriteBase implements Byteable
{
    use HexDecoder;
    use HexEncoder;

    /** @var integer  PLTPLAYERRANKCOUNTRECORDLENGTH INT */
    public const PLTPLAYERRANKCOUNTRECORDLENGTH = 300;
    /** @var integer[] 0x0000 exercise INT */
    public $exercise;
    /** @var integer[] 0x0064 melee INT */
    public $melee;
    /** @var integer[] 0x00C8 combat INT */
    public $combat;
    
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

        $this->exercise = [];
        $offset = 0x0000;
        for ($i = 0; $i < 25; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->exercise[] = $t;
            $offset += 4;
        }
        $this->melee = [];
        $offset = 0x0064;
        for ($i = 0; $i < 25; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->melee[] = $t;
            $offset += 4;
        }
        $this->combat = [];
        $offset = 0x00C8;
        for ($i = 0; $i < 25; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->combat[] = $t;
            $offset += 4;
        }
        

        $this->hex = substr($this->hex, 0, $this->getLength());
        return $this;
    }
    
    public function __debugInfo()
    {
        return [
            "exercise" => $this->exercise,
            "melee" => $this->melee,
            "combat" => $this->combat
        ];
    }
    
    public function toHexString($hex = null)
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $offset = 0x0000;
        for ($i = 0; $i < 25; $i++) {
            $t = $this->exercise[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $offset = 0x0064;
        for ($i = 0; $i < 25; $i++) {
            $t = $this->melee[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $offset = 0x00C8;
        for ($i = 0; $i < 25; $i++) {
            $t = $this->combat[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }

        return $hex;
    }
    
    
    public function getLength()
    {
        return self::PLTPLAYERRANKCOUNTRECORDLENGTH;
    }
}