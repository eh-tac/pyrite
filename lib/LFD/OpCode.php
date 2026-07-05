<?php
namespace Pyrite\LFD;

use Pyrite\PyriteModel;
    
class OpCode extends Base\OpCodeBase
{

    public static function fromHex(string $hex, ?PyriteModel $TIE = null): OpCode {
      return (new OpCode($hex, $TIE))->loadHex();
    }

    public function __toString(): string 
    {
      return '';
    }

    protected function ColorCount(): int 
    {
      return 0;
    }
}
