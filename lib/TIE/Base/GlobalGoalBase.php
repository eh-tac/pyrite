<?php

namespace Pyrite\TIE\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;
use Pyrite\TIE\Trigger;

abstract class GlobalGoalBase extends PyriteBase implements Byteable
{
    use HexDecoder;
    use HexEncoder;

    /** @var integer  GLOBALGOALLENGTH INT */
    public const GLOBALGOALLENGTH = 28;
    /** @var Trigger[] 0x00 Triggers Trigger */
    public $Triggers;
    /** @var boolean 0x19 Trigger1OrTrigger2 BOOL */
    public $Trigger1OrTrigger2;
    
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

        $this->Triggers = [];
        $offset = 0x00;
        for ($i = 0; $i < 2; $i++) {
            $t = (new Trigger(substr($hex, $offset), $this->TIE))->loadHex();
            $this->Triggers[] = $t;
            $offset += $t->getLength();
        }
        $this->Trigger1OrTrigger2 = $this->getBool($hex, 0x19);
        
        return $this;
    }
    
    public function __debugInfo()
    {
        return [
            "Triggers" => $this->Triggers,
            "Trigger1OrTrigger2" => $this->Trigger1OrTrigger2
        ];
    }
    
    public function toHexString($hex = null)
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $offset = 0x00;
        for ($i = 0; $i < 2; $i++) {
            $t = $this->Triggers[$i];
            [$hex, $offset] = $this->writeObject($t, $hex, $offset);
        }
        [$hex, $offset] = $this->writeBool($this->Trigger1OrTrigger2, $hex, 0x19);

        return $hex;
    }
    
    
    public function getLength()
    {
        return self::GLOBALGOALLENGTH;
    }
}