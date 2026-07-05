<?php

namespace Pyrite\XvT;

class Role extends Base\RoleBase
{

  public static function fromHex(string $hex, ?\Pyrite\PyriteModel $TIE = NULL): Role
  {
    return (new Role($hex, $TIE))->loadHex();
  }

  public function __toString(): string
  {
    return '';
  }
}
