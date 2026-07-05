<?php

namespace Pyrite\XWA\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;
use Pyrite\PyriteModel;
use Pyrite\XWA\GoalGlobal;

abstract class GlobalGoalBase extends PyriteBase implements Byteable, PyriteModel
{
    use HexDecoder;
    use HexEncoder;

    /** @var int GLOBALGOALLENGTH INT */
	public const GLOBALGOALLENGTH = 368;
    /** @var int 0x00 Reserved SHORT */
	public int $Reserved; // (3)
    /** @var array<GoalGlobal> 0x02 Goal GoalGlobal */
	public array $Goal;
    
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

        $this->Reserved = $this->getShort($hex, 0x00);
        $this->Goal = [];
        $offset = 0x02;
        for ($i = 0; $i < 3; $i++) {
            $t = (new GoalGlobal(substr($hex, $offset), $this->TIE))->loadHex();
            $this->Goal[] = $t;
            $offset += $t->getLength();
        }
        

        $this->hex = substr($this->hex, 0, $this->getLength());
        return $this;
    }
    
    public function __debugInfo(): array
    {
        return [
            "Reserved" => $this->Reserved,
            "Goal" => $this->Goal
        ];
    }
    
    public function toHexString($hex = null): string
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $hex = $this->writeShort($this->Reserved, $hex, 0x00);
        $offset = 0x02;
        for ($i = 0; $i < 3; $i++) {
            $t = $this->Goal[$i];
            $hex = $this->writeObject($t, $hex, $offset);
            $offset += $t->getLength();
        }

        return $hex;
    }
    
    
    public function getLength(): int
    {
        return self::GLOBALGOALLENGTH;
    }
}