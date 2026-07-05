<?php

namespace Pyrite\XvT;

class PLTTournamentProgressState extends Base\PLTTournamentProgressStateBase
{

  public static function fromHex(string $hex, ?\Pyrite\PyriteModel $TIE = NULL): PLTTournamentProgressState
  {
    return (new PLTTournamentProgressState($hex, $TIE))->loadHex();
  }

  public function __toString(): string
  {
    return '';
  }
}
