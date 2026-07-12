<?php

namespace Pyrite\LFD\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\LFD\LString;
use Pyrite\PyriteBase;
use Pyrite\PyriteModel;

abstract class LTextBase extends PyriteBase implements Byteable, PyriteModel
{
    use HexDecoder;
    use HexEncoder;

    /** @var int LTextLength INT */
	public int $LTextLength;
    /** @var int 0x00 NumStrings SHORT */
	public int $NumStrings;
    /** @var array<LString> 0x02 Strings LString */
	public array $Strings;
    
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

        $this->NumStrings = $this->getShort($hex, 0x00);
        $this->Strings = [];
        $offset = 0x02;
        for ($i = 0; $i < $this->NumStrings; $i++) {
            $t = (new LString(substr($hex, $offset), $this->TIE))->loadHex();
            $this->Strings[] = $t;
            $offset += $t->getLength();
        }
        $this->LTextLength = $offset;

        $this->hex = substr($this->hex, 0, $this->getLength());
        $this->afterLoadHex();
        return $this;
    }
    
    public function __debugInfo(): array
    {
        return [
            "NumStrings" => $this->NumStrings,
            "Strings" => $this->Strings
        ];
    }
    
    public function toHexString($hex = null): string
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $hex = $this->writeShort($this->NumStrings, $hex, 0x00);
        $offset = 0x02;
        for ($i = 0; $i < $this->NumStrings; $i++) {
            $t = $this->Strings[$i];
            $hex = $this->writeObject($t, $hex, $offset);
            $offset += $t->getLength();
        }

        return $hex;
    }
    
    
    public function getLength(): int
    {
        return $this->LTextLength;
    }
}