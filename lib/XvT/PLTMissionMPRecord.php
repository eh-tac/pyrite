<?php

namespace Pyrite\XvT;

class PLTMissionMPRecord extends Base\PLTMissionMPRecordBase
{

  public static function fromHex(string $hex, ?\Pyrite\PyriteModel $TIE = null): PLTMissionMPRecord
  {
    return (new PLTMissionMPRecord($hex, $TIE))->loadHex();
  }

  public function __toString(): string
  {
    return '';
  }
}
