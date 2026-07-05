<?php

namespace Pyrite\XvT;

class PLTBattleSPRecord extends Base\PLTBattleSPRecordBase
{

  public static function fromHex(string $hex, ?\Pyrite\PyriteModel $TIE = null): PLTBattleSPRecord
  {
    return (new PLTBattleSPRecord($hex, $TIE))->loadHex();
  }

  public function __toString(): string
  {
    return '';
  }
}
