<?php

namespace Pyrite\XvT;

class PLTBattleState extends Base\PLTBattleStateBase
{

  public static function fromHex(string $hex, ?\Pyrite\PyriteModel $TIE = null): PLTBattleState
  {
    return (new PLTBattleState($hex, $TIE))->loadHex();
  }

  public function __toString(): string
  {
    return '';
  }
}
