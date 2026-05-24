<?php
namespace Pyrite\XWA;
    
class Region extends Base\RegionBase
{

    public static function fromHex($hex, $tie = null) {
      return (new Region($hex, $tie))->loadHex();
    }

    public function __toString() 
    {
      return '';
    }

    
}
