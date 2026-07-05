<?php

namespace Pyrite\XvT;

class XvTString extends Base\XvTStringBase
{

  public static function fromHex(string $hex, ?\Pyrite\PyriteModel $TIE = NULL): XvTString
  {
    return (new XvTString($hex, $TIE))->loadHex();
  }

  public function __toString(): string
  {
    return '';
  }
}
