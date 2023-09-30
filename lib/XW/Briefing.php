<?php
namespace Pyrite\XW;
    
class Briefing extends Base\BriefingBase
{

    public static function fromHex($hex, $tie = null) {
      return (new Briefing($hex, $tie))->loadHex();
    }

    public function __toString() 
    {
      return '';
    }

    protected function CoordinateCount() 
    {
      return 0;
    }
  protected function ViewportCount() 
    {
      return 0;
    }
}
