<?php

namespace Pyrite\XvT;

class Trigger extends Base\TriggerBase
{

  public static function fromHex($hex, $tie = null)
  {
    return (new Trigger($hex, $tie))->loadHex();
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
