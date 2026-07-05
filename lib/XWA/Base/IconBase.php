<?php

namespace Pyrite\XWA\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;
use Pyrite\PyriteModel;

abstract class IconBase extends PyriteBase implements Byteable, PyriteModel
{
    use HexDecoder;
    use HexEncoder;

    /** @var int ICONLENGTH INT */
	public const ICONLENGTH = 24;
    /** @var int 0x00 Species BYTE */
	public int $Species;
    /** @var int 0x01 IFF BYTE */
	public int $IFF;
    /** @var int 0x02 X SHORT */
	public int $X;
    /** @var int 0x04 Y SHORT */
	public int $Y;
    /** @var int 0x06 Orientation SHORT */
	public int $Orientation;
    
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

        $this->Species = $this->getByte($hex, 0x00);
        $this->IFF = $this->getByte($hex, 0x01);
        $this->X = $this->getShort($hex, 0x02);
        $this->Y = $this->getShort($hex, 0x04);
        $this->Orientation = $this->getShort($hex, 0x06);
        

        $this->hex = substr($this->hex, 0, $this->getLength());
        return $this;
    }
    
    public function __debugInfo(): array
    {
        return [
            "Species" => $this->Species,
            "IFF" => $this->IFF,
            "X" => $this->X,
            "Y" => $this->Y,
            "Orientation" => $this->Orientation
        ];
    }
    
    public function toHexString($hex = null): string
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $hex = $this->writeByte($this->Species, $hex, 0x00);
        $hex = $this->writeByte($this->IFF, $hex, 0x01);
        $hex = $this->writeShort($this->X, $hex, 0x02);
        $hex = $this->writeShort($this->Y, $hex, 0x04);
        $hex = $this->writeShort($this->Orientation, $hex, 0x06);

        return $hex;
    }
    
    
    public function getLength(): int
    {
        return self::ICONLENGTH;
    }
}