<?php

namespace Pyrite\XW;

class Briefing extends Base\BriefingBase
{

  public static function fromHex(string $hex, ?\Pyrite\PyriteModel $TIE = NULL): Briefing
  {
    return (new Briefing($hex, $TIE))->loadHex();
  }

  public function __toString(): string
  {
    return '';
  }

  protected function CoordinateCount(): int
  {
    return 0;
  }
  protected function ViewportCount(): int
  {
    return 0;
  }
}
