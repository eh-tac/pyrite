<?php

namespace Pyrite\XW\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;

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
    /** @var integer[] PV Highlight BYTE */
    public $Highlight;
    
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
        $this->Highlight = [];
        $offset = $offset;
        for ($i = 0; $i < $this->Length; $i++) {
            $t = $this->getByte($hex, $offset);
            $this->Highlight[] = $t;
            $offset += 1;
        }
        $this->StringLength = $offset;

        $this->hex = substr($this->hex, 0, $this->getLength());
        return $this;
    }
    
    public function __debugInfo()
    {
        return [
            "Length" => $this->Length,
            "String" => $this->String,
            "Highlight" => $this->Highlight
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
        $offset = $offset;
        for ($i = 0; $i < $this->Length; $i++) {
            $t = $this->Highlight[$i];
            $hex = $this->writeByte($t, $hex, $offset);
            $offset += 1;
        }

        return $hex;
    }
    
    
    public function getLength()
    {
        return $this->StringLength;
    }
}