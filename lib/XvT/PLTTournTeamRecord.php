<?php
namespace Pyrite\XvT;
    
class PLTTournTeamRecord extends Base\PLTTournTeamRecordBase
{

    public static function fromHex($hex, $tie = null) {
      return (new PLTTournTeamRecord($hex, $tie))->loadHex();
    }

    public function __toString() 
    {
      return '';
    }

    
}
