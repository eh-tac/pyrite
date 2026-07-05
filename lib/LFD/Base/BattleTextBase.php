<?php

namespace Pyrite\LFD\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\LFD\Header;
use Pyrite\LFD\LString;
use Pyrite\PyriteBase;
use Pyrite\PyriteModel;

abstract class BattleTextBase extends PyriteBase implements Byteable, PyriteModel
{
    use HexDecoder;
    use HexEncoder;

    /** @var int BattleTextLength INT */
	public int $BattleTextLength;
    /** @var Header 0x00 Header Header */
	public Header $Header;
    /** @var int 0x10 NumStrings SHORT */
	public int $NumStrings;
    /** @var LString 0x12 Names LString */
	public LString $Names;
    /** @var LString PV Titles LString */
	public LString $Titles;
    /** @var LString PV Image LString */
	public LString $Image;
    /** @var LString PV MissionFiles LString */
	public LString $MissionFiles;
    /** @var array<LString> PV MissionDescriptions LString */
	public array $MissionDescriptions;
    
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
        $this->NumStrings = $this->getShort($hex, 0x10);
        $this->Names = (new LString(substr($hex, 0x12), $this->TIE))->loadHex();
        $offset = 0x12 + $this->Names->getLength();
        $this->Titles = (new LString(substr($hex, $offset), $this->TIE))->loadHex();
        $offset += $this->Titles->getLength();
        $this->Image = (new LString(substr($hex, $offset), $this->TIE))->loadHex();
        $offset += $this->Image->getLength();
        $this->MissionFiles = (new LString(substr($hex, $offset), $this->TIE))->loadHex();
        $offset += $this->MissionFiles->getLength();
        $this->MissionDescriptions = [];
        $offset = $offset;
        for ($i = 0; $i < $this->NumMissions(); $i++) {
            $t = (new LString(substr($hex, $offset), $this->TIE))->loadHex();
            $this->MissionDescriptions[] = $t;
            $offset += $t->getLength();
        }
        $this->BattleTextLength = $offset;

        $this->hex = substr($this->hex, 0, $this->getLength());
        return $this;
    }
    
    public function __debugInfo(): array
    {
        return [
            "Header" => $this->Header,
            "NumStrings" => $this->NumStrings,
            "Names" => $this->Names,
            "Titles" => $this->Titles,
            "Image" => $this->Image,
            "MissionFiles" => $this->MissionFiles,
            "MissionDescriptions" => $this->MissionDescriptions
        ];
    }
    
    public function toHexString($hex = null): string
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $hex = $this->writeObject($this->Header, $hex, 0x00);
        $hex = $this->writeShort($this->NumStrings, $hex, 0x10);
        $hex = $this->writeObject($this->Names, $hex, 0x12);
        $hex = $this->writeObject($this->Titles, $hex, $offset);
        $hex = $this->writeObject($this->Image, $hex, $offset);
        $hex = $this->writeObject($this->MissionFiles, $hex, $offset);
        $offset = $offset;
        for ($i = 0; $i < $this->NumMissions(); $i++) {
            $t = $this->MissionDescriptions[$i];
            $hex = $this->writeObject($t, $hex, $offset);
            $offset += $t->getLength();
        }

        return $hex;
    }
    
    protected abstract function NumMissions();
    public function getLength(): int
    {
        return $this->BattleTextLength;
    }
}