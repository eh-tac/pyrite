<?php

namespace Pyrite\XvT;

use Pyrite\Byteable;
use Pyrite\HexDecoder;

class Event implements Byteable
{
  use HexDecoder;

  const HEADER_LENGTH = 0;

  public $Time;
  public $Type;
  public $Variables;
  public function __construct($hex)
  {
    $this->Time = $this->getShort($hex, 0x0);
    $this->Type = $this->getShort($hex, 0x2);
    $this->Variables = $this->getShort($hex, 0x4);
  }

  public function getLength()
  {
    return self::HEADER_LENGTH;
  }
}
