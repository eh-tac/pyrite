<?php

namespace Pyrite\XvT;

class Event extends Base\EventBase
{

  public static function fromHex(string $hex, ?\Pyrite\PyriteModel $TIE = null): Event
  {
    return (new Event($hex, $TIE))->loadHex();
  }

  public function __toString(): string
  {
    return '';
  }
}
