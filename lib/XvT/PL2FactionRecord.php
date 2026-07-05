<?php

namespace Pyrite\XvT;

class PL2FactionRecord extends Base\PL2FactionRecordBase
{

  public static function fromHex(string $hex, ?\Pyrite\PyriteModel $TIE = null): PL2FactionRecord
  {
    return (new PL2FactionRecord($hex, $TIE))->loadHex();
  }

  public function __toString(): string
  {
    return '';
  }
}
