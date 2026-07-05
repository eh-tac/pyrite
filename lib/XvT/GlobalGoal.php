<?php

namespace Pyrite\XvT;

class GlobalGoal extends Base\GlobalGoalBase
{

  public static function fromHex(string $hex, ?\Pyrite\PyriteModel $TIE = null): GlobalGoal
  {
    return (new GlobalGoal($hex, $TIE))->loadHex();
  }

  public function __toString(): string
  {
    return '';
  }
}
