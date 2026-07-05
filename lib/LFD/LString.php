<?php
namespace Pyrite\LFD;

use Pyrite\PyriteModel;
    
class LString extends Base\LStringBase
{

    public static function fromHex(string $hex, ?PyriteModel $TIE = null): LString {
      return (new LString($hex, $TIE))->loadHex();
    }

    public function __toString(): string 
    {
      return '';
    }

    
}
