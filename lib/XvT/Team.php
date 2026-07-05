<?php

namespace Pyrite\XvT;

class Team extends Base\TeamBase
{

  public static function fromHex(string $hex, ?\Pyrite\PyriteModel $TIE = NULL): Team
  {
    return (new Team($hex, $TIE))->loadHex();
  }

  public function __toString(): string
  {
    return '';
  }
}
