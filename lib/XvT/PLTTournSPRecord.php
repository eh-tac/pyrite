<?php
namespace Pyrite\XvT;
    
class PLTTournSPRecord extends Base\PLTTournSPRecordBase
{

    public static function fromHex($hex, $tie = null) {
      return (new PLTTournSPRecord($hex, $tie))->loadHex();
    }

    public function __toString() 
    {
      return '';
    }

    
}
