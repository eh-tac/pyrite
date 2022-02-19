<?php

namespace Pyrite\XWA\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\PyriteBase;
use Pyrite\XWA\Trigger;

abstract class GoalGlobalBase extends PyriteBase implements Byteable
{
    use HexDecoder;

    /** @var integer */
    public const GOALGLOBALLENGTH = 122;
    /** @var Trigger */
    public $Trigger1;
    /** @var Trigger */
    public $Trigger2;
    /** @var boolean */
    public $Trigger1OrTrigger2;
    /** @var boolean */
    public $Unknown1;
    /** @var Trigger */
    public $Trigger3;
    /** @var Trigger */
    public $Trigger4;
    /** @var boolean */
    public $Trigger3OrTrigger4;
    /** @var boolean */
    public $Unknown2;
    /** @var boolean */
    public $Triggers12OrTriggers34;
    /** @var integer */
    public $Unknown3;
    /** @var integer */
    public $Points;
    /** @var integer */
    public $Unknown4;
    /** @var integer */
    public $Unknown5;
    /** @var integer */
    public $Unknown6;
    /** @var integer */
    public $ActiveSquence;
    
    public function __construct($hex, $tie = null)
    {
        parent::__construct($hex, $tie);
        $this->beforeConstruct();
        $offset = 0;

        $this->Trigger1 = new Trigger(substr($hex, 0x0000), $this->TIE);
        $this->Trigger2 = new Trigger(substr($hex, 0x0006), $this->TIE);
        $this->Trigger1OrTrigger2 = $this->getBool($hex, 0x000E);
        $this->Unknown1 = $this->getBool($hex, 0x000F);
        $this->Trigger3 = new Trigger(substr($hex, 0x0010), $this->TIE);
        $this->Trigger4 = new Trigger(substr($hex, 0x0016), $this->TIE);
        $this->Trigger3OrTrigger4 = $this->getBool($hex, 0x001E);
        $this->Unknown2 = $this->getBool($hex, 0x0027);
        $this->Triggers12OrTriggers34 = $this->getBool($hex, 0x0031);
        $this->Unknown3 = $this->getByte($hex, 0x0032);
        $this->Points = $this->getSByte($hex, 0x0033);
        $this->Unknown4 = $this->getByte($hex, 0x0034);
        $this->Unknown5 = $this->getByte($hex, 0x0035);
        $this->Unknown6 = $this->getByte($hex, 0x0036);
        $this->ActiveSquence = $this->getByte($hex, 0x0038);
        
    }
    
    public function __debugInfo()
    {
        return [
            "Trigger1" => $this->Trigger1,
            "Trigger2" => $this->Trigger2,
            "Trigger1OrTrigger2" => $this->Trigger1OrTrigger2,
            "Unknown1" => $this->Unknown1,
            "Trigger3" => $this->Trigger3,
            "Trigger4" => $this->Trigger4,
            "Trigger3OrTrigger4" => $this->Trigger3OrTrigger4,
            "Unknown2" => $this->Unknown2,
            "Triggers12OrTriggers34" => $this->Triggers12OrTriggers34,
            "Unknown3" => $this->Unknown3,
            "Points" => $this->Points,
            "Unknown4" => $this->Unknown4,
            "Unknown5" => $this->Unknown5,
            "Unknown6" => $this->Unknown6,
            "ActiveSquence" => $this->ActiveSquence
        ];
    }
    
    public function toHexString()
    {
        $hex = "";
        $offset = 0;

        $this->writeObject($hex, $this->Trigger1, 0x0000);
        $this->writeObject($hex, $this->Trigger2, 0x0006);
        $this->writeBool($hex, $this->Trigger1OrTrigger2, 0x000E);
        $this->writeBool($hex, $this->Unknown1, 0x000F);
        $this->writeObject($hex, $this->Trigger3, 0x0010);
        $this->writeObject($hex, $this->Trigger4, 0x0016);
        $this->writeBool($hex, $this->Trigger3OrTrigger4, 0x001E);
        $this->writeBool($hex, $this->Unknown2, 0x0027);
        $this->writeBool($hex, $this->Triggers12OrTriggers34, 0x0031);
        $this->writeByte($hex, $this->Unknown3, 0x0032);
        $this->writeSByte($hex, $this->Points, 0x0033);
        $this->writeByte($hex, $this->Unknown4, 0x0034);
        $this->writeByte($hex, $this->Unknown5, 0x0035);
        $this->writeByte($hex, $this->Unknown6, 0x0036);
        $this->writeByte($hex, $this->ActiveSquence, 0x0038);

        return $hex;
    }
    
    
    public function getLength()
    {
        return self::GOALGLOBALLENGTH;
    }
}