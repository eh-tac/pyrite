<?php

namespace Pyrite\XvT;

use Pyrite\Byteable;
use Pyrite\HexDecoder;

class FileHeader implements Byteable
{
  use HexDecoder;

  const FILEHEADER_LENGTH = 0xA4;

  public $PlatformID;
  public $NumFGs;
  public $NumMessages;
  public $Unknown1;
  public $Unknown2;
  public $Unknown3;
  public $Unknown4;
  public $Unknown5;
  public $MissionType;
  public $Unknown6;
  public $TimeLimitMinutes;
  public $TimeLimitSeconds;
  public function __construct($hex)
  {
    $this->PlatformID = $this->getShort($hex, 0x00);
    $this->NumFGs = $this->getShort($hex, 0x02);
    $this->NumMessages = $this->getShort($hex, 0x04);
    $this->Unknown1 = $this->getByte($hex, 0x06);
    $this->Unknown2 = $this->getByte($hex, 0x08);
    $this->Unknown3 = $this->getBool($hex, 0x0B);
    $this->Unknown4 = array();
    for ($i = 0; $i < 16; $i++) {
      $this->Unknown4[] = $this->getChar($hex, 0x28 + $i);
    }

    $this->Unknown5 = array();
    for ($i = 0; $i < 16; $i++) {
      $this->Unknown5[] = $this->getChar($hex, 0x50 + $i);
    }

    $this->MissionType = $this->getByte($hex, 0x64);
    $this->Unknown6 = $this->getBool($hex, 0x65);
    $this->TimeLimitMinutes = $this->getByte($hex, 0x66);
    $this->TimeLimitSeconds = $this->getByte($hex, 0x67);
  }

  public function getLength()
  {
    return self::FILEHEADER_LENGTH;
  }
}
