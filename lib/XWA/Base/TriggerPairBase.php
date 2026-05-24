<?php

namespace Pyrite\XWA\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;
use Pyrite\XWA\Trigger;

abstract class TriggerPairBase extends PyriteBase implements Byteable
{
    use HexDecoder;
    use HexEncoder;

    /** @var integer  TRIGGERPAIRLENGTH INT */
    public const TRIGGERPAIRLENGTH = 16;
    /** @var Trigger 0x00 Trigger1 Trigger */
    public $Trigger1;
    /** @var Trigger 0x06 Trigger2 Trigger */
    public $Trigger2;
    /** @var boolean 0x0E T1OrT2 BOOL */
    public $T1OrT2;
    
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

        $this->Trigger1 = (new Trigger(substr($hex, 0x00), $this->TIE))->loadHex();
        $this->Trigger2 = (new Trigger(substr($hex, 0x06), $this->TIE))->loadHex();
        $this->T1OrT2 = $this->getBool($hex, 0x0E);
        

        $this->hex = substr($this->hex, 0, $this->getLength());
        return $this;
    }
    
    public function __debugInfo()
    {
        return [
            "Trigger1" => $this->Trigger1,
            "Trigger2" => $this->Trigger2,
            "T1OrT2" => $this->T1OrT2
        ];
    }
    
    public function toHexString($hex = null)
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $hex = $this->writeObject($this->Trigger1, $hex, 0x00);
        $hex = $this->writeObject($this->Trigger2, $hex, 0x06);
        $hex = $this->writeBool($this->T1OrT2, $hex, 0x0E);

        return $hex;
    }
    
    
    public function getLength()
    {
        return self::TRIGGERPAIRLENGTH;
    }
}