<?php

namespace Pyrite\XvT\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;
use Pyrite\PyriteModel;
use Pyrite\XvT\Trigger;

abstract class GoalGlobalBase extends PyriteBase implements Byteable, PyriteModel
{
    use HexDecoder;
    use HexEncoder;

    /** @var int GOALGLOBALLENGTH INT */
	public const GOALGLOBALLENGTH = 42;
    /** @var array<Trigger> 0x00 TriggerA Trigger */
	public array $TriggerA;
    /** @var bool 0x0A Trigger1OrTrigger2 BOOL */
	public bool $Trigger1OrTrigger2;
    /** @var array<Trigger> 0x0B TriggerB Trigger */
	public array $TriggerB;
    /** @var bool 0x15 Trigger2OrTrigger3 BOOL */
	public bool $Trigger2OrTrigger3;
    /** @var bool 0x27 Trigger12OrTrigger34 BOOL */
	public bool $Trigger12OrTrigger34;
    /** @var int 0x29 Points SBYTE */
	public int $Points;
    
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

        $this->TriggerA = [];
        $offset = 0x00;
        for ($i = 0; $i < 2; $i++) {
            $t = (new Trigger(substr($hex, $offset), $this->TIE))->loadHex();
            $this->TriggerA[] = $t;
            $offset += $t->getLength();
        }
        $this->Trigger1OrTrigger2 = $this->getBool($hex, 0x0A);
        $this->TriggerB = [];
        $offset = 0x0B;
        for ($i = 0; $i < 2; $i++) {
            $t = (new Trigger(substr($hex, $offset), $this->TIE))->loadHex();
            $this->TriggerB[] = $t;
            $offset += $t->getLength();
        }
        $this->Trigger2OrTrigger3 = $this->getBool($hex, 0x15);
        $this->Trigger12OrTrigger34 = $this->getBool($hex, 0x27);
        $this->Points = $this->getSByte($hex, 0x29);
        

        $this->hex = substr($this->hex, 0, $this->getLength());
        return $this;
    }
    
    public function __debugInfo(): array
    {
        return [
            "TriggerA" => $this->TriggerA,
            "Trigger1OrTrigger2" => $this->Trigger1OrTrigger2,
            "TriggerB" => $this->TriggerB,
            "Trigger2OrTrigger3" => $this->Trigger2OrTrigger3,
            "Trigger12OrTrigger34" => $this->Trigger12OrTrigger34,
            "Points" => $this->Points
        ];
    }
    
    public function toHexString($hex = null): string
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $offset = 0x00;
        for ($i = 0; $i < 2; $i++) {
            $t = $this->TriggerA[$i];
            $hex = $this->writeObject($t, $hex, $offset);
            $offset += $t->getLength();
        }
        $hex = $this->writeBool($this->Trigger1OrTrigger2, $hex, 0x0A);
        $offset = 0x0B;
        for ($i = 0; $i < 2; $i++) {
            $t = $this->TriggerB[$i];
            $hex = $this->writeObject($t, $hex, $offset);
            $offset += $t->getLength();
        }
        $hex = $this->writeBool($this->Trigger2OrTrigger3, $hex, 0x15);
        $hex = $this->writeBool($this->Trigger12OrTrigger34, $hex, 0x27);
        $hex = $this->writeSByte($this->Points, $hex, 0x29);

        return $hex;
    }
    
    
    public function getLength(): int
    {
        return self::GOALGLOBALLENGTH;
    }
}