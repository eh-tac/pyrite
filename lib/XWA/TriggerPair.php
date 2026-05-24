<?php
namespace Pyrite\XWA;
    
class TriggerPair extends Base\TriggerPairBase
{

    public static function fromHex($hex, $tie = null) {
      return (new TriggerPair($hex, $tie))->loadHex();
    }

    public function __toString() 
    {
      return '';
    }

    
}
