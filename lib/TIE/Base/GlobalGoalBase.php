<?php

namespace Pyrite\TIE\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\PyriteBase;
use Pyrite\TIE\Trigger;

abstract class GlobalGoalBase extends PyriteBase implements Byteable
{
    use HexDecoder;

    /** @var integer */
    public const GLOBALGOALLENGTH = 28;
    /** @var Trigger[] */
    public $Triggers;
    /** @var boolean */
    public $Trigger1OrTrigger2;
    
    public function __construct($hex, $tie = null)
    {
        parent::__construct($hex, $tie);
        $this->beforeConstruct();
        $offset = 0;

        $this->Triggers = [];
        $offset = 0x00;
        for ($i = 0; $i < 2; $i++) {
            $t = new Trigger(substr($hex, $offset), $this->TIE);
            $this->Triggers[] = $t;
            $offset += $t->getLength();
        }
        $this->Trigger1OrTrigger2 = $this->getBool($hex, 0x19);
        
    }
    
    public function __debugInfo()
    {
        return [
            "Triggers" => $this->Triggers,
            "Trigger1OrTrigger2" => $this->Trigger1OrTrigger2
        ];
    }
    
    public function toHexString()
    {
        $hex = "";
        $offset = 0;

        $offset = 0x00;
        for ($i = 0; $i < 2; $i++) {
            $t = $this->Triggers[$i];
            $this->writeObject($hex, $t, $offset);
            $offset += $t->getLength();
        }
        $this->writeBool($hex, $this->Trigger1OrTrigger2, 0x19);

        return $hex;
    }
    
    
    public function getLength()
    {
        return self::GLOBALGOALLENGTH;
    }
}