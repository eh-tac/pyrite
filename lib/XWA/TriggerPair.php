<?php

namespace Pyrite\XWA;

class TriggerPair extends Base\TriggerPairBase
{

  public static function fromHex(string $hex, ?\Pyrite\PyriteModel $TIE = NULL): TriggerPair
  {
    return (new TriggerPair($hex, $TIE))->loadHex();
  }

  public function __toString(): string
  {
    return '';
  }
}
