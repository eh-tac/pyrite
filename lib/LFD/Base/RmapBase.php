<?php

namespace Pyrite\LFD\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\LFD\Header;
use Pyrite\PyriteBase;
use Pyrite\PyriteModel;

abstract class RmapBase extends PyriteBase implements Byteable, PyriteModel
{
    use HexDecoder;
    use HexEncoder;

    /** @var int RmapLength INT */
	public int $RmapLength;
    /** @var Header 0x00 Header Header */
	public Header $Header;
    /** @var array<Header> 0x10 Subheaders Header */
	public array $Subheaders;
    
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

        $this->Header = (new Header(substr($hex, 0x00), $this->TIE))->loadHex();
        $this->Subheaders = [];
        $offset = 0x10;
        for ($i = 0; $i < $this->HeaderCount(); $i++) {
            $t = (new Header(substr($hex, $offset), $this->TIE))->loadHex();
            $this->Subheaders[] = $t;
            $offset += $t->getLength();
        }
        $this->RmapLength = $offset;

        $this->hex = substr($this->hex, 0, $this->getLength());
        return $this;
    }
    
    public function __debugInfo(): array
    {
        return [
            "Header" => $this->Header,
            "Subheaders" => $this->Subheaders
        ];
    }
    
    public function toHexString($hex = null): string
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $hex = $this->writeObject($this->Header, $hex, 0x00);
        $offset = 0x10;
        for ($i = 0; $i < $this->HeaderCount(); $i++) {
            $t = $this->Subheaders[$i];
            $hex = $this->writeObject($t, $hex, $offset);
            $offset += $t->getLength();
        }

        return $hex;
    }
    
    protected abstract function HeaderCount();
    public function getLength(): int
    {
        return $this->RmapLength;
    }
}