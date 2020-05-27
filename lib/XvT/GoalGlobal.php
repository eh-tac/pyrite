<?php

namespace Pyrite\XvT;

use Pyrite\Byteable;
use Pyrite\HexDecoder;

class GoalGlobal implements Byteable
{
  use HexDecoder;

  const HEADER_LENGTH = 0x2A;

  public $TriggerA;
  public $Trigger1OrTrigger2;
  public $TriggerB;
  public $Trigger2OrTrigger3;
  public $Trigger12OrTrigger34;
  public $Points;
  public function __construct($hex)
  {
    $this->TriggerA = array();
    for ($i = 0; $i < 2; $i++) {
      $this->TriggerA[] = new Trigger(substr($hex, 0x00 + $i));
    }

    $this->Trigger1OrTrigger2 = $this->getBool($hex, 0x0A);
    $this->TriggerB = array();
    for ($i = 0; $i < 2; $i++) {
      $this->TriggerB[] = new Trigger(substr($hex, 0x0B + $i));
    }

    $this->Trigger2OrTrigger3 = $this->getBool($hex, 0x15);
    $this->Trigger12OrTrigger34 = $this->getBool($hex, 0x27);
    $this->Points = $this->getSByte($hex, 0x29);
  }

  public function getLength()
  {
    return self::HEADER_LENGTH;
  }
}
