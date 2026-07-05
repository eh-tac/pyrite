<?php

namespace Pyrite\XvT;

class TeamStats extends Base\TeamStatsBase
{

  public static function fromHex(string $hex, ?\Pyrite\PyriteModel $TIE = NULL): TeamStats
  {
    return (new TeamStats($hex, $TIE))->loadHex();
  }

  public function __toString()
  {
    return '';
  }
}
