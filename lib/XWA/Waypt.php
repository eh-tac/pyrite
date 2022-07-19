<?php
namespace Pyrite\XWA;
    
class Waypt extends Base\WayptBase
{

    public static function fromHex($hex, $tie = null) {
      return (new Waypt($hex, $tie))->loadHex();
    }

    public function __toString() 
    {
      return '';
    }

    
}
