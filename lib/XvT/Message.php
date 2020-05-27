<?php

namespace Pyrite\XvT;

use Pyrite\Byteable;
use Pyrite\HexDecoder;

class Message implements Byteable
{
  use HexDecoder;

  const HEADER_LENGTH = 0;

  public $MessageIndex;
  public $Message;
  public $SentToTeams;
  public $TriggerA;
  public $Trigger1OrTrigger2;
  public $TriggerB;
  public $Trigger3OrTrigger4;
  public $EditorNote;
  public $DelaySeconds;
  public $Trigger12OrTrigger34;
  public function __construct($hex)
  {
    $this->MessageIndex = $this->getShort($hex, 0x00);
    $this->Message = array();
    for ($i = 0; $i < 64; $i++) {
      $this->Message[] = $this->getChar($hex, 0x02 + $i);
    }

    $this->SentToTeams = array();
    for ($i = 0; $i < 10; $i++) {
      $this->SentToTeams[] = $this->getByte($hex, 0x42 + $i);
    }

    $this->TriggerA = array();
    for ($i = 0; $i < 2; $i++) {
      $this->TriggerA[] = new Trigger(substr($hex, 0x4C + $i));
    }

    $this->Trigger1OrTrigger2 = $this->getBool($hex, 0x56);
    $this->TriggerB = array();
    for ($i = 0; $i < 2; $i++) {
      $this->TriggerB[] = new Trigger(substr($hex, 0x57 + $i));
    }

    $this->Trigger3OrTrigger4 = $this->getBool($hex, 0x61);
    $this->EditorNote = $this->getString($hex, 0x62, 16);
    $this->DelaySeconds = $this->getByte($hex, 0x72);
    $this->Trigger12OrTrigger34 = $this->getBool($hex, 0x73);
  }

  public function getLength()
  {
    return self::HEADER_LENGTH;
  }
}
