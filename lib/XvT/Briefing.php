<?php
namespace Pyrite\XvT;
    
class Briefing extends Base\BriefingBase
{

    public static function fromHex($hex, $tie = null) {
      return (new Briefing($hex, $tie))->loadHex();
    }

    public function __toString() 
    {
      return '';
    }

    
}
