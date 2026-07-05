<?php

namespace Pyrite\XWA;

class Region extends Base\RegionBase
{

  public static function fromHex(string $hex, ?\Pyrite\PyriteModel $TIE = NULL): Region
  {
    return (new Region($hex, $TIE))->loadHex();
  }

  public function __toString(): string
  {
    return '';
  }
}
