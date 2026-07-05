<?php

namespace Pyrite\XWA;

class FileHeader extends Base\FileHeaderBase
{

  public static function fromHex(string $hex, ?\Pyrite\PyriteModel $TIE = NULL): FileHeader
  {
    return (new FileHeader($hex, $TIE))->loadHex();
  }

  public function __toString(): string
  {
    return '';
  }
}
