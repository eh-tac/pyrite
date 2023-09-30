<?php
namespace Pyrite\XW;
    
class ViewportSetting extends Base\ViewportSettingBase
{

    public static function fromHex($hex, $tie = null) {
      return (new ViewportSetting($hex, $tie))->loadHex();
    }

    public function __toString() 
    {
      return '';
    }

    
}
