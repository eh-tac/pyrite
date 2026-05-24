<?php
namespace Pyrite\XWA;
    
class Icon extends Base\IconBase
{

    public static function fromHex($hex, $tie = null) {
      return (new Icon($hex, $tie))->loadHex();
    }

    public function __toString() 
    {
      return '';
    }

    
}
