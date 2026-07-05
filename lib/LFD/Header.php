<?php
namespace Pyrite\LFD;

use Pyrite\PyriteModel;
    
class Header extends Base\HeaderBase
{

    public static function fromHex(string $hex, ?PyriteModel $TIE = null): Header {
      return (new Header($hex, $TIE))->loadHex();
    }

    public function __toString(): string 
    {
      return '';
    }

    
}
