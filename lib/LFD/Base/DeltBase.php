<?php

namespace Pyrite\LFD\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\LFD\Header;
use Pyrite\LFD\Row;
use Pyrite\PyriteBase;
use Pyrite\PyriteModel;

abstract class DeltBase extends PyriteBase implements Byteable, PyriteModel
{
    use HexDecoder;
    use HexEncoder;

    /** @var int DeltLength INT */
	public int $DeltLength;
    /** @var Header 0x00 Header Header */
	public Header $Header;
    /** @var int 0x10 Left SHORT */
	public int $Left;
    /** @var int 0x12 Top SHORT */
	public int $Top;
    /** @var int 0x14 Right SHORT */
	public int $Right;
    /** @var int 0x16 Bottom SHORT */
	public int $Bottom;
    /** @var array<Row> 0x18 Rows Row */
	public array $Rows;
    /** @var int PV Reserved SHORT */
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

        $this->Header = (new Header(substr($hex, 0x00), $this->TIE))->loadHex();
        $this->Left = $this->getShort($hex, 0x10);
        $this->Top = $this->getShort($hex, 0x12);
        $this->Right = $this->getShort($hex, 0x14);
        $this->Bottom = $this->getShort($hex, 0x16);
        $this->Rows = [];
        $offset = 0x18;
        for ($i = 0; $i < $this->RowCount(); $i++) {
            $t = (new Row(substr($hex, $offset), $this->TIE))->loadHex();
            $this->Rows[] = $t;
            $offset += $t->getLength();
        }
        // static SHORT value Reserved = 0
        $offset += 2;
        $this->DeltLength = $offset;

        $this->hex = substr($this->hex, 0, $this->getLength());
        $this->afterLoadHex();
        return $this;
    }
    
    public function __debugInfo(): array
    {
        return [
            "Header" => $this->Header,
            "Left" => $this->Left,
            "Top" => $this->Top,
            "Right" => $this->Right,
            "Bottom" => $this->Bottom,
            "Rows" => $this->Rows
        ];
    }
    
    public function toHexString($hex = null): string
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $hex = $this->writeObject($this->Header, $hex, 0x00);
        $hex = $this->writeShort($this->Left, $hex, 0x10);
        $hex = $this->writeShort($this->Top, $hex, 0x12);
        $hex = $this->writeShort($this->Right, $hex, 0x14);
        $hex = $this->writeShort($this->Bottom, $hex, 0x16);
        $offset = 0x18;
        for ($i = 0; $i < $this->RowCount(); $i++) {
            $t = $this->Rows[$i];
            $hex = $this->writeObject($t, $hex, $offset);
            $offset += $t->getLength();
        }
        $hex = $this->writeShort(0, $hex, $offset);

        return $hex;
    }
    
    protected abstract function RowCount();
    public function getLength(): int
    {
        return $this->DeltLength;
    }
}