<?php

namespace Pyrite\XWA;

class Message extends Base\MessageBase
{

  public static function fromHex(string $hex, ?\Pyrite\PyriteModel $TIE = NULL): Message
  {
    return (new Message($hex, $TIE))->loadHex();
  }

  public function __toString(): string
  {
    return '';
  }
}
