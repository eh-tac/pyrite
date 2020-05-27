<?php

namespace Pyrite\XvT;

use Pyrite\Byteable;
use Pyrite\HexDecoder;

class Tag implements Byteable
{
  use HexDecoder;

  const HEADER_LENGTH = 0;

  public $Length;
  public $Tag;
  public function __construct($hex)
  {
    $this->Length = $this->getShort($hex, 0x0);
    $this->Tag = $this->getChar($hex, 0x2);
  }

  public function getLength()
  {
    return self::HEADER_LENGTH;
  }
}
