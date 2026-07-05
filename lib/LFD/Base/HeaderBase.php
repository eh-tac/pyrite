<?php

namespace Pyrite\LFD\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;
use Pyrite\PyriteModel;

abstract class HeaderBase extends PyriteBase implements Byteable, PyriteModel
{
    use HexDecoder;
    use HexEncoder;

    /** @var int HEADERLENGTH INT */
	public const HEADERLENGTH = 16;
    /** @var string 0x00 Type CHAR */
	public string $Type;
    /** @var string 0x04 Name CHAR */
	public string $Name;
    /** @var int 0x0C Length INT */
	public int $Length; // little endian
    
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

        $this->Type = $this->getChar($hex, 0x00, 4);
        $this->Name = $this->getChar($hex, 0x04, 8);
        $this->Length = $this->getInt($hex, 0x0C);
        

        $this->hex = substr($this->hex, 0, $this->getLength());
        return $this;
    }
    
    public function __debugInfo(): array
    {
        return [
            "Type" => $this->Type,
            "Name" => $this->Name,
            "Length" => $this->Length
        ];
    }
    
    public function toHexString($hex = null): string
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $hex = $this->writeChar($this->Type, $hex, 0x00);
        $hex = $this->writeChar($this->Name, $hex, 0x04);
        $hex = $this->writeInt($this->Length, $hex, 0x0C);

        return $hex;
    }
    
    
    public function getLength(): int
    {
        return self::HEADERLENGTH;
    }
}