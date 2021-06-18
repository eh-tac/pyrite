<?php

namespace Pyrite\XvT\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\PyriteBase;
use Pyrite\XvT\Trigger;

abstract class GoalGlobalBase extends PyriteBase implements Byteable
{
    use HexDecoder;

    /** @var integer */
    public const GOALGLOBALLENGTH = 42;
    /** @var Trigger[] */
    public $TriggerA;
    /** @var boolean */
    public $Trigger1OrTrigger2;
    /** @var Trigger[] */
    public $TriggerB;
    /** @var boolean */
    public $Trigger2OrTrigger3;
    /** @var boolean */
    public $Trigger12OrTrigger34;
    /** @var integer */
    public $Points;
    
    public function __construct($hex, $tie = null)
    {
        parent::__construct($hex, $tie);
        $this->beforeConstruct();
        $offset = 0;

        $this->TriggerA = [];
        $offset = 0x00;
        for ($i = 0; $i < 2; $i++) {
            $t = new Trigger(substr($hex, $offset), $this->TIE);
            $this->TriggerA[] = $t;
            $offset += $t->getLength();
        }
        $this->Trigger1OrTrigger2 = $this->getBool($hex, 0x0A);
        $this->TriggerB = [];
        $offset = 0x0B;
        for ($i = 0; $i < 2; $i++) {
            $t = new Trigger(substr($hex, $offset), $this->TIE);
            $this->TriggerB[] = $t;
            $offset += $t->getLength();
        }
        $this->Trigger2OrTrigger3 = $this->getBool($hex, 0x15);
        $this->Trigger12OrTrigger34 = $this->getBool($hex, 0x27);
        $this->Points = $this->getSByte($hex, 0x29);
        
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
    
    public function toHexString()
    {
        $hex = "";
        $offset = 0;

        $offset = 0x00;
        for ($i = 0; $i < 2; $i++) {
            $t = $this->TriggerA[$i];
            $this->writeObject($hex, $t, $offset);
            $offset += $t->getLength();
        }
        $this->writeBool($hex, $this->Trigger1OrTrigger2, 0x0A);
        $offset = 0x0B;
        for ($i = 0; $i < 2; $i++) {
            $t = $this->TriggerB[$i];
            $this->writeObject($hex, $t, $offset);
            $offset += $t->getLength();
        }
        $this->writeBool($hex, $this->Trigger2OrTrigger3, 0x15);
        $this->writeBool($hex, $this->Trigger12OrTrigger34, 0x27);
        $this->writeSByte($hex, $this->Points, 0x29);

        return $hex;
    }
    
    
    public function getLength()
    {
        return self::GOALGLOBALLENGTH;
    }
}