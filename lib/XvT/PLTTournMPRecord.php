<?php
namespace Pyrite\XvT;
    
class PLTTournMPRecord extends Base\PLTTournMPRecordBase
{

    public static function fromHex($hex, $tie = null) {
      return (new PLTTournMPRecord($hex, $tie))->loadHex();
    }

    public function __toString() 
    {
      return '';
    }

    
}
