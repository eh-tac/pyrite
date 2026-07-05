<?php

namespace Pyrite\XvT;

class Message extends Base\MessageBase
{

  public static function fromHex(string $hex, ?\Pyrite\PyriteModel $TIE = null): Message
  {
    return (new Message($hex, $TIE))->loadHex();
  }

  public function __toString(): string
  {
    return '';
  }
}
