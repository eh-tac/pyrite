<?php

namespace Pyrite\XvT;

class TeamStats extends Base\TeamStatsBase
{

  public static function fromHex($hex, $tie = null)
  {
    return (new TeamStats($hex, $tie))->loadHex();
  }

  public function __toString()
  {
    return '';
  }
}
