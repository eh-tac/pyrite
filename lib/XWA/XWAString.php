<?php
namespace Pyrite\XWA;
    
class XWAString extends Base\XWAStringBase
{

    public static function fromHex($hex, $tie = null) {
      return (new XWAString($hex, $tie))->loadHex();
    }

    public function __toString() 
    {
      return '';
    }

    
}
