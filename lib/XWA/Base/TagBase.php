<?php

namespace Pyrite\XWA\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;

abstract class TagBase extends PyriteBase implements Byteable
{
    use HexDecoder;
    use HexEncoder;

    /** @var integer  TagLength INT */
    public $TagLength;
    /** @var integer 0x0 Length SHORT */
    public $Length;
    /** @var string[] 0x2 Text CHAR */
    public $Text;
    
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
        $this->Text = [];
        $offset = 0x2;
        for ($i = 0; $i < $this->Length; $i++) {
            $t = $this->getChar($hex, $offset, 1);
            $this->Text[] = $t;
            $offset += 1;
        }
        $offset += 1;
        $this->TagLength = $offset;
        return $this;
    }
    
    public function __debugInfo()
    {
        return [
            "Length" => $this->Length,
            "Text" => $this->Text
        ];
    }
    
    public function toHexString($hex = null)
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        [$hex, $offset] = $this->writeShort($this->Length, $hex, 0x0);
        $offset = 0x2;
        for ($i = 0; $i < $this->Length; $i++) {
            $t = $this->Text[$i];
            [$hex, $offset] = $this->writeChar($t, $hex, $offset);
        }

        return $hex;
    }
    
    
    public function getLength()
    {
        return $this->TagLength;
    }
}