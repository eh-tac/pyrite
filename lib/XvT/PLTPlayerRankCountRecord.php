<?php
namespace Pyrite\XvT;
    
class PLTPlayerRankCountRecord extends Base\PLTPlayerRankCountRecordBase
{

    public static function fromHex($hex, $tie = null) {
      return (new PLTPlayerRankCountRecord($hex, $tie))->loadHex();
    }

    public function __toString() 
    {
      return '';
    }

    
}
