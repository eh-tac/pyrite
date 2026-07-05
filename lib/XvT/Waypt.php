<?php

namespace Pyrite\XvT;

class Waypt extends Base\WayptBase
{

  public static function fromHex(string $hex, ?\Pyrite\PyriteModel $TIE = NULL): Waypt
  {
    return (new Waypt($hex, $TIE))->loadHex();
  }

  public function __toString(): string
  {
    return '';
  }
}
