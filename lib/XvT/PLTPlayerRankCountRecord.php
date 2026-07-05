<?php

namespace Pyrite\XvT;

class PLTPlayerRankCountRecord extends Base\PLTPlayerRankCountRecordBase
{

  public static function fromHex(string $hex, ?\Pyrite\PyriteModel $TIE = NULL): PLTPlayerRankCountRecord
  {
    return (new PLTPlayerRankCountRecord($hex, $TIE))->loadHex();
  }

  public function __toString(): string
  {
    return '';
  }
}
