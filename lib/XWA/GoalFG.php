<?php

namespace Pyrite\XWA;

class GoalFG extends Base\GoalFGBase
{
  const POINT_MULTIPLIER = 25;

  public static function fromHex($hex, $tie = null)
  {
    return (new GoalFG($hex, $tie))->loadHex();
  }

  public function isActive(): bool
  {
    if ($this->Condition === Constants::$CONDITION_NONEFALSE) {
      return false;
    }
    return $this->Enabled;
  }

  public function __toString()
  {
    if (!$this->isActive()) {
      return 'Disabled';
    }

    return "{$this->getAmountLabel()} {$this->getArgumentLabel()} {$this->getConditionLabel()} - {$this->getPoints()} points";
  }

  public function getPoints()
  {
    return $this->isActive() && $this->Points ? $this->Points * self::POINT_MULTIPLIER : 0;
  }

  public function getArgumentLabel()
  {
    $args = ['must', 'must NOT', 'BONUS must', 'BONUS must NOT'];
    return isset($this->Argument) && isset($args[$this->Argument]) ? $args[$this->Argument] : "Unknown";
  }

  public function getConditionLabel()
  {
    return isset($this->Condition) && isset(Constants::$CONDITION[$this->Condition]) ? Constants::$CONDITION[$this->Condition] : "Unknown";
  }

  public function getAmountLabel()
  {
    return isset($this->Amount) && isset(Constants::$AMOUNT[$this->Amount]) ? Constants::$AMOUNT[$this->Amount] : "Unknown";
  }
}
