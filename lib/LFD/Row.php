<?php
namespace Pyrite\LFD;

use Pyrite\PyriteModel;
    
class Row extends Base\RowBase
{

    public static function fromHex(string $hex, ?PyriteModel $TIE = null): Row {
      return (new Row($hex, $TIE))->loadHex();
    }

    public function __toString(): string 
    {
      return '';
    }

    protected function ColorCount(): int 
    {
      return 0;
    }
  protected function OpCount(): int 
    {
      return 0;
    }
}
