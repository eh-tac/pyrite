<?php
namespace Pyrite\XvT;
    
class PLTTeamResultRecord extends Base\PLTTeamResultRecordBase
{

    public static function fromHex($hex, $tie = null) {
      return (new PLTTeamResultRecord($hex, $tie))->loadHex();
    }

    public function __toString() 
    {
      return '';
    }

    
}
