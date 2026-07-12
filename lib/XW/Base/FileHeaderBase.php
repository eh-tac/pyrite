<?php

namespace Pyrite\XW\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;
use Pyrite\PyriteModel;
use Pyrite\XW\Constants;

abstract class FileHeaderBase extends PyriteBase implements Byteable, PyriteModel
{
    use HexDecoder;
    use HexEncoder;

    /** @var int FILEHEADERLENGTH INT */
	public const FILEHEADERLENGTH = 206;
    /** @var int 0x00 Version SHORT */
	public int $Version;
    /** @var int 0x02 TimeLimit SHORT */
	public int $TimeLimit; // in minutes
    /** @var int 0x04 EndEvent SHORT */
	public int $EndEvent;
    /** @var int 0x06 Reserved SHORT */
	public const Reserved = 0;
    /** @var int 0x08 MissionLocation SHORT */
	public int $MissionLocation;
    /** @var array<string> 0x0A CompletionMessage STR */
	public array $CompletionMessage;
    /** @var int 0xCA NumFGs SHORT */
	public int $NumFGs;
    /** @var int 0xCC NumObj SHORT */
	public int $NumObj;
    
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

        $this->Version = $this->getShort($hex, 0x00);
        $this->TimeLimit = $this->getShort($hex, 0x02);
        $this->EndEvent = $this->getShort($hex, 0x04);
        // static SHORT value Reserved = 0
        $this->MissionLocation = $this->getShort($hex, 0x08);
        $this->CompletionMessage = [];
        $offset = 0x0A;
        for ($i = 0; $i < 3; $i++) {
            $t = $this->getString($hex, $offset);
            $this->CompletionMessage[] = $t;
            $offset += strlen($t);
        }
        $this->NumFGs = $this->getShort($hex, 0xCA);
        $this->NumObj = $this->getShort($hex, 0xCC);
        

        $this->hex = substr($this->hex, 0, $this->getLength());
        $this->afterLoadHex();
        return $this;
    }
    
    public function __debugInfo(): array
    {
        return [
            "Version" => $this->Version,
            "TimeLimit" => $this->TimeLimit,
            "EndEvent" => $this->getEndEventLabel(),
            "MissionLocation" => $this->getMissionLocationLabel(),
            "CompletionMessage" => $this->CompletionMessage,
            "NumFGs" => $this->NumFGs,
            "NumObj" => $this->NumObj
        ];
    }
    
    public function toHexString($hex = null): string
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $hex = $this->writeShort($this->Version, $hex, 0x00);
        $hex = $this->writeShort($this->TimeLimit, $hex, 0x02);
        $hex = $this->writeShort($this->EndEvent, $hex, 0x04);
        $hex = $this->writeShort(0, $hex, 0x06);
        $hex = $this->writeShort($this->MissionLocation, $hex, 0x08);
        $offset = 0x0A;
        for ($i = 0; $i < 3; $i++) {
            $t = $this->CompletionMessage[$i];
            $hex = $this->writeString($t, $hex, $offset);
            $offset += strlen($t);
        }
        $hex = $this->writeShort($this->NumFGs, $hex, 0xCA);
        $hex = $this->writeShort($this->NumObj, $hex, 0xCC);

        return $hex;
    }
    
    public function getEndEventLabel(): string 
    {
        return isset($this->EndEvent) && isset(Constants::$ENDEVENT[$this->EndEvent]) ? Constants::$ENDEVENT[$this->EndEvent] : "Unknown";
    }

    public function getMissionLocationLabel(): string 
    {
        return isset($this->MissionLocation) && isset(Constants::$MISSIONLOCATION[$this->MissionLocation]) ? Constants::$MISSIONLOCATION[$this->MissionLocation] : "Unknown";
    }
    
    public function getLength(): int
    {
        return self::FILEHEADERLENGTH;
    }
}