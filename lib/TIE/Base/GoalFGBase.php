<?php

namespace Pyrite\TIE\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;
use Pyrite\TIE\Constants;

abstract class GoalFGBase extends PyriteBase implements Byteable
{
    use HexDecoder;
    use HexEncoder;

    /** @var integer  GOALFGLENGTH INT */
    public const GOALFGLENGTH = 2;
    /** @var integer 0x0 Condition BYTE */
    public $Condition;
    /** @var integer 0x1 GoalAmount BYTE */
    public $GoalAmount;
    
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
        $this->GoalAmount = $this->getByte($hex, 0x1);
        

        $this->hex = substr($this->hex, 0, $this->getLength());
        return $this;
    }
    
    public function __debugInfo()
    {
        return [
            "Condition" => $this->getConditionLabel(),
            "GoalAmount" => $this->getGoalAmountLabel()
        ];
    }
    
    public function toHexString($hex = null)
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $hex = $this->writeByte($this->Condition, $hex, 0x0);
        $hex = $this->writeByte($this->GoalAmount, $hex, 0x1);

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