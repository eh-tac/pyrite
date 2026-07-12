<?php

namespace Pyrite\XvT\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;
use Pyrite\PyriteModel;
use Pyrite\XvT\Constants;

abstract class GoalFGBase extends PyriteBase implements Byteable, PyriteModel
{
    use HexDecoder;
    use HexEncoder;

    /** @var int GOALFGLENGTH INT */
	public const GOALFGLENGTH = 78;
    /** @var int 0x00 GoalArgument BYTE */
	public int $GoalArgument;
    /** @var int 0x01 Condition BYTE */
	public int $Condition;
    /** @var int 0x02 Amount BYTE */
	public int $Amount;
    /** @var int 0x03 Points SBYTE */
	public int $Points;
    /** @var bool 0x04 Enabled BOOL */
	public bool $Enabled;
    /** @var int 0x05 Team BYTE */
	public int $Team;
    /** @var bool 0x06 Unknown10 BOOL */
	public bool $Unknown10;
    /** @var bool 0x07 Unknown11 BOOL */
	public bool $Unknown11;
    /** @var bool 0x08 Unknown12 BOOL */
	public bool $Unknown12;
    /** @var int 0x0B Unknown13 BYTE */
	public int $Unknown13;
    /** @var bool 0x0C Unknown14 BOOL */
	public bool $Unknown14;
    /** @var int 0x0D Reserved BYTE */
	public int $Reserved; // (0) Unknown15
    /** @var int 0x0E Unknown16 BYTE */
	public int $Unknown16;
    
    public function __construct(string $hex = null, ?PyriteModel $TIE = null)
    {
        parent::__construct($hex, $TIE);
    }

    /**
     * Process the $hex string provided in the constructor.
     * Separating the constructor and loading allows for the objects to be made from scratch.
     * @return $this 
     */
    public function loadHex(): static
    {
        $hex = $this->hex;
        $offset = 0;

        $this->GoalArgument = $this->getByte($hex, 0x00);
        $this->Condition = $this->getByte($hex, 0x01);
        $this->Amount = $this->getByte($hex, 0x02);
        $this->Points = $this->getSByte($hex, 0x03);
        $this->Enabled = $this->getBool($hex, 0x04);
        $this->Team = $this->getByte($hex, 0x05);
        $this->Unknown10 = $this->getBool($hex, 0x06);
        $this->Unknown11 = $this->getBool($hex, 0x07);
        $this->Unknown12 = $this->getBool($hex, 0x08);
        $this->Unknown13 = $this->getByte($hex, 0x0B);
        $this->Unknown14 = $this->getBool($hex, 0x0C);
        $this->Reserved = $this->getByte($hex, 0x0D);
        $this->Unknown16 = $this->getByte($hex, 0x0E);
        

        $this->hex = substr($this->hex, 0, $this->getLength());
        $this->afterLoadHex();
        return $this;
    }
    
    public function __debugInfo(): array
    {
        return [
            "GoalArgument" => $this->getGoalArgumentLabel(),
            "Condition" => $this->getConditionLabel(),
            "Amount" => $this->getAmountLabel(),
            "Points" => $this->Points,
            "Enabled" => $this->Enabled,
            "Team" => $this->Team,
            "Unknown10" => $this->Unknown10,
            "Unknown11" => $this->Unknown11,
            "Unknown12" => $this->Unknown12,
            "Unknown13" => $this->Unknown13,
            "Unknown14" => $this->Unknown14,
            "Reserved" => $this->Reserved,
            "Unknown16" => $this->Unknown16
        ];
    }
    
    public function toHexString($hex = null): string
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $hex = $this->writeByte($this->GoalArgument, $hex, 0x00);
        $hex = $this->writeByte($this->Condition, $hex, 0x01);
        $hex = $this->writeByte($this->Amount, $hex, 0x02);
        $hex = $this->writeSByte($this->Points, $hex, 0x03);
        $hex = $this->writeBool($this->Enabled, $hex, 0x04);
        $hex = $this->writeByte($this->Team, $hex, 0x05);
        $hex = $this->writeBool($this->Unknown10, $hex, 0x06);
        $hex = $this->writeBool($this->Unknown11, $hex, 0x07);
        $hex = $this->writeBool($this->Unknown12, $hex, 0x08);
        $hex = $this->writeByte($this->Unknown13, $hex, 0x0B);
        $hex = $this->writeBool($this->Unknown14, $hex, 0x0C);
        $hex = $this->writeByte($this->Reserved, $hex, 0x0D);
        $hex = $this->writeByte($this->Unknown16, $hex, 0x0E);

        return $hex;
    }
    
    public function getGoalArgumentLabel(): string 
    {
        return isset($this->GoalArgument) && isset(Constants::$GOALARGUMENT[$this->GoalArgument]) ? Constants::$GOALARGUMENT[$this->GoalArgument] : "Unknown";
    }

    public function getConditionLabel(): string 
    {
        return isset($this->Condition) && isset(Constants::$CONDITION[$this->Condition]) ? Constants::$CONDITION[$this->Condition] : "Unknown";
    }

    public function getAmountLabel(): string 
    {
        return isset($this->Amount) && isset(Constants::$AMOUNT[$this->Amount]) ? Constants::$AMOUNT[$this->Amount] : "Unknown";
    }
    
    public function getLength(): int
    {
        return self::GOALFGLENGTH;
    }
}