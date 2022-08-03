<?php
namespace Pyrite\XvT;
    
class Team extends Base\TeamBase
{

    public static function fromHex($hex, $tie = null) {
      return (new Team($hex, $tie))->loadHex();
    }

    public function __toString() 
    {
      return '';
    }

    
}
