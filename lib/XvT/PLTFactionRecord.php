<?php

namespace Pyrite\XvT;

class PLTFactionRecord extends Base\PLTFactionRecordBase
{

  public static function fromHex(string $hex, ?\Pyrite\PyriteModel $TIE = null): PLTFactionRecord
  {
    return (new PLTFactionRecord($hex, $TIE))->loadHex();
  }

  public function __toString(): string
  {
    return '';
  }
}
