<?php
namespace Pyrite\LFD;

use Pyrite\PyriteModel;
    
class TIEBattle extends Base\TIEBattleBase
{

    public static function fromHex(string $hex, ?PyriteModel $TIE = null): TIEBattle {
      return (new TIEBattle($hex, $TIE))->loadHex();
    }

    public function __toString(): string 
    {
      return '';
    }

    
}
