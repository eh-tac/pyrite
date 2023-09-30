<?php
namespace Pyrite\XW;
    
class MissionHeader extends Base\MissionHeaderBase
{

    public static function fromHex($hex, $tie = null) {
      return (new MissionHeader($hex, $tie))->loadHex();
    }

    public function __toString() 
    {
      return '';
    }

    
}
