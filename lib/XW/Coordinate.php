<?php
namespace Pyrite\XW;
    
class Coordinate extends Base\CoordinateBase
{

    public static function fromHex($hex, $tie = null) {
      return (new Coordinate($hex, $tie))->loadHex();
    }

    public function __toString() 
    {
      return '';
    }

    
}
