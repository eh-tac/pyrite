<?php

namespace Pyrite\XvT\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;
use Pyrite\PyriteModel;

abstract class TeamBase extends PyriteBase implements Byteable, PyriteModel
{
    use HexDecoder;
    use HexEncoder;

    /** @var int TEAMLENGTH INT */
	public const TEAMLENGTH = 487;
    /** @var int 0x000 Reserved SHORT */
	public int $Reserved; // (1)
    /** @var string 0x002 Name STR */
	public string $Name;
    /** @var array<bool> 0x01A Allegiances BOOL */
	public array $Allegiances;
    /** @var array<string> 0x024 EndOfMissionMessages CHAR */
	public array $EndOfMissionMessages;
    
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

        $this->Reserved = $this->getShort($hex, 0x000);
        $this->Name = $this->getString($hex, 0x002);
        $this->Allegiances = [];
        $offset = 0x01A;
        for ($i = 0; $i < 10; $i++) {
            $t = $this->getBool($hex, $offset);
            $this->Allegiances[] = $t;
            $offset += 1;
        }
        $this->EndOfMissionMessages = [];
        $offset = 0x024;
        for ($i = 0; $i < 6; $i++) {
            $t = $this->getChar($hex, $offset, 64);
            $this->EndOfMissionMessages[] = $t;
            $offset += 64;
        }
        

        $this->hex = substr($this->hex, 0, $this->getLength());
        $this->afterLoadHex();
        return $this;
    }
    
    public function __debugInfo(): array
    {
        return [
            "Reserved" => $this->Reserved,
            "Name" => $this->Name,
            "Allegiances" => $this->Allegiances,
            "EndOfMissionMessages" => $this->EndOfMissionMessages
        ];
    }
    
    public function toHexString($hex = null): string
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $hex = $this->writeShort($this->Reserved, $hex, 0x000);
        $hex = $this->writeString($this->Name, $hex, 0x002);
        $offset = 0x01A;
        for ($i = 0; $i < 10; $i++) {
            $t = $this->Allegiances[$i];
            $hex = $this->writeBool($t, $hex, $offset);
            $offset += 1;
        }
        $offset = 0x024;
        for ($i = 0; $i < 6; $i++) {
            $t = $this->EndOfMissionMessages[$i];
            $hex = $this->writeChar($t, $hex, $offset);
            $offset += 64;
        }

        return $hex;
    }
    
    
    public function getLength(): int
    {
        return self::TEAMLENGTH;
    }
}