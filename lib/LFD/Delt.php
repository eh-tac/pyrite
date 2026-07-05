<?php
namespace Pyrite\LFD;

use Pyrite\PyriteModel;
    
class Delt extends Base\DeltBase
{

    public static function fromHex(string $hex, ?PyriteModel $TIE = null): Delt {
      return (new Delt($hex, $TIE))->loadHex();
    }

    public function __toString(): string 
    {
      return '';
    }

    protected function RowCount(): int 
    {
      return 0;
    }
}
