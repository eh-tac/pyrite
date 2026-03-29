<?php
namespace Pyrite\XvT;
    
class PLTFactionRecord extends Base\PLTFactionRecordBase
{

    public static function fromHex($hex, $tie = null) {
      return (new PLTFactionRecord($hex, $tie))->loadHex();
    }

    public function __toString() 
    {
      return '';
    }

    
}
