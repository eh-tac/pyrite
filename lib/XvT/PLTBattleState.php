<?php
namespace Pyrite\XvT;
    
class PLTBattleState extends Base\PLTBattleStateBase
{

    public static function fromHex($hex, $tie = null) {
      return (new PLTBattleState($hex, $tie))->loadHex();
    }

    public function __toString() 
    {
      return '';
    }

    
}
