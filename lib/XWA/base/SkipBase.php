<?php

namespace Pyrite\XWA\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\PyriteBase;
use Pyrite\XWA\Trigger;

abstract class SkipBase extends PyriteBase implements Byteable
{
    use HexDecoder;

    /** @var integer */
    public const SKIPLENGTH = 16;
    /** @var Trigger */
    public $Trigger1;
    /** @var Trigger */
    public $Trigger2;
    /** @var boolean */
    public $Trigger1OrTrigger2;
    
    public function __construct($hex, $tie = null)
    {
        parent::__construct($hex, $tie);
        $this->beforeConstruct();
        $offset = 0;

        $this->Trigger1 = new Trigger(substr($hex, 0x0), $this->TIE);
        $this->Trigger2 = new Trigger(substr($hex, 0x6), $this->TIE);
        $this->Trigger1OrTrigger2 = $this->getBool($hex, 0xE);
        
    }
    
    public function __debugInfo()
    {
        return [
            "Trigger1" => $this->Trigger1,
            "Trigger2" => $this->Trigger2,
            "Trigger1OrTrigger2" => $this->Trigger1OrTrigger2
        ];
    }
    
    public function toHexString()
    {
        $hex = "";
        $offset = 0;

        $this->writeObject($hex, $this->Trigger1, 0x0);
        $this->writeObject($hex, $this->Trigger2, 0x6);
        $this->writeBool($hex, $this->Trigger1OrTrigger2, 0xE);

        return $hex;
    }
    
    
    public function getLength()
    {
        return self::SKIPLENGTH;
    }
}