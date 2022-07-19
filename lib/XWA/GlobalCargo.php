<?php
namespace Pyrite\XWA;
    
class GlobalCargo extends Base\GlobalCargoBase
{

    public static function fromHex($hex, $tie = null) {
      return (new GlobalCargo($hex, $tie))->loadHex();
    }

    public function __toString() 
    {
      return '';
    }

    
}
