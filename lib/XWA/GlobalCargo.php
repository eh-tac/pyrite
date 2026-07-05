<?php

namespace Pyrite\XWA;

class GlobalCargo extends Base\GlobalCargoBase
{

  public static function fromHex(string $hex, ?\Pyrite\PyriteModel $TIE = NULL): GlobalCargo
  {
    return (new GlobalCargo($hex, $TIE))->loadHex();
  }

  public function __toString(): string
  {
    return '';
  }
}
