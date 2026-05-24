<?php
namespace Pyrite\XWA;
    
class GlobalUnit extends Base\GlobalUnitBase
{

    public static function fromHex($hex, $tie = null) {
      return (new GlobalUnit($hex, $tie))->loadHex();
    }

    public function __toString() 
    {
      return '';
    }

    
}
