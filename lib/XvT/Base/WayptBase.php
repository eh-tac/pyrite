<?php

namespace Pyrite\XvT\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;
use Pyrite\PyriteModel;

abstract class WayptBase extends PyriteBase implements Byteable, PyriteModel
{
    use HexDecoder;
    use HexEncoder;

    /** @var int WAYPTLENGTH INT */
	public const WAYPTLENGTH = 44;
    /** @var array<int> 0x00 StartPoints SHORT */
	public array $StartPoints;
    /** @var array<int> 0x08 Waypoints SHORT */
	public array $Waypoints;
    /** @var int 0x18 Rendezvous SHORT */
	public int $Rendezvous;
    /** @var int 0x1A Hyperspace SHORT */
	public int $Hyperspace;
    /** @var array<int> 0x1C Briefings SHORT */
	public array $Briefings;
    
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

        $this->StartPoints = [];
        $offset = 0x00;
        for ($i = 0; $i < 4; $i++) {
            $t = $this->getShort($hex, $offset);
            $this->StartPoints[] = $t;
            $offset += 2;
        }
        $this->Waypoints = [];
        $offset = 0x08;
        for ($i = 0; $i < 8; $i++) {
            $t = $this->getShort($hex, $offset);
            $this->Waypoints[] = $t;
            $offset += 2;
        }
        $this->Rendezvous = $this->getShort($hex, 0x18);
        $this->Hyperspace = $this->getShort($hex, 0x1A);
        $this->Briefings = [];
        $offset = 0x1C;
        for ($i = 0; $i < 8; $i++) {
            $t = $this->getShort($hex, $offset);
            $this->Briefings[] = $t;
            $offset += 2;
        }
        

        $this->hex = substr($this->hex, 0, $this->getLength());
        $this->afterLoadHex();
        return $this;
    }
    
    public function __debugInfo(): array
    {
        return [
            "StartPoints" => $this->StartPoints,
            "Waypoints" => $this->Waypoints,
            "Rendezvous" => $this->Rendezvous,
            "Hyperspace" => $this->Hyperspace,
            "Briefings" => $this->Briefings
        ];
    }
    
    public function toHexString($hex = null): string
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $offset = 0x00;
        for ($i = 0; $i < 4; $i++) {
            $t = $this->StartPoints[$i];
            $hex = $this->writeShort($t, $hex, $offset);
            $offset += 2;
        }
        $offset = 0x08;
        for ($i = 0; $i < 8; $i++) {
            $t = $this->Waypoints[$i];
            $hex = $this->writeShort($t, $hex, $offset);
            $offset += 2;
        }
        $hex = $this->writeShort($this->Rendezvous, $hex, 0x18);
        $hex = $this->writeShort($this->Hyperspace, $hex, 0x1A);
        $offset = 0x1C;
        for ($i = 0; $i < 8; $i++) {
            $t = $this->Briefings[$i];
            $hex = $this->writeShort($t, $hex, $offset);
            $offset += 2;
        }

        return $hex;
    }
    
    
    public function getLength(): int
    {
        return self::WAYPTLENGTH;
    }
}