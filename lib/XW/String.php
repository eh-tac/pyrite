<?php
namespace Pyrite\XW;
    
class String extends Base\StringBase
{

    public static function fromHex($hex, $tie = null) {
      return (new String($hex, $tie))->loadHex();
    }

    public function __toString() 
    {
      return '';
    }

    
}
