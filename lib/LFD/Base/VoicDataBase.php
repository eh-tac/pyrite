<?php

namespace Pyrite\LFD\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;
use Pyrite\PyriteModel;

abstract class VoicDataBase extends PyriteBase implements Byteable, PyriteModel
{
    use HexDecoder;
    use HexEncoder;

    /** @var int VoicDataLength INT */
	public int $VoicDataLength;
    /** @var int 0x00 Type BYTE */
	public int $Type;
    /** @var array<int> 0x01 Size BYTE */
	public array $Size;
    /** @var int 0x04 Data BYTE */
	public int $Data;
    
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

        $this->Type = $this->getByte($hex, 0x00);
        $this->Size = [];
        $offset = 0x01;
        for ($i = 0; $i < 3; $i++) {
            $t = $this->getByte($hex, $offset);
            $this->Size[] = $t;
            $offset += 1;
        }
        $this->Data = $this->getByte($hex, 0x04);
        $this->VoicDataLength = $offset;

        $this->hex = substr($this->hex, 0, $this->getLength());
        return $this;
    }
    
    public function __debugInfo(): array
    {
        return [
            "Type" => $this->Type,
            "Size" => $this->Size,
            "Data" => $this->Data
        ];
    }
    
    public function toHexString($hex = null): string
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $hex = $this->writeByte($this->Type, $hex, 0x00);
        $offset = 0x01;
        for ($i = 0; $i < 3; $i++) {
            $t = $this->Size[$i];
            $hex = $this->writeByte($t, $hex, $offset);
            $offset += 1;
        }
        $hex = $this->writeByte($this->Data, $hex, 0x04);

        return $hex;
    }
    
    
    public function getLength(): int
    {
        return $this->VoicDataLength;
    }
}