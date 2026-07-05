<?php

namespace Pyrite\XvT;

use Pyrite\PyriteModel;

class GoalFG extends Base\GoalFGBase
{

  public static function fromHex(string $hex, ?PyriteModel $TIE = null): GoalFG
  {
    return (new GoalFG($hex, $TIE))->loadHex();
  }

  public function __toString()
  {
    return "{$this->getGoalArgumentLabel()} {$this->getAmountLabel()} {$this->getConditionLabel()}";
  }

  public function getPoints()
  {
    return $this->Points * 250;
  }

  public function hasConditionSet()
  {
    return $this->Enabled && $this->Condition != Constants::$CONDITION_NONEFALSE && $this->Condition != Constants::$CONDITION_ALWAYSTRUE;
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
