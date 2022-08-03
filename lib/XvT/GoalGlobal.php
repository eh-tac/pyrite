<?php
namespace Pyrite\XvT;
    
class GoalGlobal extends Base\GoalGlobalBase
{

    public static function fromHex($hex, $tie = null) {
      return (new GoalGlobal($hex, $tie))->loadHex();
    }

    public function __toString() 
    {
      return '';
    }

    
}
