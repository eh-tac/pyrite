<?php

namespace Pyrite\XvT;

class PLTMissionSPRecord extends Base\PLTMissionSPRecordBase
{

  public static function fromHex(string $hex, ?\Pyrite\PyriteModel $TIE = NULL): PLTMissionSPRecord
  {
    return (new PLTMissionSPRecord($hex, $TIE))->loadHex();
  }

  public function __toString(): string
  {
    return '';
  }
}
