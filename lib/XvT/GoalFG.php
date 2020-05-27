<?php

namespace Pyrite\XvT;

use Pyrite\Byteable;
use Pyrite\HexDecoder;

class GoalFG implements Byteable
{
  use HexDecoder;

  const HEADER_LENGTH = 0x4E;

  public $Argument;
  public $Condition;
  public $Amount;
  public $Points;
  public $Enabled;
  public $Team;
  public $Unknown10;
  public $Unknown11;
  public $Unknown12;
  public $Unknown13;
  public $Unknown14;
  public $Unknown15;
  public $Unknown16;
  public function __construct($hex)
  {
    $this->Argument = $this->getByte($hex, 0x00);
    $this->Condition = $this->getByte($hex, 0x01);
    $this->Amount = $this->getByte($hex, 0x02);
    $this->Points = $this->getSByte($hex, 0x03);
    $this->Enabled = $this->getBool($hex, 0x04);
    $this->Team = $this->getByte($hex, 0x05);
    $this->Unknown10 = $this->getBool($hex, 0x06);
    $this->Unknown11 = $this->getBool($hex, 0x07);
    $this->Unknown12 = $this->getBool($hex, 0x08);
    $this->Unknown13 = $this->getByte($hex, 0x0B);
    $this->Unknown14 = $this->getBool($hex, 0x0C);
    $this->Unknown15 = $this->getByte($hex, 0x0D);
    $this->Unknown16 = $this->getByte($hex, 0x0E);
  }

  public function getLength()
  {
    return self::HEADER_LENGTH;
  }
}
