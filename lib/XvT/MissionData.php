<?php

namespace Pyrite\XvT;

class MissionData extends Base\MissionDataBase
{

  public static function fromHex(string $hex, ?\Pyrite\PyriteModel $TIE = null): MissionData
  {
    return (new MissionData($hex, $TIE))->loadHex();
  }

  public function __toString(): string
  {
    return '';
  }
}
