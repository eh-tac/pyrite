<?php

namespace Pyrite\XvT;

class Trigger extends Base\TriggerBase
{

  public static function fromHex(string $hex, ?\Pyrite\PyriteModel $TIE = NULL): Trigger
  {
    return (new Trigger($hex, $TIE))->loadHex();
  }

  public function __toString()
  {
    return "{$this->getVariableTypeLabel()} {$this->getAmountLabel()} {$this->getConditionLabel()}";;
  }

  public function hasData()
  {
    return $this->Condition !== Constants::$CONDITION_ALWAYSTRUE;
  }

  public function hasDataString()
  {
    return $this->hasData() ? (string)$this : '';
  }
}
