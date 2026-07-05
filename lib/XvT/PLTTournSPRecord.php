<?php

namespace Pyrite\XvT;

class PLTTournSPRecord extends Base\PLTTournSPRecordBase
{

  public static function fromHex(string $hex, ?\Pyrite\PyriteModel $TIE = NULL): PLTTournSPRecord
  {
    return (new PLTTournSPRecord($hex, $TIE))->loadHex();
  }

  public function __toString(): string
  {
    return '';
  }
}
