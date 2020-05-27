<?php

namespace Pyrite\XvT;

use Pyrite\Byteable;
use Pyrite\HexDecoder;

class Role implements Byteable
{
  use HexDecoder;

  const HEADER_LENGTH = 0x4;

  public $Team;
  public $Designation;
  public function __construct($hex)
  {
    $this->Team = $this->getChar($hex, 0x0);
    $this->Designation = array();
    for ($i = 0; $i < 3; $i++) {
      $this->Designation[] = $this->getChar($hex, 0x1 + $i);
    }
  }

  public function getLength()
  {
    return self::HEADER_LENGTH;
  }
}
