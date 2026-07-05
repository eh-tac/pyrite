<?php

namespace Pyrite\XvT;

class PLTTournMPRecord extends Base\PLTTournMPRecordBase
{

  public static function fromHex(string $hex, ?\Pyrite\PyriteModel $TIE = NULL): PLTTournMPRecord
  {
    return (new PLTTournMPRecord($hex, $TIE))->loadHex();
  }

  public function __toString(): string
  {
    return '';
  }
}
