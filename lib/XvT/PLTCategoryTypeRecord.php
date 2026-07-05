<?php

namespace Pyrite\XvT;

class PLTCategoryTypeRecord extends Base\PLTCategoryTypeRecordBase
{

  public static function fromHex(string $hex, ?\Pyrite\PyriteModel $TIE = null): PLTCategoryTypeRecord
  {
    return (new PLTCategoryTypeRecord($hex, $TIE))->loadHex();
  }

  public function __toString(): string
  {
    return '';
  }
}
