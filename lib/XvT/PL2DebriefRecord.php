<?php

namespace Pyrite\XvT;

class PL2DebriefRecord extends Base\PL2DebriefRecordBase
{

  public static function fromHex(string $hex, ?\Pyrite\PyriteModel $TIE = null): PL2DebriefRecord
  {
    return (new PL2DebriefRecord($hex, $TIE))->loadHex();
  }

  public function __toString(): string
  {
    return '';
  }
}
