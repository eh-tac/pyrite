<?php

namespace Pyrite\XW;

class BriefingHeader extends Base\BriefingHeaderBase
{

  public static function fromHex(string $hex, ?\Pyrite\PyriteModel $TIE = NULL): BriefingHeader
  {
    return (new BriefingHeader($hex, $TIE))->loadHex();
  }

  public function __toString(): string
  {
    return '';
  }
}
