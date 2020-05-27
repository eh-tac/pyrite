<?php

namespace Pyrite\XvT;

use Pyrite\Byteable;
use Pyrite\HexDecoder;

class GlobalGoal implements Byteable
{
  use HexDecoder;

  const HEADER_LENGTH = 0x80;

  public $Reserved;
  public $Goals;
  public function __construct($hex)
  {
    $this->Reserved = $this->getShort($hex, 0x00);
    $this->Goals = array();
    for ($i = 0; $i < 3; $i++) {
      $this->Goals[] = new GoalGlobal(substr($hex, 0x02 + $i));
    }
  }

  public function getLength()
  {
    return self::HEADER_LENGTH;
  }
}
