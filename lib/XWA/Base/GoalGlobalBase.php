<?php

namespace Pyrite\XWA\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;
use Pyrite\PyriteModel;
use Pyrite\XWA\TriggerPair;

abstract class GoalGlobalBase extends PyriteBase implements Byteable, PyriteModel
{
    use HexDecoder;
    use HexEncoder;

    /** @var int GOALGLOBALLENGTH INT */
	public const GOALGLOBALLENGTH = 122;
    /** @var array<TriggerPair> 0x00 Triggers TriggerPair */
	public array $Triggers; // (contained Unknown1)
    /** @var string 0x20 Name STR */
	public string $Name; // (contains Unknown2)
    /** @var int 0x30 Version BYTE */
	public int $Version;
    /** @var bool 0x31 Triggers12OrTriggers34 BOOL */
	public bool $Triggers12OrTriggers34;
    /** @var int 0x32 Delay BYTE */
	public int $Delay; // (was Unknown3)
    /** @var int 0x33 Points SBYTE */
	public int $Points;
    /** @var array<int> 0x34 PointsPerTrigger BYTE */
	public array $PointsPerTrigger; // (was Unknown4-6)
    /** @var int 0x38 ActiveSquence BYTE */
	public int $ActiveSquence;
    
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

        $this->Triggers = [];
        $offset = 0x00;
        for ($i = 0; $i < 2; $i++) {
            $t = (new TriggerPair(substr($hex, $offset), $this->TIE))->loadHex();
            $this->Triggers[] = $t;
            $offset += $t->getLength();
        }
        $this->Name = $this->getString($hex, 0x20);
        $this->Version = $this->getByte($hex, 0x30);
        $this->Triggers12OrTriggers34 = $this->getBool($hex, 0x31);
        $this->Delay = $this->getByte($hex, 0x32);
        $this->Points = $this->getSByte($hex, 0x33);
        $this->PointsPerTrigger = [];
        $offset = 0x34;
        for ($i = 0; $i < 4; $i++) {
            $t = $this->getByte($hex, $offset);
            $this->PointsPerTrigger[] = $t;
            $offset += 1;
        }
        $this->ActiveSquence = $this->getByte($hex, 0x38);
        

        $this->hex = substr($this->hex, 0, $this->getLength());
        $this->afterLoadHex();
        return $this;
    }
    
    public function __debugInfo(): array
    {
        return [
            "Triggers" => $this->Triggers,
            "Name" => $this->Name,
            "Version" => $this->Version,
            "Triggers12OrTriggers34" => $this->Triggers12OrTriggers34,
            "Delay" => $this->Delay,
            "Points" => $this->Points,
            "PointsPerTrigger" => $this->PointsPerTrigger,
            "ActiveSquence" => $this->ActiveSquence
        ];
    }
    
    public function toHexString($hex = null): string
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $offset = 0x00;
        for ($i = 0; $i < 2; $i++) {
            $t = $this->Triggers[$i];
            $hex = $this->writeObject($t, $hex, $offset);
            $offset += $t->getLength();
        }
        $hex = $this->writeString($this->Name, $hex, 0x20);
        $hex = $this->writeByte($this->Version, $hex, 0x30);
        $hex = $this->writeBool($this->Triggers12OrTriggers34, $hex, 0x31);
        $hex = $this->writeByte($this->Delay, $hex, 0x32);
        $hex = $this->writeSByte($this->Points, $hex, 0x33);
        $offset = 0x34;
        for ($i = 0; $i < 4; $i++) {
            $t = $this->PointsPerTrigger[$i];
            $hex = $this->writeByte($t, $hex, $offset);
            $offset += 1;
        }
        $hex = $this->writeByte($this->ActiveSquence, $hex, 0x38);

        return $hex;
    }
    
    
    public function getLength(): int
    {
        return self::GOALGLOBALLENGTH;
    }
}