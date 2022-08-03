<?php
namespace Pyrite\XvT;
    
class GoalFG extends Base\GoalFGBase
{

    public static function fromHex($hex, $tie = null) {
      return (new GoalFG($hex, $tie))->loadHex();
    }

    public function __toString() 
    {
      return '';
    }

    
}
