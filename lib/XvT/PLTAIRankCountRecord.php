<?php
namespace Pyrite\XvT;
    
class PLTAIRankCountRecord extends Base\PLTAIRankCountRecordBase
{

    public static function fromHex($hex, $tie = null) {
      return (new PLTAIRankCountRecord($hex, $tie))->loadHex();
    }

    public function __toString() 
    {
      return '';
    }

    
}
