<?php

namespace Pyrite\XvT;

class PLTBattleProgressState extends Base\PLTBattleProgressStateBase
{

  public static function fromHex(string $hex, ?\Pyrite\PyriteModel $TIE = null): PLTBattleProgressState
  {
    return (new PLTBattleProgressState($hex, $TIE))->loadHex();
  }

  public function __toString(): string
  {
    return '';
  }
}
