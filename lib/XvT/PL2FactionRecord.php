<?php
namespace Pyrite\XvT;
    
class PL2FactionRecord extends Base\PL2FactionRecordBase
{

    public static function fromHex($hex, $tie = null) {
      return (new PL2FactionRecord($hex, $tie))->loadHex();
    }

    public function __toString() 
    {
      return '';
    }

    
}
