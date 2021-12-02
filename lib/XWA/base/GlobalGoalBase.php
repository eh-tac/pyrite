<?php

namespace Pyrite\XWA\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\PyriteBase;
use Pyrite\XWA\GoalGlobal;

abstract class GlobalGoalBase extends PyriteBase implements Byteable
{
    use HexDecoder;

    /** @var integer */
    public const GLOBALGOALLENGTH = 368;
    /** @var integer */
    public $Reserved; //(3)
    /** @var GoalGlobal[] */
    public $Unnamed;
    
    public function __construct($hex, $tie = null)
    {
        parent::__construct($hex, $tie);
        $this->beforeConstruct();
        $offset = 0;

        $this->Reserved = $this->getShort($hex, 0x00);
        $this->Unnamed = [];
        $offset = 0x02;
        for ($i = 0; $i < 3; $i++) {
            $t = new GoalGlobal(substr($hex, $offset), $this->TIE);
            $this->Unnamed[] = $t;
            $offset += $t->getLength();
        }
        
    }
    
    public function __debugInfo()
    {
        return [
            "Reserved" => $this->Reserved,
            "Unnamed" => $this->Unnamed
        ];
    }
    
    public function toHexString()
    {
        $hex = "";
        $offset = 0;

        $this->writeShort($hex, $this->Reserved, 0x00);
        $offset = 0x02;
        for ($i = 0; $i < 3; $i++) {
            $t = $this->Unnamed[$i];
            $this->writeObject($hex, $t, $offset);
            $offset += $t->getLength();
        }

        return $hex;
    }
    
    
    public function getLength()
    {
        return self::GLOBALGOALLENGTH;
    }
}