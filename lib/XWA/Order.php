<?php
namespace Pyrite\XWA;
    
class Order extends Base\OrderBase
{

    public static function fromHex($hex, $tie = null) {
      return (new Order($hex, $tie))->loadHex();
    }

    public function __toString() 
    {
      return '';
    }

    
}
