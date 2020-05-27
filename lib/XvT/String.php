<?php

namespace Pyrite\XvT;

use Pyrite\Byteable;
use Pyrite\HexDecoder;

class String implements Byteable
{
  use HexDecoder;

  const HEADER_LENGTH = 0;

  public $Length;
  public $String;
  public function __construct($hex)
  {
    $this->Length = $this->getShort($hex, 0x0);
    $this->String = $this->getChar($hex, 0x2);
  }

  public function getLength()
  {
    return self::HEADER_LENGTH;
  }
}
