<?php

namespace Pyrite\XvT\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\PyriteBase;
use Pyrite\XvT\Constants;

abstract class GoalFGBase extends PyriteBase implements Byteable
{
    use HexDecoder;

    /** @var integer */
    public const GOALFGLENGTH = 78;
    /** @var integer */
    public $Argument;
    /** @var integer */
    public $Condition;
    /** @var integer */
    public $Amount;
    /** @var integer */
    public $Points;
    /** @var boolean */
    public $Enabled;
    /** @var integer */
    public $Team;
    /** @var boolean */
    public $Unknown10;
    /** @var boolean */
    public $Unknown11;
    /** @var boolean */
    public $Unknown12;
    /** @var integer */
    public $Unknown13;
    /** @var boolean */
    public $Unknown14;
    /** @var integer */
    public $Reserved; //(0) Unknown15
    /** @var integer */
    public $Unknown16;
    
    public function __construct($hex, $tie = null)
    {
        parent::__construct($hex, $tie);
        $this->beforeConstruct();
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
    
    public function toHexString()
    {
        $hex = "";
        $offset = 0;

        $this->writeByte($hex, $this->Argument, 0x00);
        $this->writeByte($hex, $this->Condition, 0x01);
        $this->writeByte($hex, $this->Amount, 0x02);
        $this->writeSByte($hex, $this->Points, 0x03);
        $this->writeBool($hex, $this->Enabled, 0x04);
        $this->writeByte($hex, $this->Team, 0x05);
        $this->writeBool($hex, $this->Unknown10, 0x06);
        $this->writeBool($hex, $this->Unknown11, 0x07);
        $this->writeBool($hex, $this->Unknown12, 0x08);
        $this->writeByte($hex, $this->Unknown13, 0x0B);
        $this->writeBool($hex, $this->Unknown14, 0x0C);
        $this->writeByte($hex, $this->Reserved, 0x0D);
        $this->writeByte($hex, $this->Unknown16, 0x0E);

        return $hex;
    }
    
    public function getConditionLabel() {
        return isset($this->Condition) && isset(Constants::$CONDITION[$this->Condition]) ? Constants::$CONDITION[$this->Condition] : "Unknown";
    }

    public function getAmountLabel() {
        return isset($this->Amount) && isset(Constants::$AMOUNT[$this->Amount]) ? Constants::$AMOUNT[$this->Amount] : "Unknown";
    }
    
    public function getLength()
    {
        return self::GOALFGLENGTH;
    }
}