<?php

namespace Pyrite\XWA\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\PyriteBase;
use Pyrite\XWA\Constants;
use Pyrite\XWA\Waypt;

abstract class OrderBase extends PyriteBase implements Byteable
{
    use HexDecoder;

    /** @var integer */
    public const ORDERLENGTH = 149;
    /** @var integer */
    public $Order;
    /** @var integer */
    public $Throttle;
    /** @var integer */
    public $Variable1;
    /** @var integer */
    public $Variable2;
    /** @var integer */
    public $Variable3;
    /** @var integer */
    public $Unknown9; //** retains FG Unknown numbering
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
    public $Speed;
    /** @var Waypt[] */
    public $Unnamed;
    /** @var integer */
    public $Unknown10;
    /** @var boolean */
    public $Unknown11;
    /** @var boolean */
    public $Unknown12;
    /** @var boolean */
    public $Unknown13;
    /** @var boolean */
    public $Unknown14;
    
    public function __construct($hex, $tie = null)
    {
        parent::__construct($hex, $tie);
        $this->beforeConstruct();
        $offset = 0;

        $this->Order = $this->getByte($hex, 0x00);
        $this->Throttle = $this->getByte($hex, 0x01);
        $this->Variable1 = $this->getByte($hex, 0x02);
        $this->Variable2 = $this->getByte($hex, 0x03);
        $this->Variable3 = $this->getByte($hex, 0x04);
        $this->Unknown9 = $this->getByte($hex, 0x05);
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
        $this->Speed = $this->getByte($hex, 0x12);
        $this->Unnamed = [];
        $offset = 0x14;
        for ($i = 0; $i < 8; $i++) {
            $t = new Waypt(substr($hex, $offset), $this->TIE);
            $this->Unnamed[] = $t;
            $offset += $t->getLength();
        }
        $this->Unknown10 = $this->getByte($hex, 0x72);
        $this->Unknown11 = $this->getBool($hex, 0x73);
        $this->Unknown12 = $this->getBool($hex, 0x74);
        $this->Unknown13 = $this->getBool($hex, 0x7B);
        $this->Unknown14 = $this->getBool($hex, 0x81);
        
    }
    
    public function __debugInfo()
    {
        return [
            "Order" => $this->getOrderLabel(),
            "Throttle" => $this->Throttle,
            "Variable1" => $this->Variable1,
            "Variable2" => $this->Variable2,
            "Variable3" => $this->Variable3,
            "Unknown9" => $this->Unknown9,
            "Target3Type" => $this->getTarget3TypeLabel(),
            "Target4Type" => $this->getTarget4TypeLabel(),
            "Target3" => $this->Target3,
            "Target4" => $this->Target4,
            "Target3OrTarget4" => $this->Target3OrTarget4,
            "Target1Type" => $this->getTarget1TypeLabel(),
            "Target1" => $this->Target1,
            "Target2Type" => $this->getTarget2TypeLabel(),
            "Target2" => $this->Target2,
            "Target1OrTarget2" => $this->Target1OrTarget2,
            "Speed" => $this->Speed,
            "Unnamed" => $this->Unnamed,
            "Unknown10" => $this->Unknown10,
            "Unknown11" => $this->Unknown11,
            "Unknown12" => $this->Unknown12,
            "Unknown13" => $this->Unknown13,
            "Unknown14" => $this->Unknown14
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
        $this->writeByte($hex, $this->Variable3, 0x04);
        $this->writeByte($hex, $this->Unknown9, 0x05);
        $this->writeByte($hex, $this->Target3Type, 0x06);
        $this->writeByte($hex, $this->Target4Type, 0x07);
        $this->writeByte($hex, $this->Target3, 0x08);
        $this->writeByte($hex, $this->Target4, 0x09);
        $this->writeBool($hex, $this->Target3OrTarget4, 0x0A);
        $this->writeByte($hex, $this->Target1Type, 0x0C);
        $this->writeByte($hex, $this->Target1, 0x0D);
        $this->writeByte($hex, $this->Target2Type, 0x0E);
        $this->writeByte($hex, $this->Target2, 0x0F);
        $this->writeBool($hex, $this->Target1OrTarget2, 0x10);
        $this->writeByte($hex, $this->Speed, 0x12);
        $offset = 0x14;
        for ($i = 0; $i < 8; $i++) {
            $t = $this->Unnamed[$i];
            $this->writeObject($hex, $t, $offset);
            $offset += $t->getLength();
        }
        $this->writeByte($hex, $this->Unknown10, 0x72);
        $this->writeBool($hex, $this->Unknown11, 0x73);
        $this->writeBool($hex, $this->Unknown12, 0x74);
        $this->writeBool($hex, $this->Unknown13, 0x7B);
        $this->writeBool($hex, $this->Unknown14, 0x81);

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