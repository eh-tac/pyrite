<?php
namespace Pyrite\LFD;

use Pyrite\PyriteModel;
    
class BattleText extends Base\BattleTextBase
{

    public static function fromHex(string $hex, ?PyriteModel $TIE = null): BattleText {
      return (new BattleText($hex, $TIE))->loadHex();
    }

    public function __toString(): string 
    {
      return '';
    }

    protected function NumMissions(): int 
    {
      return 0;
    }
}
