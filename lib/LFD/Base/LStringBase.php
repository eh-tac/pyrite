<?php

namespace Pyrite\LFD\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;
use Pyrite\PyriteModel;

abstract class LStringBase extends PyriteBase implements Byteable, PyriteModel
{
    use HexDecoder;
    use HexEncoder;

    /** @var int LStringLength INT */
	public int $LStringLength;
    /** @var int 0x00 Length SHORT */
	public int $Length;
    /** @var array<string> 0x02 Substrings STR */
	public array $Substrings;
    /** @var int PV Reserved BYTE */
	public const Reserved = 0;
    
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

        $this->Length = $this->getShort($hex, 0x00);
        $this->Substrings = [];
        $offset = 0x02;
		// @phpstan-ignore smaller.alwaysFalse
        for ($i = 0; $i < 0; $i++) {
            $t = $this->getString($hex, $offset);
            $this->Substrings[] = $t;
            $offset += strlen($t);
        }
        // static BYTE value Reserved = 0
        $offset += 1;
        $this->LStringLength = $offset;

        $this->hex = substr($this->hex, 0, $this->getLength());
        return $this;
    }
    
    public function __debugInfo(): array
    {
        return [
            "Length" => $this->Length,
            "Substrings" => $this->Substrings
        ];
    }
    
    public function toHexString($hex = null): string
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $hex = $this->writeShort($this->Length, $hex, 0x00);
        $offset = 0x02;
		// @phpstan-ignore smaller.alwaysFalse
        for ($i = 0; $i < 0; $i++) {
            $t = $this->Substrings[$i];
            $hex = $this->writeString($t, $hex, $offset);
            $offset += strlen($t);
        }
        $hex = $this->writeByte(0, $hex, $offset);

        return $hex;
    }
    
    
    public function getLength(): int
    {
        return $this->LStringLength;
    }
}