<?php

namespace Pyrite\XvT;

use Pyrite\Byteable;
use Pyrite\HexDecoder;

class Trigger implements Byteable
{
  use HexDecoder;

  const HEADER_LENGTH = 0x4;

  public $Condition;
  public $VariableType;
  public $Variable;
  public $Amount;
  public function __construct($hex)
  {
    $this->Condition = $this->getByte($hex, 0x0);
    $this->VariableType = $this->getByte($hex, 0x1);
    $this->Variable = $this->getByte($hex, 0x2);
    $this->Amount = $this->getByte($hex, 0x3);
  }

  public function getLength()
  {
    return self::HEADER_LENGTH;
  }
}
