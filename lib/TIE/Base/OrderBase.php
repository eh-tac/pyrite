<?php

namespace Pyrite\TIE\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;
use Pyrite\TIE\Constants;

abstract class OrderBase extends PyriteBase implements Byteable
{
    use HexDecoder;
    use HexEncoder;

    /** @var integer  ORDERLENGTH INT */
    public const ORDERLENGTH = 18;
    /** @var integer 0x00 Order BYTE */
    public $Order;
    /** @var integer 0x01 Throttle BYTE */
    public $Throttle;
    /** @var integer 0x02 Variable1 BYTE */
    public $Variable1;
    /** @var integer 0x03 Variable2 BYTE */
    public $Variable2;
    /** @var integer 0x04 Unknown18 BYTE */
    public $Unknown18;
    /** @var integer 0x06 Target3Type BYTE */
    public $Target3Type;
    /** @var integer 0x07 Target4Type BYTE */
    public $Target4Type;
    /** @var integer 0x08 Target3 BYTE */
    public $Target3;
    /** @var integer 0x09 Target4 BYTE */
    public $Target4;
    /** @var boolean 0x0A Target3OrTarget4 BOOL */
    public $Target3OrTarget4;
    /** @var integer 0x0C Target1Type BYTE */
    public $Target1Type;
    /** @var integer 0x0D Target1 BYTE */
    public $Target1;
    /** @var integer 0x0E Target2Type BYTE */
    public $Target2Type;
    /** @var integer 0x0F Target2 BYTE */
    public $Target2;
    /** @var boolean 0x10 Target1OrTarget2 BOOL */
    public $Target1OrTarget2;
    
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

        $this->Order = $this->getByte($hex, 0x00);
        $this->Throttle = $this->getByte($hex, 0x01);
        $this->Variable1 = $this->getByte($hex, 0x02);
        $this->Variable2 = $this->getByte($hex, 0x03);
        $this->Unknown18 = $this->getByte($hex, 0x04);
        $this->Target3Type = $this->getByte($hex, 0x06);
        $this->Target4Type = $this->getByte($hex, 0x07);
        $this->Target3 = $this->getByte($hex, 0x08);
        $this->Target4 = $this->getByte($hex, 0x09);
        $this->Target3OrTarget4 = $this->getBool($hex, 0x0A);
        $this->Target1Type = $this->getByte($hex, 0x0C);
        $this->Target1 = $this->getByte($hex, 0x0D);
        $this->Target2Type = $this->getByte($hex, 0x0E);
        $this->Target2 = $this->getByte($hex, 0x0F);
        $this->Target1OrTarget2 = $this->getBool($hex, 0x10);
        
        return $this;
    }
    
    public function __debugInfo()
    {
        return [
            "Order" => $this->getOrderLabel(),
            "Throttle" => $this->Throttle,
            "Variable1" => $this->Variable1,
            "Variable2" => $this->Variable2,
            "Unknown18" => $this->Unknown18,
            "Target3Type" => $this->getTarget3TypeLabel(),
            "Target4Type" => $this->getTarget4TypeLabel(),
            "Target3" => $this->Target3,
            "Target4" => $this->Target4,
            "Target3OrTarget4" => $this->Target3OrTarget4,
            "Target1Type" => $this->getTarget1TypeLabel(),
            "Target1" => $this->Target1,
            "Target2Type" => $this->getTarget2TypeLabel(),
            "Target2" => $this->Target2,
            "Target1OrTarget2" => $this->Target1OrTarget2
        ];
    }
    
    public function toHexString($hex = null)
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $hex = $this->writeByte($this->Order, $hex, 0x00);
        $hex = $this->writeByte($this->Throttle, $hex, 0x01);
        $hex = $this->writeByte($this->Variable1, $hex, 0x02);
        $hex = $this->writeByte($this->Variable2, $hex, 0x03);
        $hex = $this->writeByte($this->Unknown18, $hex, 0x04);
        $hex = $this->writeByte($this->Target3Type, $hex, 0x06);
        $hex = $this->writeByte($this->Target4Type, $hex, 0x07);
        $hex = $this->writeByte($this->Target3, $hex, 0x08);
        $hex = $this->writeByte($this->Target4, $hex, 0x09);
        $hex = $this->writeBool($this->Target3OrTarget4, $hex, 0x0A);
        $hex = $this->writeByte($this->Target1Type, $hex, 0x0C);
        $hex = $this->writeByte($this->Target1, $hex, 0x0D);
        $hex = $this->writeByte($this->Target2Type, $hex, 0x0E);
        $hex = $this->writeByte($this->Target2, $hex, 0x0F);
        $hex = $this->writeBool($this->Target1OrTarget2, $hex, 0x10);

        return $hex;
    }
    
    public function getOrderLabel() 
    {
        return isset($this->Order) && isset(Constants::$ORDER[$this->Order]) ? Constants::$ORDER[$this->Order] : "Unknown";
    }

    public function getTarget3TypeLabel() 
    {
        return isset($this->Target3Type) && isset(Constants::$VARIABLETYPE[$this->Target3Type]) ? Constants::$VARIABLETYPE[$this->Target3Type] : "Unknown";
    }

    public function getTarget4TypeLabel() 
    {
        return isset($this->Target4Type) && isset(Constants::$VARIABLETYPE[$this->Target4Type]) ? Constants::$VARIABLETYPE[$this->Target4Type] : "Unknown";
    }

    public function getTarget1TypeLabel() 
    {
        return isset($this->Target1Type) && isset(Constants::$VARIABLETYPE[$this->Target1Type]) ? Constants::$VARIABLETYPE[$this->Target1Type] : "Unknown";
    }

    public function getTarget2TypeLabel() 
    {
        return isset($this->Target2Type) && isset(Constants::$VARIABLETYPE[$this->Target2Type]) ? Constants::$VARIABLETYPE[$this->Target2Type] : "Unknown";
    }
    
    public function getLength()
    {
        return self::ORDERLENGTH;
    }
}