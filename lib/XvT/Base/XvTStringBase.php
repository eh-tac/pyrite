<?php

namespace Pyrite\XvT\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;

abstract class XvTStringBase extends PyriteBase implements Byteable
{
    use HexDecoder;
    use HexEncoder;

    /** @var integer  XvTStringLength INT */
    public $XvTStringLength;
    /** @var integer 0x0 Length SHORT */
    public $Length;
    /** @var string 0x2 Text CHAR */
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
        $this->Text = $this->getChar($hex, 0x2, $this->Length);
        $offset = 0x2 + $this->Length;
        $this->XvTStringLength = $offset;

        $this->hex = substr($this->hex, 0, $this->getLength());
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

        $hex = $this->writeShort($this->Length, $hex, 0x0);
        $hex = $this->writeChar($this->Text, $hex, 0x2);

        return $hex;
    }
    
    
    public function getLength()
    {
        return $this->XvTStringLength;
    }
}