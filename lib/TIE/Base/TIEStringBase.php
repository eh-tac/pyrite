<?php

namespace Pyrite\TIE\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;
use Pyrite\PyriteModel;

abstract class TIEStringBase extends PyriteBase implements Byteable, PyriteModel
{
    use HexDecoder;
    use HexEncoder;

    /** @var int TIEStringLength INT */
	public int $TIEStringLength;
    /** @var int 0x0 Length SHORT */
	public int $Length;
    /** @var string 0x2 Text CHAR */
	public string $Text;
    
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

        $this->Length = $this->getShort($hex, 0x0);
        $this->Text = $this->getChar($hex, 0x2, $this->Length);
        $offset = 0x2 + $this->Length;
        $this->TIEStringLength = $offset;

        $this->hex = substr($this->hex, 0, $this->getLength());
        return $this;
    }
    
    public function __debugInfo(): array
    {
        return [
            "Length" => $this->Length,
            "Text" => $this->Text
        ];
    }
    
    public function toHexString($hex = null): string
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $hex = $this->writeShort($this->Length, $hex, 0x0);
        $hex = $this->writeChar($this->Text, $hex, 0x2);

        return $hex;
    }
    
    
    public function getLength(): int
    {
        return $this->TIEStringLength;
    }
}