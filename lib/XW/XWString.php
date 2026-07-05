<?php

namespace Pyrite\XW;

use Pyrite\PyriteModel;

class XWString extends Base\XWStringBase
{

  public static function fromHex(string $hex, ?PyriteModel $TIE = null): XWString
  {
    return (new XWString($hex, $TIE))->loadHex();
  }

  public function __toString(): string
  {
    return '';
  }
}
