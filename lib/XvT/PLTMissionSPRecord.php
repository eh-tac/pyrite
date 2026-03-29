<?php
namespace Pyrite\XvT;
    
class PLTMissionSPRecord extends Base\PLTMissionSPRecordBase
{

    public static function fromHex($hex, $tie = null) {
      return (new PLTMissionSPRecord($hex, $tie))->loadHex();
    }

    public function __toString() 
    {
      return '';
    }

    
}
