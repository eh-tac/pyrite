<?php

namespace Pyrite\XvT\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;
use Pyrite\PyriteModel;

abstract class RoleBase extends PyriteBase implements Byteable, PyriteModel
{
    use HexDecoder;
    use HexEncoder;

    /** @var int ROLELENGTH INT */
	public const ROLELENGTH = 4;
    /** @var string 0x0 Team CHAR */
	public string $Team;
    /** @var string 0x1 Designation CHAR */
	public string $Designation;
    
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

        $this->Team = $this->getChar($hex, 0x0, 1);
        $this->Designation = $this->getChar($hex, 0x1, 3);
        

        $this->hex = substr($this->hex, 0, $this->getLength());
        $this->afterLoadHex();
        return $this;
    }
    
    public function __debugInfo(): array
    {
        return [
            "Team" => $this->Team,
            "Designation" => $this->Designation
        ];
    }
    
    public function toHexString($hex = null): string
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $hex = $this->writeChar($this->Team, $hex, 0x0);
        $hex = $this->writeChar($this->Designation, $hex, 0x1);

        return $hex;
    }
    
    
    public function getLength(): int
    {
        return self::ROLELENGTH;
    }
}