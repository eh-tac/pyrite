<?php

namespace Pyrite\XW\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;
use Pyrite\XW\Highlight;

abstract class StringBase extends PyriteBase implements Byteable
{
    use HexDecoder;
    use HexEncoder;

    /** @var integer  StringLength INT */
    public $StringLength;
    /** @var integer 0x0 Length SHORT */
    public $Length;
    /** @var string[] 0x2 String CHAR */
    public $String;
    /** @var Highlight BYTE[Length] Unnamed Highlight */
    public $Unnamed;
    
    public function __construct($hex = null, $tie = null)
    {
        parent::__construct($hex, $tie);
    }

    /**
     * Process the $hex string provided in the constructor.
     * Separating the constructor and loading allows for the objects to be made from scratch.
     * @return $this 
     */
    public function loadHex()
    {
        $hex = $this->hex;
        $offset = 0;

        $this->Length = $this->getShort($hex, 0x0);
        $this->String = [];
        $offset = 0x2;
        for ($i = 0; $i < $this->Length; $i++) {
            $t = $this->getChar($hex, $offset, 1);
            $this->String[] = $t;
            $offset += 1;
        }
        $this->Unnamed = (new Highlight(substr($hex, BYTE[Length]), $this->TIE))->loadHex();
        $offset = BYTE[Length] + $this->Unnamed->getLength();
        $this->StringLength = $offset;

        $this->hex = substr($this->hex, 0, $this->getLength());
        return $this;
    }
    
    public function __debugInfo()
    {
        return [
            "Length" => $this->Length,
            "String" => $this->String,
            "Unnamed" => $this->Unnamed
        ];
    }
    
    public function toHexString($hex = null)
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $hex = $this->writeShort($this->Length, $hex, 0x0);
        $offset = 0x2;
        for ($i = 0; $i < $this->Length; $i++) {
            $t = $this->String[$i];
            $hex = $this->writeChar($t, $hex, $offset);
            $offset += 1;
        }
        $hex = $this->writeObject($this->Unnamed, $hex, BYTE[Length]);

        return $hex;
    }
    
    
    public function getLength()
    {
        return $this->StringLength;
    }
}