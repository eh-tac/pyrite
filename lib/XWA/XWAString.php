<?php

namespace Pyrite\XWA;

class XWAString extends Base\XWAStringBase
{

  public static function fromHex(string $hex, ?\Pyrite\PyriteModel $TIE = NULL): XWAString
  {
    return (new XWAString($hex, $TIE))->loadHex();
  }

  public function __toString(): string
  {
    return '';
  }
}
