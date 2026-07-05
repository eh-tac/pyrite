<?php

namespace Pyrite\XW;

class Tag extends Base\TagBase
{

  public static function fromHex(string $hex, ?\Pyrite\PyriteModel $TIE = NULL): Tag
  {
    return (new Tag($hex, $TIE))->loadHex();
  }

  public function __toString(): string
  {
    return '';
  }
}
