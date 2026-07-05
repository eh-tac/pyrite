<?php

namespace Pyrite\XvT\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;
use Pyrite\PyriteModel;

abstract class PLTAIRankCountRecordBase extends PyriteBase implements Byteable, PyriteModel
{
    use HexDecoder;
    use HexEncoder;

    /** @var int PLTAIRANKCOUNTRECORDLENGTH INT */
	public const PLTAIRANKCOUNTRECORDLENGTH = 72;
    /** @var array<int> 0x0000 exercise INT */
	public array $exercise;
    /** @var array<int> 0x0018 melee INT */
	public array $melee;
    /** @var array<int> 0x0030 combat INT */
	public array $combat;
    
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

        $this->exercise = [];
        $offset = 0x0000;
        for ($i = 0; $i < 6; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->exercise[] = $t;
            $offset += 4;
        }
        $this->melee = [];
        $offset = 0x0018;
        for ($i = 0; $i < 6; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->melee[] = $t;
            $offset += 4;
        }
        $this->combat = [];
        $offset = 0x0030;
        for ($i = 0; $i < 6; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->combat[] = $t;
            $offset += 4;
        }
        

        $this->hex = substr($this->hex, 0, $this->getLength());
        return $this;
    }
    
    public function __debugInfo(): array
    {
        return [
            "exercise" => $this->exercise,
            "melee" => $this->melee,
            "combat" => $this->combat
        ];
    }
    
    public function toHexString($hex = null): string
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $offset = 0x0000;
        for ($i = 0; $i < 6; $i++) {
            $t = $this->exercise[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $offset = 0x0018;
        for ($i = 0; $i < 6; $i++) {
            $t = $this->melee[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $offset = 0x0030;
        for ($i = 0; $i < 6; $i++) {
            $t = $this->combat[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }

        return $hex;
    }
    
    
    public function getLength(): int
    {
        return self::PLTAIRANKCOUNTRECORDLENGTH;
    }
}