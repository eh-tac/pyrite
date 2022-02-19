<?php

namespace Pyrite\XWA\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\PyriteBase;

abstract class XWAStringBase extends PyriteBase implements Byteable
{
    use HexDecoder;

    /** @var integer */
    public $XWAStringLength;
    /** @var integer */
    public $Magic;
    
    public function __construct($hex, $tie = null)
    {
        parent::__construct($hex, $tie);
        $this->beforeConstruct();
        $offset = 0;

        $this->Magic = $this->getByte($hex, 0x0);
        $this->XWAStringLength = $offset;
    }
    
    public function __debugInfo()
    {
        return [
            "Magic" => $this->Magic
        ];
    }
    
    public function toHexString()
    {
        $hex = "";
        $offset = 0;

        $this->writeByte($hex, $this->Magic, 0x0);

        return $hex;
    }
    
    
    public function getLength()
    {
        return $this->XWAStringLength;
    }
}