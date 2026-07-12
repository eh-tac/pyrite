<?php

namespace Pyrite\LFD\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\LFD\Header;
use Pyrite\LFD\VoicData;
use Pyrite\PyriteBase;
use Pyrite\PyriteModel;

abstract class VoicBase extends PyriteBase implements Byteable, PyriteModel
{
    use HexDecoder;
    use HexEncoder;

    /** @var int VoicLength INT */
	public int $VoicLength;
    /** @var Header 0x00 Header Header */
	public Header $Header;
    /** @var string 0x10 Creative CHAR */
	public string $Creative;
    /** @var array<int> 0x23 Abort BYTE */
	public array $Abort;
    /** @var array<int> 0x26 Version BYTE */
	public array $Version;
    /** @var array<int> 0x28 VersionHash BYTE */
	public array $VersionHash;
    /** @var VoicData 0x2A Data VoicData */
	public VoicData $Data;
    /** @var int PV Terminator BYTE */
	public int $Terminator;
    
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
        $this->Creative = $this->getChar($hex, 0x10, 19);
        $this->Abort = [];
        $offset = 0x23;
        for ($i = 0; $i < 3; $i++) {
            $t = $this->getByte($hex, $offset);
            $this->Abort[] = $t;
            $offset += 1;
        }
        $this->Version = [];
        $offset = 0x26;
        for ($i = 0; $i < 2; $i++) {
            $t = $this->getByte($hex, $offset);
            $this->Version[] = $t;
            $offset += 1;
        }
        $this->VersionHash = [];
        $offset = 0x28;
        for ($i = 0; $i < 2; $i++) {
            $t = $this->getByte($hex, $offset);
            $this->VersionHash[] = $t;
            $offset += 1;
        }
        $this->Data = (new VoicData(substr($hex, 0x2A), $this->TIE))->loadHex();
        $offset = 0x2A + $this->Data->getLength();
        $this->Terminator = $this->getByte($hex, $offset);
        $this->VoicLength = $offset;

        $this->hex = substr($this->hex, 0, $this->getLength());
        $this->afterLoadHex();
        return $this;
    }
    
    public function __debugInfo(): array
    {
        return [
            "Header" => $this->Header,
            "Creative" => $this->Creative,
            "Abort" => $this->Abort,
            "Version" => $this->Version,
            "VersionHash" => $this->VersionHash,
            "Data" => $this->Data,
            "Terminator" => $this->Terminator
        ];
    }
    
    public function toHexString($hex = null): string
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $hex = $this->writeObject($this->Header, $hex, 0x00);
        $hex = $this->writeChar($this->Creative, $hex, 0x10);
        $offset = 0x23;
        for ($i = 0; $i < 3; $i++) {
            $t = $this->Abort[$i];
            $hex = $this->writeByte($t, $hex, $offset);
            $offset += 1;
        }
        $offset = 0x26;
        for ($i = 0; $i < 2; $i++) {
            $t = $this->Version[$i];
            $hex = $this->writeByte($t, $hex, $offset);
            $offset += 1;
        }
        $offset = 0x28;
        for ($i = 0; $i < 2; $i++) {
            $t = $this->VersionHash[$i];
            $hex = $this->writeByte($t, $hex, $offset);
            $offset += 1;
        }
        $hex = $this->writeObject($this->Data, $hex, 0x2A);
        $hex = $this->writeByte($this->Terminator, $hex, $offset);

        return $hex;
    }
    
    
    public function getLength(): int
    {
        return $this->VoicLength;
    }
}