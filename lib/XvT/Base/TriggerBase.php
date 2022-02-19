<?php

namespace Pyrite\XvT\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\PyriteBase;
use Pyrite\XvT\Constants;

abstract class TriggerBase extends PyriteBase implements Byteable
{
    use HexDecoder;

    /** @var integer */
    public const TRIGGERLENGTH = 4;
    /** @var integer */
    public $Condition;
    /** @var integer */
    public $VariableType;
    /** @var integer */
    public $Variable;
    /** @var integer */
    public $Amount;
    
    public function __construct($hex, $tie = null)
    {
        parent::__construct($hex, $tie);
        $this->beforeConstruct();
        $offset = 0;

        $this->Condition = $this->getByte($hex, 0x0);
        $this->VariableType = $this->getByte($hex, 0x1);
        $this->Variable = $this->getByte($hex, 0x2);
        $this->Amount = $this->getByte($hex, 0x3);
        
    }
    
    public function __debugInfo()
    {
        return [
            "Condition" => $this->getConditionLabel(),
            "VariableType" => $this->getVariableTypeLabel(),
            "Variable" => $this->Variable,
            "Amount" => $this->getAmountLabel()
        ];
    }
    
    public function toHexString()
    {
        $hex = "";
        $offset = 0;

        $this->writeByte($hex, $this->Condition, 0x0);
        $this->writeByte($hex, $this->VariableType, 0x1);
        $this->writeByte($hex, $this->Variable, 0x2);
        $this->writeByte($hex, $this->Amount, 0x3);

        return $hex;
    }
    
    public function getConditionLabel() {
        return isset($this->Condition) && isset(Constants::$CONDITION[$this->Condition]) ? Constants::$CONDITION[$this->Condition] : "Unknown";
    }

    public function getVariableTypeLabel() {
        return isset($this->VariableType) && isset(Constants::$VARIABLETYPE[$this->VariableType]) ? Constants::$VARIABLETYPE[$this->VariableType] : "Unknown";
    }

    public function getAmountLabel() {
        return isset($this->Amount) && isset(Constants::$AMOUNT[$this->Amount]) ? Constants::$AMOUNT[$this->Amount] : "Unknown";
    }
    
    public function getLength()
    {
        return self::TRIGGERLENGTH;
    }
}