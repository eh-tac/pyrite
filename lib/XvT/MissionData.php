<?php
namespace Pyrite\XvT;
    
class MissionData extends Base\MissionDataBase
{

    public static function fromHex($hex, $tie = null) {
      return (new MissionData($hex, $tie))->loadHex();
    }

    public function __toString() 
    {
      return '';
    }

    
}
