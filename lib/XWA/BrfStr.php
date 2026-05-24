<?php
namespace Pyrite\XWA;
    
class BrfStr extends Base\BrfStrBase
{

    public static function fromHex($hex, $tie = null) {
      return (new BrfStr($hex, $tie))->loadHex();
    }

    public function __toString() 
    {
      return '';
    }

    
}
