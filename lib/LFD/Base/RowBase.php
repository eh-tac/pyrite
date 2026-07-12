<?php

namespace Pyrite\LFD\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\LFD\OpCode;
use Pyrite\PyriteBase;
use Pyrite\PyriteModel;

abstract class RowBase extends PyriteBase implements Byteable, PyriteModel
{
    use HexDecoder;
    use HexEncoder;

    /** @var int RowLength INT */
	public int $RowLength;
    /** @var int 0x00 Length SHORT */
	public int $Length;
    /** @var int 0x02 Left SHORT */
	public int $Left;
    /** @var int 0x04 Top SHORT */
	public int $Top;
    /** @var array<int> 0x06 ColorIndexes BYTE */
	public array $ColorIndexes;
    /** @var array<OpCode> 0x06 Operations OpCode */
	public array $Operations;
    
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
        $this->Left = $this->getShort($hex, 0x02);
        $this->Top = $this->getShort($hex, 0x04);
        $this->ColorIndexes = [];
        $offset = 0x06;
        for ($i = 0; $i < $this->ColorCount(); $i++) {
            $t = $this->getByte($hex, $offset);
            $this->ColorIndexes[] = $t;
            $offset += 1;
        }
        $this->Operations = [];
        $offset = 0x06;
        for ($i = 0; $i < $this->OpCount(); $i++) {
            $t = (new OpCode(substr($hex, $offset), $this->TIE))->loadHex();
            $this->Operations[] = $t;
            $offset += $t->getLength();
        }
        $this->RowLength = $offset;

        $this->hex = substr($this->hex, 0, $this->getLength());
        $this->afterLoadHex();
        return $this;
    }
    
    public function __debugInfo(): array
    {
        return [
            "Length" => $this->Length,
            "Left" => $this->Left,
            "Top" => $this->Top,
            "ColorIndexes" => $this->ColorIndexes,
            "Operations" => $this->Operations
        ];
    }
    
    public function toHexString($hex = null): string
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $hex = $this->writeShort($this->Length, $hex, 0x00);
        $hex = $this->writeShort($this->Left, $hex, 0x02);
        $hex = $this->writeShort($this->Top, $hex, 0x04);
        $offset = 0x06;
        for ($i = 0; $i < $this->ColorCount(); $i++) {
            $t = $this->ColorIndexes[$i];
            $hex = $this->writeByte($t, $hex, $offset);
            $offset += 1;
        }
        $offset = 0x06;
        for ($i = 0; $i < $this->OpCount(); $i++) {
            $t = $this->Operations[$i];
            $hex = $this->writeObject($t, $hex, $offset);
            $offset += $t->getLength();
        }

        return $hex;
    }
    
    protected abstract function ColorCount();
protected abstract function OpCount();
    public function getLength(): int
    {
        return $this->RowLength;
    }
}