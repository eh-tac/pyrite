<?php

namespace Pyrite\LFD\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\LFD\BattleText;
use Pyrite\LFD\Delt;
use Pyrite\LFD\Rmap;
use Pyrite\PyriteBase;
use Pyrite\PyriteModel;

abstract class TIEBattleBase extends PyriteBase implements Byteable, PyriteModel
{
    use HexDecoder;
    use HexEncoder;

    /** @var int TIEBattleLength INT */
	public int $TIEBattleLength;
    /** @var Rmap 0x00 HeaderMap Rmap */
	public Rmap $HeaderMap;
    /** @var BattleText 0x30 BattleName BattleText */
	public BattleText $BattleName;
    /** @var Delt PV BattleImage Delt */
	public Delt $BattleImage;
    
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

        $this->HeaderMap = (new Rmap(substr($hex, 0x00), $this->TIE))->loadHex();
        $offset = 0x00 + $this->HeaderMap->getLength();
        $this->BattleName = (new BattleText(substr($hex, 0x30), $this->TIE))->loadHex();
        $offset = 0x30 + $this->BattleName->getLength();
        $this->BattleImage = (new Delt(substr($hex, $offset), $this->TIE))->loadHex();
        $offset += $this->BattleImage->getLength();
        $this->TIEBattleLength = $offset;

        $this->hex = substr($this->hex, 0, $this->getLength());
        $this->afterLoadHex();
        return $this;
    }
    
    public function __debugInfo(): array
    {
        return [
            "HeaderMap" => $this->HeaderMap,
            "BattleName" => $this->BattleName,
            "BattleImage" => $this->BattleImage
        ];
    }
    
    public function toHexString($hex = null): string
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $hex = $this->writeObject($this->HeaderMap, $hex, 0x00);
        $hex = $this->writeObject($this->BattleName, $hex, 0x30);
        $hex = $this->writeObject($this->BattleImage, $hex, $offset);

        return $hex;
    }
    
    
    public function getLength(): int
    {
        return $this->TIEBattleLength;
    }
}