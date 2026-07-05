<?php

namespace Pyrite\XvT\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;
use Pyrite\PyriteModel;
use Pyrite\XvT\Constants;

abstract class EventBase extends PyriteBase implements Byteable, PyriteModel
{
    use HexDecoder;
    use HexEncoder;

    /** @var int EventLength INT */
	public int $EventLength;
    /** @var int 0x0 Time SHORT */
	public int $Time;
    /** @var int 0x2 Type SHORT */
	public int $Type;
    /** @var int 0x4 Variables SHORT */
	public int $Variables;
    
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

        $this->Time = $this->getShort($hex, 0x0);
        $this->Type = $this->getShort($hex, 0x2);
        $this->Variables = $this->getShort($hex, 0x4);
        $this->EventLength = $offset;

        $this->hex = substr($this->hex, 0, $this->getLength());
        return $this;
    }
    
    public function __debugInfo(): array
    {
        return [
            "Time" => $this->Time,
            "Type" => $this->getTypeLabel(),
            "Variables" => $this->Variables
        ];
    }
    
    public function toHexString($hex = null): string
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $hex = $this->writeShort($this->Time, $hex, 0x0);
        $hex = $this->writeShort($this->Type, $hex, 0x2);
        $hex = $this->writeShort($this->Variables, $hex, 0x4);

        return $hex;
    }
    
    public function getTypeLabel(): string 
    {
        return isset($this->Type) && isset(Constants::$EVENTTYPE[$this->Type]) ? Constants::$EVENTTYPE[$this->Type] : "Unknown";
    }
    
    public function getLength(): int
    {
        return $this->EventLength;
    }
}