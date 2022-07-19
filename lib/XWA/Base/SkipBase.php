<?php

namespace Pyrite\XWA\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;
use Pyrite\XWA\Trigger;

abstract class SkipBase extends PyriteBase implements Byteable
{
    use HexDecoder;
    use HexEncoder;

    /** @var integer  SKIPLENGTH INT */
    public const SKIPLENGTH = 16;
    /** @var Trigger 0x0 Trigger1 Trigger */
    public $Trigger1;
    /** @var Trigger 0x6 Trigger2 Trigger */
    public $Trigger2;
    /** @var boolean 0xE Trigger1OrTrigger2 BOOL */
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

        $this->Trigger1 = (new Trigger(substr($hex, 0x0), $this->TIE))->loadHex();
        $this->Trigger2 = (new Trigger(substr($hex, 0x6), $this->TIE))->loadHex();
        $this->Trigger1OrTrigger2 = $this->getBool($hex, 0xE);
        

        $this->hex = substr($this->hex, 0, $this->getLength());
        return $this;
    }
    
    public function __debugInfo()
    {
        return [
            "Trigger1" => $this->Trigger1,
            "Trigger2" => $this->Trigger2,
            "Trigger1OrTrigger2" => $this->Trigger1OrTrigger2
        ];
    }
    
    public function toHexString($hex = null)
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $hex = $this->writeObject($this->Trigger1, $hex, 0x0);
        $hex = $this->writeObject($this->Trigger2, $hex, 0x6);
        $hex = $this->writeBool($this->Trigger1OrTrigger2, $hex, 0xE);

        return $hex;
    }
    
    
    public function getLength()
    {
        return self::SKIPLENGTH;
    }
}