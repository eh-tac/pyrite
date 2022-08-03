<?php
namespace Pyrite\XvT;
    
class Trigger extends Base\TriggerBase
{

    public static function fromHex($hex, $tie = null) {
      return (new Trigger($hex, $tie))->loadHex();
    }

    public function __toString() 
    {
      return '';
    }

    
}
