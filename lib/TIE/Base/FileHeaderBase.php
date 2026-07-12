<?php

namespace Pyrite\TIE\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;
use Pyrite\PyriteModel;
use Pyrite\TIE\Constants;

abstract class FileHeaderBase extends PyriteBase implements Byteable, PyriteModel
{
    use HexDecoder;
    use HexEncoder;

    /** @var int FILEHEADERLENGTH INT */
	public const FILEHEADERLENGTH = 458;
    /** @var int 0x000 PlatformID SHORT */
	public const PlatformID = -1;
    /** @var int 0x002 NumFGs SHORT */
	public int $NumFGs;
    /** @var int 0x004 NumMessages SHORT */
	public int $NumMessages;
    /** @var int 0x006 NumGGs SHORT */
	public const NumGGs = 3; // might be # of GlobalGoals
    /** @var int 0x008 Unknown1 BYTE */
	public int $Unknown1;
    /** @var bool 0x009 Unknown2 BOOL */
	public bool $Unknown2;
    /** @var int 0x00A BriefingOfficers BYTE */
	public int $BriefingOfficers;
    /** @var bool 0x00D CapturedOnEject BOOL */
	public bool $CapturedOnEject;
    /** @var array<string> 0x018 EndOfMissionMessages CHAR */
	public array $EndOfMissionMessages;
    /** @var array<string> 0x19A OtherIffNames CHAR */
	public array $OtherIffNames;
    
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

        // static SHORT value PlatformID = -1
        $this->NumFGs = $this->getShort($hex, 0x002);
        $this->NumMessages = $this->getShort($hex, 0x004);
        // static SHORT value NumGGs = 3
        $this->Unknown1 = $this->getByte($hex, 0x008);
        $this->Unknown2 = $this->getBool($hex, 0x009);
        $this->BriefingOfficers = $this->getByte($hex, 0x00A);
        $this->CapturedOnEject = $this->getBool($hex, 0x00D);
        $this->EndOfMissionMessages = [];
        $offset = 0x018;
        for ($i = 0; $i < 6; $i++) {
            $t = $this->getChar($hex, $offset, 64);
            $this->EndOfMissionMessages[] = $t;
            $offset += 64;
        }
        $this->OtherIffNames = [];
        $offset = 0x19A;
        for ($i = 0; $i < 4; $i++) {
            $t = $this->getChar($hex, $offset, 12);
            $this->OtherIffNames[] = $t;
            $offset += 12;
        }
        

        $this->hex = substr($this->hex, 0, $this->getLength());
        $this->afterLoadHex();
        return $this;
    }
    
    public function __debugInfo(): array
    {
        return [
            "NumFGs" => $this->NumFGs,
            "NumMessages" => $this->NumMessages,
            "Unknown1" => $this->Unknown1,
            "Unknown2" => $this->Unknown2,
            "BriefingOfficers" => $this->getBriefingOfficersLabel(),
            "CapturedOnEject" => $this->CapturedOnEject,
            "EndOfMissionMessages" => $this->EndOfMissionMessages,
            "OtherIffNames" => $this->OtherIffNames
        ];
    }
    
    public function toHexString($hex = null): string
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $hex = $this->writeShort(-1, $hex, 0x000);
        $hex = $this->writeShort($this->NumFGs, $hex, 0x002);
        $hex = $this->writeShort($this->NumMessages, $hex, 0x004);
        $hex = $this->writeShort(3, $hex, 0x006);
        $hex = $this->writeByte($this->Unknown1, $hex, 0x008);
        $hex = $this->writeBool($this->Unknown2, $hex, 0x009);
        $hex = $this->writeByte($this->BriefingOfficers, $hex, 0x00A);
        $hex = $this->writeBool($this->CapturedOnEject, $hex, 0x00D);
        $offset = 0x018;
        for ($i = 0; $i < 6; $i++) {
            $t = $this->EndOfMissionMessages[$i];
            $hex = $this->writeChar($t, $hex, $offset);
            $offset += 64;
        }
        $offset = 0x19A;
        for ($i = 0; $i < 4; $i++) {
            $t = $this->OtherIffNames[$i];
            $hex = $this->writeChar($t, $hex, $offset);
            $offset += 12;
        }

        return $hex;
    }
    
    public function getBriefingOfficersLabel(): string 
    {
        return isset($this->BriefingOfficers) && isset(Constants::$BRIEFINGOFFICERS[$this->BriefingOfficers]) ? Constants::$BRIEFINGOFFICERS[$this->BriefingOfficers] : "Unknown";
    }
    
    public function getLength(): int
    {
        return self::FILEHEADERLENGTH;
    }
}