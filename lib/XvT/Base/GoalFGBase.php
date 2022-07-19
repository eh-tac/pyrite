<?php

namespace Pyrite\XvT\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;
use Pyrite\XvT\Constants;

abstract class GoalFGBase extends PyriteBase implements Byteable
{
    use HexDecoder;
    use HexEncoder;

    /** @var integer  GOALFGLENGTH INT */
    public const GOALFGLENGTH = 78;
    /** @var integer 0x00 Argument BYTE */
    public $Argument;
    /** @var integer 0x01 Condition BYTE */
    public $Condition;
    /** @var integer 0x02 Amount BYTE */
    public $Amount;
    /** @var integer 0x03 Points SBYTE */
    public $Points;
    /** @var boolean 0x04 Enabled BOOL */
    public $Enabled;
    /** @var integer 0x05 Team BYTE */
    public $Team;
    /** @var boolean 0x06 Unknown10 BOOL */
    public $Unknown10;
    /** @var boolean 0x07 Unknown11 BOOL */
    public $Unknown11;
    /** @var boolean 0x08 Unknown12 BOOL */
    public $Unknown12;
    /** @var integer 0x0B Unknown13 BYTE */
    public $Unknown13;
    /** @var boolean 0x0C Unknown14 BOOL */
    public $Unknown14;
    /** @var integer 0x0D Reserved BYTE */
    public $Reserved; //(0) Unknown15
    /** @var integer 0x0E Unknown16 BYTE */
    public $Unknown16;
    
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

        $this->Argument = $this->getByte($hex, 0x00);
        $this->Condition = $this->getByte($hex, 0x01);
        $this->Amount = $this->getByte($hex, 0x02);
        $this->Points = $this->getSByte($hex, 0x03);
        $this->Enabled = $this->getBool($hex, 0x04);
        $this->Team = $this->getByte($hex, 0x05);
        $this->Unknown10 = $this->getBool($hex, 0x06);
        $this->Unknown11 = $this->getBool($hex, 0x07);
        $this->Unknown12 = $this->getBool($hex, 0x08);
        $this->Unknown13 = $this->getByte($hex, 0x0B);
        $this->Unknown14 = $this->getBool($hex, 0x0C);
        $this->Reserved = $this->getByte($hex, 0x0D);
        $this->Unknown16 = $this->getByte($hex, 0x0E);
        

        $this->hex = substr($this->hex, 0, $this->getLength());
        return $this;
    }
    
    public function __debugInfo()
    {
        return [
            "Argument" => $this->Argument,
            "Condition" => $this->getConditionLabel(),
            "Amount" => $this->getAmountLabel(),
            "Points" => $this->Points,
            "Enabled" => $this->Enabled,
            "Team" => $this->Team,
            "Unknown10" => $this->Unknown10,
            "Unknown11" => $this->Unknown11,
            "Unknown12" => $this->Unknown12,
            "Unknown13" => $this->Unknown13,
            "Unknown14" => $this->Unknown14,
            "Reserved" => $this->Reserved,
            "Unknown16" => $this->Unknown16
        ];
    }
    
    public function toHexString($hex = null)
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $hex = $this->writeByte($this->Argument, $hex, 0x00);
        $hex = $this->writeByte($this->Condition, $hex, 0x01);
        $hex = $this->writeByte($this->Amount, $hex, 0x02);
        $hex = $this->writeSByte($this->Points, $hex, 0x03);
        $hex = $this->writeBool($this->Enabled, $hex, 0x04);
        $hex = $this->writeByte($this->Team, $hex, 0x05);
        $hex = $this->writeBool($this->Unknown10, $hex, 0x06);
        $hex = $this->writeBool($this->Unknown11, $hex, 0x07);
        $hex = $this->writeBool($this->Unknown12, $hex, 0x08);
        $hex = $this->writeByte($this->Unknown13, $hex, 0x0B);
        $hex = $this->writeBool($this->Unknown14, $hex, 0x0C);
        $hex = $this->writeByte($this->Reserved, $hex, 0x0D);
        $hex = $this->writeByte($this->Unknown16, $hex, 0x0E);

        return $hex;
    }
    
    public function getConditionLabel() 
    {
        return isset($this->Condition) && isset(Constants::$CONDITION[$this->Condition]) ? Constants::$CONDITION[$this->Condition] : "Unknown";
    }

    public function getAmountLabel() 
    {
        return isset($this->Amount) && isset(Constants::$AMOUNT[$this->Amount]) ? Constants::$AMOUNT[$this->Amount] : "Unknown";
    }
    
    public function getLength()
    {
        return self::GOALFGLENGTH;
    }
}