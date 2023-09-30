<?php
namespace Pyrite\XW;
    
class Page extends Base\PageBase
{

    public static function fromHex($hex, $tie = null) {
      return (new Page($hex, $tie))->loadHex();
    }

    public function __toString() 
    {
      return '';
    }

    
}
