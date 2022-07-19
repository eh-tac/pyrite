<?php

namespace Pyrite\XWA;

class GoalGlobal extends Base\GoalGlobalBase
{
  const POINT_MULTIPLIER = 25;

  public static function fromHex($hex, $tie = null)
  {
    return (new GoalGlobal($hex, $tie))->loadHex();
  }

  public function isActive()
  {
    return $this->Trigger1->isActive();
  }

  public function getPoints()
  {
    return $this->isActive() && $this->Points ? $this->Points * self::POINT_MULTIPLIER : 0;
  }

  public function __toString()
  {
    $a = $this->Trigger1->isActive() ? (string)$this->Trigger1 : '';
    $b = $this->Trigger2->isActive() ? (string)$this->Trigger2 : '';
    $c = $this->Trigger3->isActive() ? (string)$this->Trigger3 : '';
    $d = $this->Trigger4->isActive() ? (string)$this->Trigger4 : '';
    $ab = $a;
    $cd = $c;
    if ($b) {
      $ab .= $this->Trigger1OrTrigger2 ? ' OR ' : " AND ";
      $ab .= $b;
    }

    if ($d) {
      $cd .= $this->Trigger3OrTrigger4 ? ' OR ' : " AND ";
      $cd .= $d;
    }

    $str = $ab;
    if ($cd) {
      $str .= $this->Triggers12OrTriggers34 ? ' OR ' : " AND ";
      $str .= $cd;
    }

    return $str ? "$str  - {$this->getPoints()} points" : '';
  }
}
