<?php

namespace Pyrite\XWA;

class Trigger extends Base\TriggerBase
{

  public static function fromHex($hex, $tie = null)
  {
    return (new Trigger($hex, $tie))->loadHex();
  }

  public function isActive(): bool
  {
    if ($this->Condition === Constants::$CONDITION_NONEFALSE || $this->Condition === Constants::$CONDITION_ALWAYSTRUE) {
      return false;
    }
    return true;
  }

  public function __toString()
  {
    if (!$this->isActive()) {
      return 'Disabled';
    }

    return "{$this->getAmountLabel()} {$this->getVariableTypeLabel()} {$this->getVariableLabel()} is {$this->getConditionLabel()}";
  }

  public function getVariableLabel()
  {
    switch ($this->VariableType) {
      case Constants::$VARIABLETYPE_CRAFTTYPEENUM:
        return Constants::$CRAFTTYPE[$this->Variable];
    }
    return "?";
  }
}
