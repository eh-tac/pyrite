<?php

namespace Pyrite\XvT;

class PLTTournTeamRecord extends Base\PLTTournTeamRecordBase
{

  public static function fromHex(string $hex, ?\Pyrite\PyriteModel $TIE = NULL): PLTTournTeamRecord
  {
    return (new PLTTournTeamRecord($hex, $TIE))->loadHex();
  }

  public function __toString(): string
  {
    return '';
  }
}
