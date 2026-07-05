<?php

namespace Pyrite\XWA;

class Mission extends Base\MissionBase
{

  public static function fromHex(string $hex, ?\Pyrite\PyriteModel $TIE = NULL): Mission
  {
    return (new Mission($hex, $TIE))->loadHex();
  }

  public function __toString()
  {
    return '';
  }

  protected function FGGoalStringCount()
  {
    return 0;
  }

  public function valid()
  {
    return true;
  }
}
