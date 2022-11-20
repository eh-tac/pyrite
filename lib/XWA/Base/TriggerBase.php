<?php

namespace Pyrite\XWA\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;
use Pyrite\XWA\Constants;

abstract class TriggerBase extends PyriteBase implements Byteable
{
    use HexDecoder;
    use HexEncoder;

    /** @var integer  TRIGGERLENGTH INT */
    public const TRIGGERLENGTH = 6;
    /** @var integer 0x0 Condition BYTE */
    public $Condition;
    /** @var integer 0x1 VariableType BYTE */
    public $VariableType;
    /** @var integer 0x2 Variable BYTE */
    public $Variable;
    /** @var integer 0x3 Amount BYTE */
    public $Amount;
    /** @var integer 0x4 Parameter BYTE */
    public $Parameter;
    /** @var integer 0x5 Parameter2 BYTE */
    public $Parameter2;
    
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
        $this->Amount = $this->getByte($hex, 0x3);
        $this->Parameter = $this->getByte($hex, 0x4);
        $this->Parameter2 = $this->getByte($hex, 0x5);
        
        return $this;
    }
    
    public function __debugInfo()
    {
        return [
            "Condition" => $this->getConditionLabel(),
            "VariableType" => $this->getVariableTypeLabel(),
            "Variable" => $this->Variable,
            "Amount" => $this->getAmountLabel(),
            "Parameter" => $this->Parameter,
            "Parameter2" => $this->Parameter2
        ];
    }
    
    public function toHexString($hex = null)
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        [$hex, $offset] = $this->writeByte($this->Condition, $hex, 0x0);
        [$hex, $offset] = $this->writeByte($this->VariableType, $hex, 0x1);
        [$hex, $offset] = $this->writeByte($this->Variable, $hex, 0x2);
        [$hex, $offset] = $this->writeByte($this->Amount, $hex, 0x3);
        [$hex, $offset] = $this->writeByte($this->Parameter, $hex, 0x4);
        [$hex, $offset] = $this->writeByte($this->Parameter2, $hex, 0x5);

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

    public function getAmountLabel() 
    {
        return isset($this->Amount) && isset(Constants::$AMOUNT[$this->Amount]) ? Constants::$AMOUNT[$this->Amount] : "Unknown";
    }
    
    public function getLength()
    {
        return self::TRIGGERLENGTH;
    }
}