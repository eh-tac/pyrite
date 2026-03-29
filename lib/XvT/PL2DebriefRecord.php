<?php
namespace Pyrite\XvT;
    
class PL2DebriefRecord extends Base\PL2DebriefRecordBase
{

    public static function fromHex($hex, $tie = null) {
      return (new PL2DebriefRecord($hex, $tie))->loadHex();
    }

    public function __toString() 
    {
      return '';
    }

    
}
