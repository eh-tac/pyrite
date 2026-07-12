<?php

namespace Pyrite\XW\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;
use Pyrite\PyriteModel;

abstract class XWStringBase extends PyriteBase implements Byteable, PyriteModel
{
    use HexDecoder;
    use HexEncoder;

    /** @var int XWStringLength INT */
	public int $XWStringLength;
    /** @var int 0x0 Length SHORT */
	public int $Length;
    /** @var array<string> 0x2 Content CHAR */
	public array $Content;
    /** @var array<int> PV Highlight BYTE */
	public array $Highlight;
    
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
        $this->Content = [];
        $offset = 0x2;
        for ($i = 0; $i < $this->Length; $i++) {
            $t = $this->getChar($hex, $offset, 1);
            $this->Content[] = $t;
            $offset += 1;
        }
        $this->Highlight = [];
        $offset = $offset;
        for ($i = 0; $i < $this->Length; $i++) {
            $t = $this->getByte($hex, $offset);
            $this->Highlight[] = $t;
            $offset += 1;
        }
        $this->XWStringLength = $offset;

        $this->hex = substr($this->hex, 0, $this->getLength());
        $this->afterLoadHex();
        return $this;
    }
    
    public function __debugInfo(): array
    {
        return [
            "Length" => $this->Length,
            "Content" => $this->Content,
            "Highlight" => $this->Highlight
        ];
    }
    
    public function toHexString($hex = null): string
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $hex = $this->writeShort($this->Length, $hex, 0x0);
        $offset = 0x2;
        for ($i = 0; $i < $this->Length; $i++) {
            $t = $this->Content[$i];
            $hex = $this->writeChar($t, $hex, $offset);
            $offset += 1;
        }
        $offset = $offset;
        for ($i = 0; $i < $this->Length; $i++) {
            $t = $this->Highlight[$i];
            $hex = $this->writeByte($t, $hex, $offset);
            $offset += 1;
        }

        return $hex;
    }
    
    
    public function getLength(): int
    {
        return $this->XWStringLength;
    }
}