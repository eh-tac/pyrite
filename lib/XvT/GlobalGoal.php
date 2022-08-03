<?php
namespace Pyrite\XvT;
    
class GlobalGoal extends Base\GlobalGoalBase
{

    public static function fromHex($hex, $tie = null) {
      return (new GlobalGoal($hex, $tie))->loadHex();
    }

    public function __toString() 
    {
      return '';
    }

    
}
