<?php
namespace Pyrite\XWA;
    
class Skip extends Base\SkipBase
{

    public static function fromHex($hex, $tie = null) {
      return (new Skip($hex, $tie))->loadHex();
    }

    public function __toString() 
    {
      return '';
    }

    
}
