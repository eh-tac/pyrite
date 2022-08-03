<?php
namespace Pyrite\XvT;
    
class Event extends Base\EventBase
{

    public static function fromHex($hex, $tie = null) {
      return (new Event($hex, $tie))->loadHex();
    }

    public function __toString() 
    {
      return '';
    }

    
}
