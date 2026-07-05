<?php

namespace Pyrite\XvT;

class PLTEarnedMedalRecord extends Base\PLTEarnedMedalRecordBase
{

  public static function fromHex(string $hex, ?\Pyrite\PyriteModel $TIE = null): PLTEarnedMedalRecord
  {
    return (new PLTEarnedMedalRecord($hex, $TIE))->loadHex();
  }

  public function __toString(): string
  {
    return '';
  }
}
