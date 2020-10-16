<?php

namespace Pyrite\TIE\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\PyriteBase;

abstract class TIEStringBase extends PyriteBase implements Byteable
{
    use HexDecoder;

    /** @var integer */
    public $TIEStringLength;
    /** @var integer */
    public $Length;
    /** @var string */
    public $Text;
    
    public function __construct($hex, $tie = null)
    {
        parent::__construct($hex, $tie);
        $this->beforeConstruct();
        $offset = 0;

        $this->Length = $this->getShort($hex, 0x0);
        $this->Text = $this->getChar($hex, 0x2, $this->Length);
        $offset = 0x2 + $this->Length;
        $this->TIEStringLength = $offset;
    }
    
    public function __debugInfo()
    {
        return [
            "Length" => $this->Length,
            "Text" => $this->Text
        ];
    }
    
    public function toHexString()
    {
        $hex = "";
        $offset = 0;

        $this->writeShort($hex, $this->Length, 0x0);
        $this->writeChar($hex, $this->Text, 0x2);

        return $hex;
    }
    
    
    public function getLength()
    {
        return $this->TIEStringLength;
    }
}