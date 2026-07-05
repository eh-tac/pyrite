<?php
namespace Pyrite\LFD;

use Pyrite\PyriteModel;
    
class VoicData extends Base\VoicDataBase
{

    public static function fromHex(string $hex, ?PyriteModel $TIE = null): VoicData {
      return (new VoicData($hex, $TIE))->loadHex();
    }

    public function __toString(): string 
    {
      return '';
    }

    protected function loadData(): int 
    {
      return 0;
    }
  protected function writeData(): int 
    {
      return 0;
    }
}
