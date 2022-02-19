<?php

namespace Pyrite\TIE\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\PyriteBase;
use Pyrite\TIE\Constants;

abstract class GoalFGBase extends PyriteBase implements Byteable
{
    use HexDecoder;

    /** @var integer */
    public const GOALFGLENGTH = 2;
    /** @var integer */
    public $Condition;
    /** @var integer */
    public $GoalAmount;
    
    public function __construct($hex, $tie = null)
    {
        parent::__construct($hex, $tie);
        $this->beforeConstruct();
        $offset = 0;

        $this->Condition = $this->getByte($hex, 0x0);
        $this->GoalAmount = $this->getByte($hex, 0x1);
        
    }
    
    public function __debugInfo()
    {
        return [
            "Condition" => $this->getConditionLabel(),
            "GoalAmount" => $this->getGoalAmountLabel()
        ];
    }
    
    public function toHexString()
    {
        $hex = "";
        $offset = 0;

        $this->writeByte($hex, $this->Condition, 0x0);
        $this->writeByte($hex, $this->GoalAmount, 0x1);

        return $hex;
    }
    
    public function getConditionLabel() 
    {
        return isset($this->Condition) && isset(Constants::$CONDITION[$this->Condition]) ? Constants::$CONDITION[$this->Condition] : "Unknown";
    }

    public function getGoalAmountLabel() 
    {
        return isset($this->GoalAmount) && isset(Constants::$GOALAMOUNT[$this->GoalAmount]) ? Constants::$GOALAMOUNT[$this->GoalAmount] : "Unknown";
    }
    
    public function getLength()
    {
        return self::GOALFGLENGTH;
    }
}