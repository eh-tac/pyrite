<?php
namespace Pyrite\LFD;

use Pyrite\PyriteModel;
    
class LText extends Base\LTextBase
{

    public static function fromHex(string $hex, ?PyriteModel $TIE = null): LText {
      return (new LText($hex, $TIE))->loadHex();
    }

    public function __toString(): string 
    {
      return '';
    }

    
}
