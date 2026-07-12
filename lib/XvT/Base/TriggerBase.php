<?php

namespace Pyrite\XvT\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;
use Pyrite\PyriteModel;
use Pyrite\XvT\Constants;

abstract class TriggerBase extends PyriteBase implements Byteable, PyriteModel
{
    use HexDecoder;
    use HexEncoder;

    /** @var int TRIGGERLENGTH INT */
	public const TRIGGERLENGTH = 4;
    /** @var int 0x0 Condition BYTE */
	public int $Condition;
    /** @var int 0x1 VariableType BYTE */
	public int $VariableType;
    /** @var int 0x2 Variable BYTE */
	public int $Variable;
    /** @var int 0x3 Amount BYTE */
	public int $Amount;
    
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

        $this->Condition = $this->getByte($hex, 0x0);
        $this->VariableType = $this->getByte($hex, 0x1);
        $this->Variable = $this->getByte($hex, 0x2);
        $this->Amount = $this->getByte($hex, 0x3);
        

        $this->hex = substr($this->hex, 0, $this->getLength());
        $this->afterLoadHex();
        return $this;
    }
    
    public function __debugInfo(): array
    {
        return [
            "Condition" => $this->getConditionLabel(),
            "VariableType" => $this->getVariableTypeLabel(),
            "Variable" => $this->Variable,
            "Amount" => $this->getAmountLabel()
        ];
    }
    
    public function toHexString($hex = null): string
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $hex = $this->writeByte($this->Condition, $hex, 0x0);
        $hex = $this->writeByte($this->VariableType, $hex, 0x1);
        $hex = $this->writeByte($this->Variable, $hex, 0x2);
        $hex = $this->writeByte($this->Amount, $hex, 0x3);

        return $hex;
    }
    
    public function getConditionLabel(): string 
    {
        return isset($this->Condition) && isset(Constants::$CONDITION[$this->Condition]) ? Constants::$CONDITION[$this->Condition] : "Unknown";
    }

    public function getVariableTypeLabel(): string 
    {
        return isset($this->VariableType) && isset(Constants::$VARIABLETYPE[$this->VariableType]) ? Constants::$VARIABLETYPE[$this->VariableType] : "Unknown";
    }

    public function getAmountLabel(): string 
    {
        return isset($this->Amount) && isset(Constants::$AMOUNT[$this->Amount]) ? Constants::$AMOUNT[$this->Amount] : "Unknown";
    }
    
    public function getLength(): int
    {
        return self::TRIGGERLENGTH;
    }
}