<?php

namespace Pyrite\LFD\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;
use Pyrite\PyriteModel;

abstract class OpCodeBase extends PyriteBase implements Byteable, PyriteModel
{
    use HexDecoder;
    use HexEncoder;

    /** @var int OpCodeLength INT */
	public int $OpCodeLength;
    /** @var int 0x00 Value BYTE */
	public int $Value;
    /** @var array<int> 0x01 ColorIndex BYTE */
	public array $ColorIndex;
    
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

        $this->Value = $this->getByte($hex, 0x00);
        $this->ColorIndex = [];
        $offset = 0x01;
        for ($i = 0; $i < $this->ColorCount(); $i++) {
            $t = $this->getByte($hex, $offset);
            $this->ColorIndex[] = $t;
            $offset += 1;
        }
        $this->OpCodeLength = $offset;

        $this->hex = substr($this->hex, 0, $this->getLength());
        return $this;
    }
    
    public function __debugInfo(): array
    {
        return [
            "Value" => $this->Value,
            "ColorIndex" => $this->ColorIndex
        ];
    }
    
    public function toHexString($hex = null): string
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $hex = $this->writeByte($this->Value, $hex, 0x00);
        $offset = 0x01;
        for ($i = 0; $i < $this->ColorCount(); $i++) {
            $t = $this->ColorIndex[$i];
            $hex = $this->writeByte($t, $hex, $offset);
            $offset += 1;
        }

        return $hex;
    }
    
    protected abstract function ColorCount();
    public function getLength(): int
    {
        return $this->OpCodeLength;
    }
}