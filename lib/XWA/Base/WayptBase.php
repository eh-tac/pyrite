<?php

namespace Pyrite\XWA\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;
use Pyrite\PyriteModel;

abstract class WayptBase extends PyriteBase implements Byteable, PyriteModel
{
    use HexDecoder;
    use HexEncoder;

    /** @var int WAYPTLENGTH INT */
	public const WAYPTLENGTH = 8;
    /** @var int 0x0 X SHORT */
	public int $X;
    /** @var int 0x2 Y SHORT */
	public int $Y;
    /** @var int 0x4 Z SHORT */
	public int $Z;
    /** @var bool 0x6 Enabled BOOL */
	public bool $Enabled;
    
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

        $this->X = $this->getShort($hex, 0x0);
        $this->Y = $this->getShort($hex, 0x2);
        $this->Z = $this->getShort($hex, 0x4);
        $this->Enabled = $this->getBool($hex, 0x6);
        

        $this->hex = substr($this->hex, 0, $this->getLength());
        $this->afterLoadHex();
        return $this;
    }
    
    public function __debugInfo(): array
    {
        return [
            "X" => $this->X,
            "Y" => $this->Y,
            "Z" => $this->Z,
            "Enabled" => $this->Enabled
        ];
    }
    
    public function toHexString($hex = null): string
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $hex = $this->writeShort($this->X, $hex, 0x0);
        $hex = $this->writeShort($this->Y, $hex, 0x2);
        $hex = $this->writeShort($this->Z, $hex, 0x4);
        $hex = $this->writeBool($this->Enabled, $hex, 0x6);

        return $hex;
    }
    
    
    public function getLength(): int
    {
        return self::WAYPTLENGTH;
    }
}