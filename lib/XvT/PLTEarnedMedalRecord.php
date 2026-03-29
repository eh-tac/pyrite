<?php
namespace Pyrite\XvT;
    
class PLTEarnedMedalRecord extends Base\PLTEarnedMedalRecordBase
{

    public static function fromHex($hex, $tie = null) {
      return (new PLTEarnedMedalRecord($hex, $tie))->loadHex();
    }

    public function __toString() 
    {
      return '';
    }

    
}
