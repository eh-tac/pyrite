<?php

namespace Pyrite\XWA\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;
use Pyrite\PyriteModel;

abstract class GoalFGBase extends PyriteBase implements Byteable, PyriteModel
{
    use HexDecoder;
    use HexEncoder;

    /** @var int GOALFGLENGTH INT */
	public const GOALFGLENGTH = 80;
    /** @var int 0x00 Argument BYTE */
	public int $Argument;
    /** @var int 0x01 Condition BYTE */
	public int $Condition;
    /** @var int 0x02 Amount BYTE */
	public int $Amount;
    /** @var int 0x03 Points SBYTE */
	public int $Points;
    /** @var array<bool> 0x04 EnabledForTeam BOOL */
	public array $EnabledForTeam;
    /** @var int 0x0E Parameter BYTE */
	public int $Parameter; // or Goal time limit depending on order
    /** @var int 0x0F ActiveSequence BYTE */
	public int $ActiveSequence;
    
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

        $this->Argument = $this->getByte($hex, 0x00);
        $this->Condition = $this->getByte($hex, 0x01);
        $this->Amount = $this->getByte($hex, 0x02);
        $this->Points = $this->getSByte($hex, 0x03);
        $this->EnabledForTeam = [];
        $offset = 0x04;
        for ($i = 0; $i < 10; $i++) {
            $t = $this->getBool($hex, $offset);
            $this->EnabledForTeam[] = $t;
            $offset += 1;
        }
        $this->Parameter = $this->getByte($hex, 0x0E);
        $this->ActiveSequence = $this->getByte($hex, 0x0F);
        

        $this->hex = substr($this->hex, 0, $this->getLength());
        return $this;
    }
    
    public function __debugInfo(): array
    {
        return [
            "Argument" => $this->Argument,
            "Condition" => $this->Condition,
            "Amount" => $this->Amount,
            "Points" => $this->Points,
            "EnabledForTeam" => $this->EnabledForTeam,
            "Parameter" => $this->Parameter,
            "ActiveSequence" => $this->ActiveSequence
        ];
    }
    
    public function toHexString($hex = null): string
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $hex = $this->writeByte($this->Argument, $hex, 0x00);
        $hex = $this->writeByte($this->Condition, $hex, 0x01);
        $hex = $this->writeByte($this->Amount, $hex, 0x02);
        $hex = $this->writeSByte($this->Points, $hex, 0x03);
        $offset = 0x04;
        for ($i = 0; $i < 10; $i++) {
            $t = $this->EnabledForTeam[$i];
            $hex = $this->writeBool($t, $hex, $offset);
            $offset += 1;
        }
        $hex = $this->writeByte($this->Parameter, $hex, 0x0E);
        $hex = $this->writeByte($this->ActiveSequence, $hex, 0x0F);

        return $hex;
    }
    
    
    public function getLength(): int
    {
        return self::GOALFGLENGTH;
    }
}