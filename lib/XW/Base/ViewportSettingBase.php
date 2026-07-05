<?php

namespace Pyrite\XW\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;
use Pyrite\PyriteModel;

abstract class ViewportSettingBase extends PyriteBase implements Byteable, PyriteModel
{
    use HexDecoder;
    use HexEncoder;

    /** @var int VIEWPORTSETTINGLENGTH INT */
	public const VIEWPORTSETTINGLENGTH = 10;
    /** @var int 0x00 Top SHORT */
	public int $Top;
    /** @var int 0x02 Left SHORT */
	public int $Left;
    /** @var int 0x04 Bottom SHORT */
	public int $Bottom;
    /** @var int 0x06 Right SHORT */
	public int $Right;
    /** @var int 0x08 Visible SHORT */
	public int $Visible; // (boolean)
    
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

        $this->Top = $this->getShort($hex, 0x00);
        $this->Left = $this->getShort($hex, 0x02);
        $this->Bottom = $this->getShort($hex, 0x04);
        $this->Right = $this->getShort($hex, 0x06);
        $this->Visible = $this->getShort($hex, 0x08);
        

        $this->hex = substr($this->hex, 0, $this->getLength());
        return $this;
    }
    
    public function __debugInfo(): array
    {
        return [
            "Top" => $this->Top,
            "Left" => $this->Left,
            "Bottom" => $this->Bottom,
            "Right" => $this->Right,
            "Visible" => $this->Visible
        ];
    }
    
    public function toHexString($hex = null): string
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $hex = $this->writeShort($this->Top, $hex, 0x00);
        $hex = $this->writeShort($this->Left, $hex, 0x02);
        $hex = $this->writeShort($this->Bottom, $hex, 0x04);
        $hex = $this->writeShort($this->Right, $hex, 0x06);
        $hex = $this->writeShort($this->Visible, $hex, 0x08);

        return $hex;
    }
    
    
    public function getLength(): int
    {
        return self::VIEWPORTSETTINGLENGTH;
    }
}