<?php
namespace Pyrite\XvT;
    
class PLTBattleSPRecord extends Base\PLTBattleSPRecordBase
{

    public static function fromHex($hex, $tie = null) {
      return (new PLTBattleSPRecord($hex, $tie))->loadHex();
    }

    public function __toString() 
    {
      return '';
    }

    
}
