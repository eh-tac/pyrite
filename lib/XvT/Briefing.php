<?php

namespace Pyrite\XvT;

use Pyrite\Byteable;
use Pyrite\HexDecoder;

class Briefing implements Byteable
{
  use HexDecoder;

  const HEADER_LENGTH = 0;

  public $RunningTime;
  public $Unknown1;
  public $StartEvents;
  public $EventsLength;
  public $Events;
  public $Tags;
  // public $;
  public function __construct($hex)
  {
    $this->RunningTime = $this->getShort($hex, 0x000);
    $this->Unknown1 = $this->getShort($hex, 0x002);
    $this->StartEvents = $this->getShort($hex, 0x004);
    $this->EventsLength = $this->getInt($hex, 0x006);
    $this->Events = new Event(substr($hex, 0x00A));
    $this->Tags = array();
    for ($i = 0; $i < 32; $i++) {
      $this->Tags[] = new Tag(substr($hex, 0x334 + $i));
    }

    // $this-> = new (substr($hex, String[32]));
  }

  public function getLength()
  {
    return self::HEADER_LENGTH;
  }
}
