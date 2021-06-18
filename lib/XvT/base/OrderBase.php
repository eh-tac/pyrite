<?php

namespace Pyrite\XvT\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\PyriteBase;
use Pyrite\XvT\Constants;

abstract class OrderBase extends PyriteBase implements Byteable
{
    use HexDecoder;

    /** @var integer */
    public const ORDERLENGTH = 82;
    /** @var integer */
    public $Order;
    /** @var integer */
    public $Throttle;
    /** @var integer */
    public $Variable1;
    /** @var integer */
    public $Variable2;
    /** @var integer */
    public $Unknown6;
    /** @var integer */
    public $Unknown7;
    /** @var integer */
    public $Target3Type;
    /** @var integer */
    public $Target4Type;
    /** @var integer */
    public $Target3;
    /** @var integer */
    public $Target4;
    /** @var boolean */
    public $Target3OrTarget4;
    /** @var integer */
    public $Unknown8;
    /** @var integer */
    public $Target1Type;
    /** @var integer */
    public $Target1;
    /** @var integer */
    public $Target2Type;
    /** @var integer */
    public $Target2;
    /** @var boolean */
    public $Target1OrTarget2;
    /** @var integer */
    public $Unknown9;
    /** @var integer */
    public $Speed;
    /** @var string */
    public $Designation;
    
    public function __construct($hex, $tie = null)
    {
        parent::__construct($hex, $tie);
        $this->beforeConstruct();
        $offset = 0;

        $this->Order = $this->getByte($hex, 0x00);
        $this->Throttle = $this->getByte($hex, 0x01);
        $this->Variable1 = $this->getByte($hex, 0x02);
        $this->Variable2 = $this->getByte($hex, 0x03);
        $this->Unknown6 = $this->getByte($hex, 0x04);
        $this->Unknown7 = $this->getByte($hex, 0x05);
        $this->Target3Type = $this->getByte($hex, 0x06);
        $this->Target4Type = $this->getByte($hex, 0x07);
        $this->Target3 = $this->getByte($hex, 0x08);
        $this->Target4 = $this->getByte($hex, 0x09);
        $this->Target3OrTarget4 = $this->getBool($hex, 0x0A);
        $this->Unknown8 = $this->getByte($hex, 0x0B);
        $this->Target1Type = $this->getByte($hex, 0x0C);
        $this->Target1 = $this->getByte($hex, 0x0D);
        $this->Target2Type = $this->getByte($hex, 0x0E);
        $this->Target2 = $this->getByte($hex, 0x0F);
        $this->Target1OrTarget2 = $this->getBool($hex, 0x10);
        $this->Unknown9 = $this->getByte($hex, 0x11);
        $this->Speed = $this->getByte($hex, 0x12);
        $this->Designation = $this->getString($hex, 0x13);
        
    }
    
    public function __debugInfo()
    {
        return [
            "Order" => $this->getOrderLabel(),
            "Throttle" => $this->Throttle,
            "Variable1" => $this->Variable1,
            "Variable2" => $this->Variable2,
            "Unknown6" => $this->Unknown6,
            "Unknown7" => $this->Unknown7,
            "Target3Type" => $this->getTarget3TypeLabel(),
            "Target4Type" => $this->getTarget4TypeLabel(),
            "Target3" => $this->Target3,
            "Target4" => $this->Target4,
            "Target3OrTarget4" => $this->Target3OrTarget4,
            "Unknown8" => $this->Unknown8,
            "Target1Type" => $this->getTarget1TypeLabel(),
            "Target1" => $this->Target1,
            "Target2Type" => $this->getTarget2TypeLabel(),
            "Target2" => $this->Target2,
            "Target1OrTarget2" => $this->Target1OrTarget2,
            "Unknown9" => $this->Unknown9,
            "Speed" => $this->Speed,
            "Designation" => $this->Designation
        ];
    }
    
    public function toHexString()
    {
        $hex = "";
        $offset = 0;

        $this->writeByte($hex, $this->Order, 0x00);
        $this->writeByte($hex, $this->Throttle, 0x01);
        $this->writeByte($hex, $this->Variable1, 0x02);
        $this->writeByte($hex, $this->Variable2, 0x03);
        $this->writeByte($hex, $this->Unknown6, 0x04);
        $this->writeByte($hex, $this->Unknown7, 0x05);
        $this->writeByte($hex, $this->Target3Type, 0x06);
        $this->writeByte($hex, $this->Target4Type, 0x07);
        $this->writeByte($hex, $this->Target3, 0x08);
        $this->writeByte($hex, $this->Target4, 0x09);
        $this->writeBool($hex, $this->Target3OrTarget4, 0x0A);
        $this->writeByte($hex, $this->Unknown8, 0x0B);
        $this->writeByte($hex, $this->Target1Type, 0x0C);
        $this->writeByte($hex, $this->Target1, 0x0D);
        $this->writeByte($hex, $this->Target2Type, 0x0E);
        $this->writeByte($hex, $this->Target2, 0x0F);
        $this->writeBool($hex, $this->Target1OrTarget2, 0x10);
        $this->writeByte($hex, $this->Unknown9, 0x11);
        $this->writeByte($hex, $this->Speed, 0x12);
        $this->writeString($hex, $this->Designation, 0x13);

        return $hex;
    }
    
    public function getOrderLabel() {
        return isset($this->Order) && isset(Constants::$ORDER[$this->Order]) ? Constants::$ORDER[$this->Order] : "Unknown";
    }

    public function getTarget3TypeLabel() {
        return isset($this->Target3Type) && isset(Constants::$VARIABLETYPE[$this->Target3Type]) ? Constants::$VARIABLETYPE[$this->Target3Type] : "Unknown";
    }

    public function getTarget4TypeLabel() {
        return isset($this->Target4Type) && isset(Constants::$VARIABLETYPE[$this->Target4Type]) ? Constants::$VARIABLETYPE[$this->Target4Type] : "Unknown";
    }

    public function getTarget1TypeLabel() {
        return isset($this->Target1Type) && isset(Constants::$VARIABLETYPE[$this->Target1Type]) ? Constants::$VARIABLETYPE[$this->Target1Type] : "Unknown";
    }

    public function getTarget2TypeLabel() {
        return isset($this->Target2Type) && isset(Constants::$VARIABLETYPE[$this->Target2Type]) ? Constants::$VARIABLETYPE[$this->Target2Type] : "Unknown";
    }
    
    public function getLength()
    {
        return self::ORDERLENGTH;
    }
}