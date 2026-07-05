<?php

namespace Pyrite\XvT;

class PLTAIRankCountRecord extends Base\PLTAIRankCountRecordBase
{

  public static function fromHex(string $hex, ?\Pyrite\PyriteModel $TIE = null): PLTAIRankCountRecord
  {
    return (new PLTAIRankCountRecord($hex, $TIE))->loadHex();
  }

  public function __toString(): string
  {
    return '';
  }
}
