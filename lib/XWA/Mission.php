<?php

namespace Pyrite\XWA;

class Mission extends Base\MissionBase
{

  public static function fromHex($hex, $tie = null)
  {
    return (new Mission($hex, $tie))->loadHex();
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
