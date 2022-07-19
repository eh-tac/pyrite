<?php

namespace Pyrite\TIE\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;
use Pyrite\TIE\Constants;

abstract class TriggerBase extends PyriteBase implements Byteable
{
    use HexDecoder;
    use HexEncoder;

    /** @var integer  TRIGGERLENGTH INT */
    public const TRIGGERLENGTH = 4;
    /** @var integer 0x0 Condition BYTE */
    public $Condition;
    /** @var integer 0x1 VariableType BYTE */
    public $VariableType;
    /** @var integer 0x2 Variable BYTE */
    public $Variable;
    /** @var integer 0x3 TriggerAmount BYTE */
    public $TriggerAmount;
    
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

        $this->Condition = $this->getByte($hex, 0x0);
        $this->VariableType = $this->getByte($hex, 0x1);
        $this->Variable = $this->getByte($hex, 0x2);
        $this->TriggerAmount = $this->getByte($hex, 0x3);
        

        $this->hex = substr($this->hex, 0, $this->getLength());
        return $this;
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
    
    public function toHexString($hex = null)
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $hex = $this->writeByte($this->Condition, $hex, 0x0);
        $hex = $this->writeByte($this->VariableType, $hex, 0x1);
        $hex = $this->writeByte($this->Variable, $hex, 0x2);
        $hex = $this->writeByte($this->TriggerAmount, $hex, 0x3);

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