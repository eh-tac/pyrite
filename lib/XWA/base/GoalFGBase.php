<?php

namespace Pyrite\XWA\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\PyriteBase;

abstract class GoalFGBase extends PyriteBase implements Byteable
{
    use HexDecoder;

    /** @var integer */
    public const GOALFGLENGTH = 80;
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
    /** @var integer */
    public $Unknown42;
    /** @var integer */
    public $Parameter; //or Goal time limit depending on order
    /** @var integer */
    public $ActiveSequence;
    /** @var boolean */
    public $Unknown15; //** retains FG Unknown numbering
    
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
        $this->Unknown42 = $this->getByte($hex, 0x0D);
        $this->Parameter = $this->getByte($hex, 0x0E);
        $this->ActiveSequence = $this->getByte($hex, 0x0F);
        $this->Unknown15 = $this->getBool($hex, 0x4F);
        
    }
    
    public function __debugInfo()
    {
        return [
            "Argument" => $this->Argument,
            "Condition" => $this->Condition,
            "Amount" => $this->Amount,
            "Points" => $this->Points,
            "Enabled" => $this->Enabled,
            "Team" => $this->Team,
            "Unknown42" => $this->Unknown42,
            "Parameter" => $this->Parameter,
            "ActiveSequence" => $this->ActiveSequence,
            "Unknown15" => $this->Unknown15
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
        $this->writeByte($hex, $this->Unknown42, 0x0D);
        $this->writeByte($hex, $this->Parameter, 0x0E);
        $this->writeByte($hex, $this->ActiveSequence, 0x0F);
        $this->writeBool($hex, $this->Unknown15, 0x4F);

        return $hex;
    }
    
    
    public function getLength()
    {
        return self::GOALFGLENGTH;
    }
}