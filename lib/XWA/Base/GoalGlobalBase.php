<?php

namespace Pyrite\XWA\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;
use Pyrite\XWA\TriggerPair;

abstract class GoalGlobalBase extends PyriteBase implements Byteable
{
    use HexDecoder;
    use HexEncoder;

    /** @var integer  GOALGLOBALLENGTH INT */
    public const GOALGLOBALLENGTH = 122;
    /** @var TriggerPair[] 0x00 Triggers TriggerPair */
    public $Triggers; //(contained Unknown1)
    /** @var string 0x20 Name STR */
    public $Name; //(contains Unknown2)
    /** @var integer 0x30 Version BYTE */
    public $Version;
    /** @var boolean 0x31 Triggers12OrTriggers34 BOOL */
    public $Triggers12OrTriggers34;
    /** @var integer 0x32 Delay BYTE */
    public $Delay; //(was Unknown3)
    /** @var integer 0x33 Points SBYTE */
    public $Points;
    /** @var integer[] 0x34 PointsPerTrigger BYTE */
    public $PointsPerTrigger; //(was Unknown4-6)
    /** @var integer 0x38 ActiveSquence BYTE */
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

        $this->Triggers = [];
        $offset = 0x00;
        for ($i = 0; $i < 2; $i++) {
            $t = (new TriggerPair(substr($hex, $offset), $this->TIE))->loadHex();
            $this->Triggers[] = $t;
            $offset += $t->getLength();
        }
        $this->Name = $this->getString($hex, 0x20);
        $this->Version = $this->getByte($hex, 0x30);
        $this->Triggers12OrTriggers34 = $this->getBool($hex, 0x31);
        $this->Delay = $this->getByte($hex, 0x32);
        $this->Points = $this->getSByte($hex, 0x33);
        $this->PointsPerTrigger = [];
        $offset = 0x34;
        for ($i = 0; $i < 4; $i++) {
            $t = $this->getByte($hex, $offset);
            $this->PointsPerTrigger[] = $t;
            $offset += 1;
        }
        $this->ActiveSquence = $this->getByte($hex, 0x38);
        

        $this->hex = substr($this->hex, 0, $this->getLength());
        return $this;
    }
    
    public function __debugInfo()
    {
        return [
            "Triggers" => $this->Triggers,
            "Name" => $this->Name,
            "Version" => $this->Version,
            "Triggers12OrTriggers34" => $this->Triggers12OrTriggers34,
            "Delay" => $this->Delay,
            "Points" => $this->Points,
            "PointsPerTrigger" => $this->PointsPerTrigger,
            "ActiveSquence" => $this->ActiveSquence
        ];
    }
    
    public function toHexString($hex = null)
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $offset = 0x00;
        for ($i = 0; $i < 2; $i++) {
            $t = $this->Triggers[$i];
            $hex = $this->writeObject($t, $hex, $offset);
            $offset += $t->getLength();
        }
        $hex = $this->writeString($this->Name, $hex, 0x20);
        $hex = $this->writeByte($this->Version, $hex, 0x30);
        $hex = $this->writeBool($this->Triggers12OrTriggers34, $hex, 0x31);
        $hex = $this->writeByte($this->Delay, $hex, 0x32);
        $hex = $this->writeSByte($this->Points, $hex, 0x33);
        $offset = 0x34;
        for ($i = 0; $i < 4; $i++) {
            $t = $this->PointsPerTrigger[$i];
            $hex = $this->writeByte($t, $hex, $offset);
            $offset += 1;
        }
        $hex = $this->writeByte($this->ActiveSquence, $hex, 0x38);

        return $hex;
    }
    
    
    public function getLength()
    {
        return self::GOALGLOBALLENGTH;
    }
}