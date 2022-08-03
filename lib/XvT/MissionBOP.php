<?php
namespace Pyrite\XvT;
    
class MissionBOP extends Base\MissionBOPBase
{

    public static function fromHex($hex, $tie = null) {
      return (new MissionBOP($hex, $tie))->loadHex();
    }

    public function __toString() 
    {
      return '';
    }

    protected function FGGoalStringCount() 
    {
      return 0;
    }
}
