<?php
namespace Pyrite\XW;
    
class BriefingHeader extends Base\BriefingHeaderBase
{

    public static function fromHex($hex, $tie = null) {
      return (new BriefingHeader($hex, $tie))->loadHex();
    }

    public function __toString() 
    {
      return '';
    }

    
}
