<?php
namespace Pyrite\XvT;
    
class PLTBattleProgressState extends Base\PLTBattleProgressStateBase
{

    public static function fromHex($hex, $tie = null) {
      return (new PLTBattleProgressState($hex, $tie))->loadHex();
    }

    public function __toString() 
    {
      return '';
    }

    
}
