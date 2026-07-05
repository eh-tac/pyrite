<?php
namespace Pyrite\LFD;

use Pyrite\PyriteModel;
    
class Rmap extends Base\RmapBase
{

    public static function fromHex(string $hex, ?PyriteModel $TIE = null): Rmap {
      return (new Rmap($hex, $TIE))->loadHex();
    }

    public function __toString(): string 
    {
      return '';
    }

    protected function HeaderCount(): int 
    {
      return 0;
    }
}
