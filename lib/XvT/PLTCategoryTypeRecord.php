<?php
namespace Pyrite\XvT;
    
class PLTCategoryTypeRecord extends Base\PLTCategoryTypeRecordBase
{

    public static function fromHex($hex, $tie = null) {
      return (new PLTCategoryTypeRecord($hex, $tie))->loadHex();
    }

    public function __toString() 
    {
      return '';
    }

    
}
