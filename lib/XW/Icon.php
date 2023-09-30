<?php
namespace Pyrite\XW;
    
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
