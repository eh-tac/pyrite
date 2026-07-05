<?php

namespace Pyrite\XW;

class Page extends Base\PageBase
{

  public static function fromHex(string $hex, ?\Pyrite\PyriteModel $TIE = NULL): Page
  {
    return (new Page($hex, $TIE))->loadHex();
  }

  public function __toString(): string
  {
    return '';
  }
}
