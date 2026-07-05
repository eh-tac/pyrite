<?php

namespace Pyrite\XvT;

class Briefing extends Base\BriefingBase
{

  public static function fromHex(string $hex, ?\Pyrite\PyriteModel $TIE = null): Briefing
  {
    return (new Briefing($hex, $TIE))->loadHex();
  }

  public function __toString(): string
  {
    return '';
  }
}
