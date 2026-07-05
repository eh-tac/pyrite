<?php

namespace Pyrite\XvT;

class PLTBattleMPRecord extends Base\PLTBattleMPRecordBase
{

  public static function fromHex(string $hex, ?\Pyrite\PyriteModel $TIE = null): PLTBattleMPRecord
  {
    return (new PLTBattleMPRecord($hex, $TIE))->loadHex();
  }

  public function __toString(): string
  {
    return '';
  }
}
