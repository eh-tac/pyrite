<?php

namespace Pyrite\XvT;

class FileHeader extends Base\FileHeaderBase
{

  public static function fromHex(string $hex, ?\Pyrite\PyriteModel $TIE = null): FileHeader
  {
    return (new FileHeader($hex, $TIE))->loadHex();
  }

  public function __toString(): string
  {
    return '';
  }
}
