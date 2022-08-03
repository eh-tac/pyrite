<?php
namespace Pyrite\XvT;
    
class Message extends Base\MessageBase
{

    public static function fromHex($hex, $tie = null) {
      return (new Message($hex, $tie))->loadHex();
    }

    public function __toString() 
    {
      return '';
    }

    
}
