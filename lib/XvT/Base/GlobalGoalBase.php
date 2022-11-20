<?php

namespace Pyrite\XvT\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;
use Pyrite\XvT\GoalGlobal;

abstract class GlobalGoalBase extends PyriteBase implements Byteable
{
    use HexDecoder;
    use HexEncoder;

    /** @var integer  GLOBALGOALLENGTH INT */
    public const GLOBALGOALLENGTH = 128;
    /** @var integer 0x00 Reserved SHORT */
    public $Reserved; //(3)
    /** @var GoalGlobal[] 0x02 Goal GoalGlobal */
    public $Goal;
    
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

        $this->Reserved = $this->getShort($hex, 0x00);
        $this->Goal = [];
        $offset = 0x02;
        for ($i = 0; $i < 3; $i++) {
            $t = (new GoalGlobal(substr($hex, $offset), $this->TIE))->loadHex();
            $this->Goal[] = $t;
            $offset += $t->getLength();
        }
        
        return $this;
    }
    
    public function __debugInfo()
    {
        return [
            "Reserved" => $this->Reserved,
            "Goal" => $this->Goal
        ];
    }
    
    public function toHexString($hex = null)
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        [$hex, $offset] = $this->writeShort($this->Reserved, $hex, 0x00);
        $offset = 0x02;
        for ($i = 0; $i < 3; $i++) {
            $t = $this->Goal[$i];
            [$hex, $offset] = $this->writeObject($t, $hex, $offset);
        }

        return $hex;
    }
    
    
    public function getLength()
    {
        return self::GLOBALGOALLENGTH;
    }
}