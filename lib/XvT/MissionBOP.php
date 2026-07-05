<?php

namespace Pyrite\XvT;

class MissionBOP extends Base\MissionBOPBase
{

  public static function fromHex(string $hex, ?\Pyrite\PyriteModel $TIE = null): MissionBOP
  {
    return (new MissionBOP($hex, $TIE))->loadHex();
  }

  public function __toString(): string
  {
    return '';
  }

  protected function FGGoalStringCount(): int
  {
    return 0;
  }
}
