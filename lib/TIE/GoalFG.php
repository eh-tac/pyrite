<?php

namespace Pyrite\TIE;

class GoalFG extends Base\GoalFGBase
{
  public function isCapture()
  {
    return $this->getConditionLabel() === 'Captured';
  }

  public function requiresSurvival()
  {
    return $this->hasData() && in_array($this->getConditionLabel(), [
      'Captured',
      'Survived',
      'Completed mission',
      'Completed Primary Goals'
    ]);
  }

  public function hasData()
  {
    // not always, not none
    return $this->Condition !== 0 && $this->Condition !== 10;
  }

  public function __toString()
  {
    return "{$this->getGoalAmountLabel()} {$this->getConditionLabel()}";
  }
}
