<?php

namespace Pyrite\XWA\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;
use Pyrite\XWA\Trigger;

abstract class GoalGlobalBase extends PyriteBase implements Byteable
{
    use HexDecoder;
    use HexEncoder;

    /** @var integer  GOALGLOBALLENGTH INT */
    public const GOALGLOBALLENGTH = 122;
    /** @var Trigger 0x0000 Trigger1 Trigger */
    public $Trigger1;
    /** @var Trigger 0x0006 Trigger2 Trigger */
    public $Trigger2;
    /** @var boolean 0x000E Trigger1OrTrigger2 BOOL */
    public $Trigger1OrTrigger2;
    /** @var boolean 0x000F Unknown1 BOOL */
    public $Unknown1;
    /** @var Trigger 0x0010 Trigger3 Trigger */
    public $Trigger3;
    /** @var Trigger 0x0016 Trigger4 Trigger */
    public $Trigger4;
    /** @var boolean 0x001E Trigger3OrTrigger4 BOOL */
    public $Trigger3OrTrigger4;
    /** @var boolean 0x0027 Unknown2 BOOL */
    public $Unknown2;
    /** @var boolean 0x0031 Triggers12OrTriggers34 BOOL */
    public $Triggers12OrTriggers34;
    /** @var integer 0x0032 Unknown3 BYTE */
    public $Unknown3;
    /** @var integer 0x0033 Points SBYTE */
    public $Points;
    /** @var integer 0x0034 Unknown4 BYTE */
    public $Unknown4;
    /** @var integer 0x0035 Unknown5 BYTE */
    public $Unknown5;
    /** @var integer 0x0036 Unknown6 BYTE */
    public $Unknown6;
    /** @var integer 0x0038 ActiveSquence BYTE */
    public $ActiveSquence;
    
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

        $this->Trigger1 = (new Trigger(substr($hex, 0x0000), $this->TIE))->loadHex();
        $this->Trigger2 = (new Trigger(substr($hex, 0x0006), $this->TIE))->loadHex();
        $this->Trigger1OrTrigger2 = $this->getBool($hex, 0x000E);
        $this->Unknown1 = $this->getBool($hex, 0x000F);
        $this->Trigger3 = (new Trigger(substr($hex, 0x0010), $this->TIE))->loadHex();
        $this->Trigger4 = (new Trigger(substr($hex, 0x0016), $this->TIE))->loadHex();
        $this->Trigger3OrTrigger4 = $this->getBool($hex, 0x001E);
        $this->Unknown2 = $this->getBool($hex, 0x0027);
        $this->Triggers12OrTriggers34 = $this->getBool($hex, 0x0031);
        $this->Unknown3 = $this->getByte($hex, 0x0032);
        $this->Points = $this->getSByte($hex, 0x0033);
        $this->Unknown4 = $this->getByte($hex, 0x0034);
        $this->Unknown5 = $this->getByte($hex, 0x0035);
        $this->Unknown6 = $this->getByte($hex, 0x0036);
        $this->ActiveSquence = $this->getByte($hex, 0x0038);
        

        $this->hex = substr($this->hex, 0, $this->getLength());
        return $this;
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
    
    public function toHexString($hex = null)
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $hex = $this->writeObject($this->Trigger1, $hex, 0x0000);
        $hex = $this->writeObject($this->Trigger2, $hex, 0x0006);
        $hex = $this->writeBool($this->Trigger1OrTrigger2, $hex, 0x000E);
        $hex = $this->writeBool($this->Unknown1, $hex, 0x000F);
        $hex = $this->writeObject($this->Trigger3, $hex, 0x0010);
        $hex = $this->writeObject($this->Trigger4, $hex, 0x0016);
        $hex = $this->writeBool($this->Trigger3OrTrigger4, $hex, 0x001E);
        $hex = $this->writeBool($this->Unknown2, $hex, 0x0027);
        $hex = $this->writeBool($this->Triggers12OrTriggers34, $hex, 0x0031);
        $hex = $this->writeByte($this->Unknown3, $hex, 0x0032);
        $hex = $this->writeSByte($this->Points, $hex, 0x0033);
        $hex = $this->writeByte($this->Unknown4, $hex, 0x0034);
        $hex = $this->writeByte($this->Unknown5, $hex, 0x0035);
        $hex = $this->writeByte($this->Unknown6, $hex, 0x0036);
        $hex = $this->writeByte($this->ActiveSquence, $hex, 0x0038);

        return $hex;
    }
    
    
    public function getLength()
    {
        return self::GOALGLOBALLENGTH;
    }
}