<?php
namespace Pyrite\XvT;
    
class PLTConnectedPlayerData extends Base\PLTConnectedPlayerDataBase
{

    public static function fromHex($hex, $tie = null) {
      return (new PLTConnectedPlayerData($hex, $tie))->loadHex();
    }

    public function __toString() 
    {
      return '';
    }

    
}
