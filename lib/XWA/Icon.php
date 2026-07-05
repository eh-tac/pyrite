<?php

namespace Pyrite\XWA;

class Icon extends Base\IconBase
{

  public static function fromHex(string $hex, ?\Pyrite\PyriteModel $TIE = NULL): Icon
  {
    return (new Icon($hex, $TIE))->loadHex();
  }

  public function __toString(): string
  {
    return '';
  }
}
