<?php

namespace Pyrite\XW;

class Coordinate extends Base\CoordinateBase
{

  public static function fromHex(string $hex, ?\Pyrite\PyriteModel $TIE = NULL): Coordinate
  {
    return (new Coordinate($hex, $TIE))->loadHex();
  }

  public function __toString(): string
  {
    return '';
  }
}
