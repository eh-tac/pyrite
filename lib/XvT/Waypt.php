<?php

namespace Pyrite\XvT;

use Pyrite\Byteable;
use Pyrite\HexDecoder;

class Waypt implements Byteable
{
  use HexDecoder;

  const HEADER_LENGTH = 0x2C;

  public $StartPoints;
  public $Waypoints;
  public $Rendezvous;
  public $Hyperspace;
  public $Briefings;
  public function __construct($hex)
  {
    $this->StartPoints = array();
    for ($i = 0; $i < 4; $i++) {
      $this->StartPoints[] = $this->getShort($hex, 0x00 + $i * 2);
    }

    $this->Waypoints = array();
    for ($i = 0; $i < 8; $i++) {
      $this->Waypoints[] = $this->getShort($hex, 0x08 + $i * 2);
    }

    $this->Rendezvous = $this->getShort($hex, 0x18);
    $this->Hyperspace = $this->getShort($hex, 0x1A);
    $this->Briefings = array();
    for ($i = 0; $i < 8; $i++) {
      $this->Briefings[] = $this->getShort($hex, 0x1C + $i * 2);
    }
  }

  public function getLength()
  {
    return self::HEADER_LENGTH;
  }
}
