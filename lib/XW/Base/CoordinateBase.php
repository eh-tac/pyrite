<?php

namespace Pyrite\XW\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;
use Pyrite\PyriteModel;

abstract class CoordinateBase extends PyriteBase implements Byteable, PyriteModel
{
    use HexDecoder;
    use HexEncoder;

    /** @var int COORDINATELENGTH INT */
	public const COORDINATELENGTH = 6;
    /** @var int 0x00 X SHORT */
	public int $X;
    /** @var int 0x02 Y SHORT */
	public int $Y;
    /** @var int 0x04 Z SHORT */
	public int $Z;
    
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

        $this->X = $this->getShort($hex, 0x00);
        $this->Y = $this->getShort($hex, 0x02);
        $this->Z = $this->getShort($hex, 0x04);
        

        $this->hex = substr($this->hex, 0, $this->getLength());
        $this->afterLoadHex();
        return $this;
    }
    
    public function __debugInfo(): array
    {
        return [
            "X" => $this->X,
            "Y" => $this->Y,
            "Z" => $this->Z
        ];
    }
    
    public function toHexString($hex = null): string
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $hex = $this->writeShort($this->X, $hex, 0x00);
        $hex = $this->writeShort($this->Y, $hex, 0x02);
        $hex = $this->writeShort($this->Z, $hex, 0x04);

        return $hex;
    }
    
    
    public function getLength(): int
    {
        return self::COORDINATELENGTH;
    }
}