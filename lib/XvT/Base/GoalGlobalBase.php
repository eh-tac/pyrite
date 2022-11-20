<?php

namespace Pyrite\XvT\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;
use Pyrite\XvT\Trigger;

abstract class GoalGlobalBase extends PyriteBase implements Byteable
{
    use HexDecoder;
    use HexEncoder;

    /** @var integer  GOALGLOBALLENGTH INT */
    public const GOALGLOBALLENGTH = 42;
    /** @var Trigger[] 0x00 TriggerA Trigger */
    public $TriggerA;
    /** @var boolean 0x0A Trigger1OrTrigger2 BOOL */
    public $Trigger1OrTrigger2;
    /** @var Trigger[] 0x0B TriggerB Trigger */
    public $TriggerB;
    /** @var boolean 0x15 Trigger2OrTrigger3 BOOL */
    public $Trigger2OrTrigger3;
    /** @var boolean 0x27 Trigger12OrTrigger34 BOOL */
    public $Trigger12OrTrigger34;
    /** @var integer 0x29 Points SBYTE */
    public $Points;
    
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

        $this->TriggerA = [];
        $offset = 0x00;
        for ($i = 0; $i < 2; $i++) {
            $t = (new Trigger(substr($hex, $offset), $this->TIE))->loadHex();
            $this->TriggerA[] = $t;
            $offset += $t->getLength();
        }
        $this->Trigger1OrTrigger2 = $this->getBool($hex, 0x0A);
        $this->TriggerB = [];
        $offset = 0x0B;
        for ($i = 0; $i < 2; $i++) {
            $t = (new Trigger(substr($hex, $offset), $this->TIE))->loadHex();
            $this->TriggerB[] = $t;
            $offset += $t->getLength();
        }
        $this->Trigger2OrTrigger3 = $this->getBool($hex, 0x15);
        $this->Trigger12OrTrigger34 = $this->getBool($hex, 0x27);
        $this->Points = $this->getSByte($hex, 0x29);
        
        return $this;
    }
    
    public function __debugInfo()
    {
        return [
            "TriggerA" => $this->TriggerA,
            "Trigger1OrTrigger2" => $this->Trigger1OrTrigger2,
            "TriggerB" => $this->TriggerB,
            "Trigger2OrTrigger3" => $this->Trigger2OrTrigger3,
            "Trigger12OrTrigger34" => $this->Trigger12OrTrigger34,
            "Points" => $this->Points
        ];
    }
    
    public function toHexString($hex = null)
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $offset = 0x00;
        for ($i = 0; $i < 2; $i++) {
            $t = $this->TriggerA[$i];
            [$hex, $offset] = $this->writeObject($t, $hex, $offset);
        }
        [$hex, $offset] = $this->writeBool($this->Trigger1OrTrigger2, $hex, 0x0A);
        $offset = 0x0B;
        for ($i = 0; $i < 2; $i++) {
            $t = $this->TriggerB[$i];
            [$hex, $offset] = $this->writeObject($t, $hex, $offset);
        }
        [$hex, $offset] = $this->writeBool($this->Trigger2OrTrigger3, $hex, 0x15);
        [$hex, $offset] = $this->writeBool($this->Trigger12OrTrigger34, $hex, 0x27);
        [$hex, $offset] = $this->writeSByte($this->Points, $hex, 0x29);

        return $hex;
    }
    
    
    public function getLength()
    {
        return self::GOALGLOBALLENGTH;
    }
}