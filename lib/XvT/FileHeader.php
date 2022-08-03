<?php
namespace Pyrite\XvT;
    
class FileHeader extends Base\FileHeaderBase
{

    public static function fromHex($hex, $tie = null) {
      return (new FileHeader($hex, $tie))->loadHex();
    }

    public function __toString() 
    {
      return '';
    }

    
}
