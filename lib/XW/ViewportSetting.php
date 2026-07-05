<?php

namespace Pyrite\XW;

class ViewportSetting extends Base\ViewportSettingBase
{

  public static function fromHex(string $hex, ?\Pyrite\PyriteModel $TIE = NULL): ViewportSetting
  {
    return (new ViewportSetting($hex, $TIE))->loadHex();
  }

  public function __toString(): string
  {
    return '';
  }
}
