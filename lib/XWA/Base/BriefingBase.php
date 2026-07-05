<?php

namespace Pyrite\XWA\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;
use Pyrite\PyriteModel;
use Pyrite\XWA\BrfStr;
use Pyrite\XWA\Event;
use Pyrite\XWA\Icon;

abstract class BriefingBase extends PyriteBase implements Byteable, PyriteModel
{
    use HexDecoder;
    use HexEncoder;

    /** @var int BriefingLength INT */
	public int $BriefingLength;
    /** @var int 0x0000 RunningTime SHORT */
	public int $RunningTime;
    /** @var int 0x0002 CurrentTime SHORT */
	public int $CurrentTime; // (was Unknown1)
    /** @var int 0x0004 StartLength SHORT */
	public int $StartLength;
    /** @var int 0x0006 EventsLength SHORT */
	public int $EventsLength;
    /** @var int 0x0008 Tile SHORT */
	public int $Tile;
    /** @var array<Event> 0x000A Events Event */
	public array $Events;
    /** @var array<Icon> 0x320A Icons Icon */
	public array $Icons;
    /** @var array<bool> 0x440A ViewedByTeam BOOL */
	public array $ViewedByTeam;
    /** @var array<BrfStr> 0x4414 Tags BrfStr */
	public array $Tags;
    /** @var array<BrfStr> PV Strings BrfStr */
	public array $Strings;
    
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

        $this->RunningTime = $this->getShort($hex, 0x0000);
        $this->CurrentTime = $this->getShort($hex, 0x0002);
        $this->StartLength = $this->getShort($hex, 0x0004);
        $this->EventsLength = $this->getShort($hex, 0x0006);
        $this->Tile = $this->getShort($hex, 0x0008);
        $this->Events = [];
        $offset = 0x000A;
		// @phpstan-ignore smaller.alwaysFalse
        for ($i = 0; $i < 0; $i++) {
            $t = (new Event(substr($hex, $offset), $this->TIE))->loadHex();
            $this->Events[] = $t;
            $offset += $t->getLength();
        }
        $this->Icons = [];
        $offset = 0x320A;
        for ($i = 0; $i < 192; $i++) {
            $t = (new Icon(substr($hex, $offset), $this->TIE))->loadHex();
            $this->Icons[] = $t;
            $offset += $t->getLength();
        }
        $this->ViewedByTeam = [];
        $offset = 0x440A;
        for ($i = 0; $i < 10; $i++) {
            $t = $this->getBool($hex, $offset);
            $this->ViewedByTeam[] = $t;
            $offset += 1;
        }
        $this->Tags = [];
        $offset = 0x4414;
        for ($i = 0; $i < 128; $i++) {
            $t = (new BrfStr(substr($hex, $offset), $this->TIE))->loadHex();
            $this->Tags[] = $t;
            $offset += $t->getLength();
        }
        $this->Strings = [];
        $offset = $offset;
        for ($i = 0; $i < 128; $i++) {
            $t = (new BrfStr(substr($hex, $offset), $this->TIE))->loadHex();
            $this->Strings[] = $t;
            $offset += $t->getLength();
        }
        $this->BriefingLength = $offset;

        $this->hex = substr($this->hex, 0, $this->getLength());
        return $this;
    }
    
    public function __debugInfo(): array
    {
        return [
            "RunningTime" => $this->RunningTime,
            "CurrentTime" => $this->CurrentTime,
            "StartLength" => $this->StartLength,
            "EventsLength" => $this->EventsLength,
            "Tile" => $this->Tile,
            "Events" => $this->Events,
            "Icons" => $this->Icons,
            "ViewedByTeam" => $this->ViewedByTeam,
            "Tags" => $this->Tags,
            "Strings" => $this->Strings
        ];
    }
    
    public function toHexString($hex = null): string
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $hex = $this->writeShort($this->RunningTime, $hex, 0x0000);
        $hex = $this->writeShort($this->CurrentTime, $hex, 0x0002);
        $hex = $this->writeShort($this->StartLength, $hex, 0x0004);
        $hex = $this->writeShort($this->EventsLength, $hex, 0x0006);
        $hex = $this->writeShort($this->Tile, $hex, 0x0008);
        $offset = 0x000A;
		// @phpstan-ignore smaller.alwaysFalse
        for ($i = 0; $i < 0; $i++) {
            $t = $this->Events[$i];
            $hex = $this->writeObject($t, $hex, $offset);
            $offset += $t->getLength();
        }
        $offset = 0x320A;
        for ($i = 0; $i < 192; $i++) {
            $t = $this->Icons[$i];
            $hex = $this->writeObject($t, $hex, $offset);
            $offset += $t->getLength();
        }
        $offset = 0x440A;
        for ($i = 0; $i < 10; $i++) {
            $t = $this->ViewedByTeam[$i];
            $hex = $this->writeBool($t, $hex, $offset);
            $offset += 1;
        }
        $offset = 0x4414;
        for ($i = 0; $i < 128; $i++) {
            $t = $this->Tags[$i];
            $hex = $this->writeObject($t, $hex, $offset);
            $offset += $t->getLength();
        }
        $offset = $offset;
        for ($i = 0; $i < 128; $i++) {
            $t = $this->Strings[$i];
            $hex = $this->writeObject($t, $hex, $offset);
            $offset += $t->getLength();
        }

        return $hex;
    }
    
    
    public function getLength(): int
    {
        return $this->BriefingLength;
    }
}