<?php

namespace Pyrite\XvT;

class PLTTeamResultRecord extends Base\PLTTeamResultRecordBase
{

  public static function fromHex(string $hex, ?\Pyrite\PyriteModel $TIE = NULL): PLTTeamResultRecord
  {
    return (new PLTTeamResultRecord($hex, $TIE))->loadHex();
  }

  public function __toString(): string
  {
    return '';
  }
}
