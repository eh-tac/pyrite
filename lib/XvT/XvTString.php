<?php
namespace Pyrite\XvT;
    
class XvTString extends Base\XvTStringBase
{

    public static function fromHex($hex, $tie = null) {
      return (new XvTString($hex, $tie))->loadHex();
    }

    public function __toString() 
    {
      return '';
    }

    
}
