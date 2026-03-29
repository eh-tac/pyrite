<?php
namespace Pyrite\XvT;
    
class PLTBattleMPRecord extends Base\PLTBattleMPRecordBase
{

    public static function fromHex($hex, $tie = null) {
      return (new PLTBattleMPRecord($hex, $tie))->loadHex();
    }

    public function __toString() 
    {
      return '';
    }

    
}
