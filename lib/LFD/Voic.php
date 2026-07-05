<?php
namespace Pyrite\LFD;

use Pyrite\PyriteModel;
    
class Voic extends Base\VoicBase
{

    public static function fromHex(string $hex, ?PyriteModel $TIE = null): Voic {
      return (new Voic($hex, $TIE))->loadHex();
    }

    public function __toString(): string 
    {
      return '';
    }

    
}
