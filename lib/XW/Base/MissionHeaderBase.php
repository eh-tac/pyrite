<?php

namespace Pyrite\XW\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;
use Pyrite\PyriteModel;
use Pyrite\XW\Constants;

abstract class MissionHeaderBase extends PyriteBase implements Byteable, PyriteModel
{
    use HexDecoder;
    use HexEncoder;

    /** @var int MISSIONHEADERLENGTH INT */
	public const MISSIONHEADERLENGTH = 200;
    /** @var int 0x00 TimeLimitMinutes SHORT */
	public int $TimeLimitMinutes;
    /** @var int 0x02 EndEvent SHORT */
	public int $EndEvent;
    /** @var int 0x04 RndSeed SHORT */
	public int $RndSeed; // (unused)
    /** @var int 0x06 MissionLocation SHORT */
	public int $MissionLocation;
    /** @var array<string> 0x08 EndOfMissionMessages CHAR */
	public array $EndOfMissionMessages;
    
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

        $this->TimeLimitMinutes = $this->getShort($hex, 0x00);
        $this->EndEvent = $this->getShort($hex, 0x02);
        $this->RndSeed = $this->getShort($hex, 0x04);
        $this->MissionLocation = $this->getShort($hex, 0x06);
        $this->EndOfMissionMessages = [];
        $offset = 0x08;
        for ($i = 0; $i < 3; $i++) {
            $t = $this->getChar($hex, $offset, 16);
            $this->EndOfMissionMessages[] = $t;
            $offset += 16;
        }
        

        $this->hex = substr($this->hex, 0, $this->getLength());
        $this->afterLoadHex();
        return $this;
    }
    
    public function __debugInfo(): array
    {
        return [
            "TimeLimitMinutes" => $this->TimeLimitMinutes,
            "EndEvent" => $this->getEndEventLabel(),
            "RndSeed" => $this->RndSeed,
            "MissionLocation" => $this->getMissionLocationLabel(),
            "EndOfMissionMessages" => $this->EndOfMissionMessages
        ];
    }
    
    public function toHexString($hex = null): string
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $hex = $this->writeShort($this->TimeLimitMinutes, $hex, 0x00);
        $hex = $this->writeShort($this->EndEvent, $hex, 0x02);
        $hex = $this->writeShort($this->RndSeed, $hex, 0x04);
        $hex = $this->writeShort($this->MissionLocation, $hex, 0x06);
        $offset = 0x08;
        for ($i = 0; $i < 3; $i++) {
            $t = $this->EndOfMissionMessages[$i];
            $hex = $this->writeChar($t, $hex, $offset);
            $offset += 16;
        }

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
        return self::MISSIONHEADERLENGTH;
    }
}