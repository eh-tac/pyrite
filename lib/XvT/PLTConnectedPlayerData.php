<?php

namespace Pyrite\XvT;

class PLTConnectedPlayerData extends Base\PLTConnectedPlayerDataBase
{

  public static function fromHex(string $hex, ?\Pyrite\PyriteModel $TIE = null): PLTConnectedPlayerData
  {
    return (new PLTConnectedPlayerData($hex, $TIE))->loadHex();
  }

  public function __toString(): string
  {
    return '';
  }
}
