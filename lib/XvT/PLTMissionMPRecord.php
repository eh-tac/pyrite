<?php
namespace Pyrite\XvT;
    
class PLTMissionMPRecord extends Base\PLTMissionMPRecordBase
{

    public static function fromHex($hex, $tie = null) {
      return (new PLTMissionMPRecord($hex, $tie))->loadHex();
    }

    public function __toString() 
    {
      return '';
    }

    
}
