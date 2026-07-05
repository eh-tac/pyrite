<?php

namespace Pyrite\XWA;

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
}
