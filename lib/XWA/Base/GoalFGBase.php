<?php

namespace Pyrite\XWA\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;

abstract class GoalFGBase extends PyriteBase implements Byteable
{
    use HexDecoder;
    use HexEncoder;

    /** @var integer  GOALFGLENGTH INT */
    public const GOALFGLENGTH = 80;
    /** @var integer 0x00 Argument BYTE */
    public $Argument;
    /** @var integer 0x01 Condition BYTE */
    public $Condition;
    /** @var integer 0x02 Amount BYTE */
    public $Amount;
    /** @var integer 0x03 Points SBYTE */
    public $Points;
    /** @var boolean 0x04 Enabled BOOL */
    public $Enabled;
    /** @var integer 0x05 Team BYTE */
    public $Team;
    /** @var integer 0x0D Unknown42 BYTE */
    public $Unknown42;
    /** @var integer 0x0E Parameter BYTE */
    public $Parameter; //or Goal time limit depending on order
    /** @var integer 0x0F ActiveSequence BYTE */
    public $ActiveSequence;
    /** @var boolean 0x4F Unknown15 BOOL */
    public $Unknown15; //** retains FG Unknown numbering
    
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
        

        $this->hex = substr($this->hex, 0, $this->getLength());
        return $this;
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
    
    public function toHexString($hex = null)
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $hex = $this->writeByte($this->Argument, $hex, 0x00);
        $hex = $this->writeByte($this->Condition, $hex, 0x01);
        $hex = $this->writeByte($this->Amount, $hex, 0x02);
        $hex = $this->writeSByte($this->Points, $hex, 0x03);
        $hex = $this->writeBool($this->Enabled, $hex, 0x04);
        $hex = $this->writeByte($this->Team, $hex, 0x05);
        $hex = $this->writeByte($this->Unknown42, $hex, 0x0D);
        $hex = $this->writeByte($this->Parameter, $hex, 0x0E);
        $hex = $this->writeByte($this->ActiveSequence, $hex, 0x0F);
        $hex = $this->writeBool($this->Unknown15, $hex, 0x4F);

        return $hex;
    }
    
    
    public function getLength()
    {
        return self::GOALFGLENGTH;
    }
}