<?php

namespace Pyrite\XW;

class MissionHeader extends Base\MissionHeaderBase
{

  public static function fromHex(string $hex, ?\Pyrite\PyriteModel $TIE = NULL): MissionHeader
  {
    return (new MissionHeader($hex, $TIE))->loadHex();
  }

  public function __toString(): string
  {
    return '';
  }
}
