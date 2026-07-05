<?php

namespace Pyrite\XvT;

class Order extends Base\OrderBase
{

  public static function fromHex(string $hex, ?\Pyrite\PyriteModel $TIE = null): Order
  {
    return (new Order($hex, $TIE))->loadHex();
  }

  public function __toString(): string
  {
    return '';
  }
}
