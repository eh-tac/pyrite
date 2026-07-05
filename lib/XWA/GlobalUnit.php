<?php

namespace Pyrite\XWA;

class GlobalUnit extends Base\GlobalUnitBase
{

  public static function fromHex(string $hex, ?\Pyrite\PyriteModel $TIE = NULL): GlobalUnit
  {
    return (new GlobalUnit($hex, $TIE))->loadHex();
  }

  public function __toString(): string
  {
    return '';
  }
}
