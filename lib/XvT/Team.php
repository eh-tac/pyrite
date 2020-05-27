<?php

namespace Pyrite\XvT;

use Pyrite\Byteable;
use Pyrite\HexDecoder;

class Team implements Byteable
{
  use HexDecoder;

  const HEADER_LENGTH = 0x1E7;

  public $Reserved;
  public $Name;
  public $Allegiances;
  public $EndOfMissionMessages;
  public function __construct($hex)
  {
    $this->Reserved = $this->getShort($hex, 0x000);
    $this->Name = $this->getString($hex, 0x002, 16);
    $this->Allegiances = array();
    for ($i = 0; $i < 10; $i++) {
      $this->Allegiances[] = $this->getBool($hex, 0x01A + $i);
    }

    $this->EndOfMissionMessages = array();
    for ($i = 0; $i < 64; $i++) {
      $this->EndOfMissionMessages[] = $this->getChar($hex, 0x024 + $i);
    }
  }

  public function getLength()
  {
    return self::HEADER_LENGTH;
  }
}
