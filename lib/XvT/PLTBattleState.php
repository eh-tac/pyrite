<?php

namespace Pyrite\XvT;

use PHPUnit\Framework\Constraint\StringContains;

class PLTBattleState extends Base\PLTBattleStateBase
{

  public static function fromHex(string $hex, ?\Pyrite\PyriteModel $TIE = null): PLTBattleState
  {
    return (new PLTBattleState($hex, $TIE))->loadHex();
  }

  public function __toString(): StringContains
  {
    return '';
  }
}
