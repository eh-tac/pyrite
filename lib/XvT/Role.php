<?php
namespace Pyrite\XvT;
    
class Role extends Base\RoleBase
{

    public static function fromHex($hex, $tie = null) {
      return (new Role($hex, $tie))->loadHex();
    }

    public function __toString() 
    {
      return '';
    }

    
}
