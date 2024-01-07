<?php

namespace Pyrite\XvT;

class GoalFG extends Base\GoalFGBase
{

  public static function fromHex($hex, $tie = null)
  {
    return (new GoalFG($hex, $tie))->loadHex();
  }

  public function __toString()
  {
    return "{$this->getGoalArgumentLabel()} {$this->getAmountLabel()} {$this->getConditionLabel()}";
  }

  public function getPoints()
  {
    return $this->Points * 250;
  }

  public function isBonus()
  {
    return $this->GoalArgument == Constants::$GOALARGUMENT_BONUSMUST || $this->GoalArgument == Constants::$GOALARGUMENT_BONUSMUSTNOT;
  }

  public function enabledForTeam1()
  {
    return $this->Team === 0;
  }
}
