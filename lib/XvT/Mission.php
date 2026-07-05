<?php

namespace Pyrite\XvT;

use Pyrite\PyriteModel;

class Mission extends Base\MissionBase
{
  public static function fromHex(string $hex, ?PyriteModel $TIE = null): Mission
  {
    return (new Mission($hex, $TIE))->loadHex();
  }

  public function valid(): bool
  {
    return true;
  }

  public function __toString()
  {
    return '';
  }

  protected function FGGoalStringCount()
  {
    return 0;
  }
}
