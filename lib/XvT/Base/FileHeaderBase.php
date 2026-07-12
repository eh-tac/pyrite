<?php

namespace Pyrite\XvT\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;
use Pyrite\PyriteModel;

abstract class FileHeaderBase extends PyriteBase implements Byteable, PyriteModel
{
    use HexDecoder;
    use HexEncoder;

    /** @var int FILEHEADERLENGTH INT */
	public const FILEHEADERLENGTH = 164;
    /** @var int 0x00 PlatformID SHORT */
	public int $PlatformID;
    /** @var int 0x02 NumFGs SHORT */
	public int $NumFGs;
    /** @var int 0x04 NumMessages SHORT */
	public int $NumMessages;
    /** @var int 0x06 Unknown1 BYTE */
	public int $Unknown1;
    /** @var int 0x08 Unknown2 BYTE */
	public int $Unknown2;
    /** @var bool 0x0B Unknown3 BOOL */
	public bool $Unknown3;
    /** @var string 0x28 Unknown4 CHAR */
	public string $Unknown4;
    /** @var string 0x50 Unknown5 CHAR */
	public string $Unknown5;
    /** @var int 0x64 MissionType BYTE */
	public int $MissionType;
    /** @var bool 0x65 Unknown6 BOOL */
	public bool $Unknown6;
    /** @var int 0x66 TimeLimitMinutes BYTE */
	public int $TimeLimitMinutes;
    /** @var int 0x67 TimeLimitSeconds BYTE */
	public int $TimeLimitSeconds;
    
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

        $this->PlatformID = $this->getShort($hex, 0x00);
        $this->NumFGs = $this->getShort($hex, 0x02);
        $this->NumMessages = $this->getShort($hex, 0x04);
        $this->Unknown1 = $this->getByte($hex, 0x06);
        $this->Unknown2 = $this->getByte($hex, 0x08);
        $this->Unknown3 = $this->getBool($hex, 0x0B);
        $this->Unknown4 = $this->getChar($hex, 0x28, 16);
        $this->Unknown5 = $this->getChar($hex, 0x50, 16);
        $this->MissionType = $this->getByte($hex, 0x64);
        $this->Unknown6 = $this->getBool($hex, 0x65);
        $this->TimeLimitMinutes = $this->getByte($hex, 0x66);
        $this->TimeLimitSeconds = $this->getByte($hex, 0x67);
        

        $this->hex = substr($this->hex, 0, $this->getLength());
        $this->afterLoadHex();
        return $this;
    }
    
    public function __debugInfo(): array
    {
        return [
            "PlatformID" => $this->PlatformID,
            "NumFGs" => $this->NumFGs,
            "NumMessages" => $this->NumMessages,
            "Unknown1" => $this->Unknown1,
            "Unknown2" => $this->Unknown2,
            "Unknown3" => $this->Unknown3,
            "Unknown4" => $this->Unknown4,
            "Unknown5" => $this->Unknown5,
            "MissionType" => $this->MissionType,
            "Unknown6" => $this->Unknown6,
            "TimeLimitMinutes" => $this->TimeLimitMinutes,
            "TimeLimitSeconds" => $this->TimeLimitSeconds
        ];
    }
    
    public function toHexString($hex = null): string
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $hex = $this->writeShort($this->PlatformID, $hex, 0x00);
        $hex = $this->writeShort($this->NumFGs, $hex, 0x02);
        $hex = $this->writeShort($this->NumMessages, $hex, 0x04);
        $hex = $this->writeByte($this->Unknown1, $hex, 0x06);
        $hex = $this->writeByte($this->Unknown2, $hex, 0x08);
        $hex = $this->writeBool($this->Unknown3, $hex, 0x0B);
        $hex = $this->writeChar($this->Unknown4, $hex, 0x28);
        $hex = $this->writeChar($this->Unknown5, $hex, 0x50);
        $hex = $this->writeByte($this->MissionType, $hex, 0x64);
        $hex = $this->writeBool($this->Unknown6, $hex, 0x65);
        $hex = $this->writeByte($this->TimeLimitMinutes, $hex, 0x66);
        $hex = $this->writeByte($this->TimeLimitSeconds, $hex, 0x67);

        return $hex;
    }
    
    
    public function getLength(): int
    {
        return self::FILEHEADERLENGTH;
    }
}