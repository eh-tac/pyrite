<?php

namespace Pyrite\XWA\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\PyriteBase;

abstract class TagBase extends PyriteBase implements Byteable
{
    use HexDecoder;

    /** @var integer */
    public $TagLength;
    /** @var integer */
    public $Length;
    /** @var string[] */
    public $Unnamed;
    
    public function __construct($hex, $tie = null)
    {
        parent::__construct($hex, $tie);
        $this->beforeConstruct();
        $offset = 0;

        $this->Length = $this->getShort($hex, 0x0);
        $this->Unnamed = [];
        $offset = 0x2;
        for ($i = 0; $i < $this->Length; $i++) {
            $t = $this->getChar($hex, $offset, 1);
            $this->Unnamed[] = $t;
            $offset += 1;
        }
        $this->TagLength = $offset;
    }
    
    public function __debugInfo()
    {
        return [
            "Length" => $this->Length,
            "Unnamed" => $this->Unnamed
        ];
    }
    
    public function toHexString()
    {
        $hex = "";
        $offset = 0;

        $this->writeShort($hex, $this->Length, 0x0);
        $offset = 0x2;
        for ($i = 0; $i < $this->Length; $i++) {
            $t = $this->Unnamed[$i];
            $this->writeChar($hex, $t, $offset);
            $offset += 1;
        }

        return $hex;
    }
    
    
    public function getLength()
    {
        return $this->TagLength;
    }
}