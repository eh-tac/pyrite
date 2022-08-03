<?php
namespace Pyrite\XvT;
    
class Tag extends Base\TagBase
{

    public static function fromHex($hex, $tie = null) {
      return (new Tag($hex, $tie))->loadHex();
    }

    public function __toString() 
    {
      return '';
    }

    
}
