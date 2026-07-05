<?php

namespace Pyrite\XWA;

class BrfStr extends Base\BrfStrBase
{

  public static function fromHex(string $hex, ?\Pyrite\PyriteModel $TIE = NULL): BrfStr
  {
    return (new BrfStr($hex, $TIE))->loadHex();
  }

  public function __toString(): string
  {
    return '';
  }
}
