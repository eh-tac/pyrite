<?php

namespace Pyrite\TIE\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\PyriteBase;
use Pyrite\TIE\Constants;

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
    public $TriggerAmount;
    
    public function __construct($hex, $tie = null)
    {
        parent::__construct($hex, $tie);
        $this->beforeConstruct();
        $offset = 0;

        $this->Condition = $this->getByte($hex, 0x0);
        $this->VariableType = $this->getByte($hex, 0x1);
        $this->Variable = $this->getByte($hex, 0x2);
        $this->TriggerAmount = $this->getByte($hex, 0x3);
        
    }
    
    public function __debugInfo()
    {
        return [
            "Condition" => $this->getConditionLabel(),
            "VariableType" => $this->getVariableTypeLabel(),
            "Variable" => $this->Variable,
            "TriggerAmount" => $this->getTriggerAmountLabel()
        ];
    }
    
    public function toHexString()
    {
        $hex = "";
        $offset = 0;

        $this->writeByte($hex, $this->Condition, 0x0);
        $this->writeByte($hex, $this->VariableType, 0x1);
        $this->writeByte($hex, $this->Variable, 0x2);
        $this->writeByte($hex, $this->TriggerAmount, 0x3);

        return $hex;
    }
    
    public function getConditionLabel() 
    {
        return isset($this->Condition) && isset(Constants::$CONDITION[$this->Condition]) ? Constants::$CONDITION[$this->Condition] : "Unknown";
    }

    public function getVariableTypeLabel() 
    {
        return isset($this->VariableType) && isset(Constants::$VARIABLETYPE[$this->VariableType]) ? Constants::$VARIABLETYPE[$this->VariableType] : "Unknown";
    }

    public function getTriggerAmountLabel() 
    {
        return isset($this->TriggerAmount) && isset(Constants::$TRIGGERAMOUNT[$this->TriggerAmount]) ? Constants::$TRIGGERAMOUNT[$this->TriggerAmount] : "Unknown";
    }
    
    public function getLength()
    {
        return self::TRIGGERLENGTH;
    }
}