<?php

namespace Pyrite\XvT;

class GoalGlobal extends Base\GoalGlobalBase
{

  public static function fromHex($hex, $tie = null)
  {
    return (new GoalGlobal($hex, $tie))->loadHex();
  }

  public function __toString()
  {
    $bits = [];
    $t1 = $this->TriggerA[0]->hasDataString();
    $t2 = $this->TriggerA[1]->hasDataString();
    $t3 = $this->TriggerB[0]->hasDataString();
    $t4 = $this->TriggerB[1]->hasDataString();

    if ($this->Trigger1OrTrigger2 && $t1 && $t2) {
      $bits[] = "($t1 OR $t2)";
    } else {
      if ($t1) {
        $bits[] = $t1;

        if ($t2) {
          $bits[] = "AND";
          $bits[] = $t2;
        }
      }
    }

    if ($this->Trigger2OrTrigger3 && $t3 && $t4) {
      $bits[] = "($t3 OR $t4)";
    } else {
      if ($t3) {
        $bits[] = $t3;

        if ($t4) {
          $bits[] = "AND";
          $bits[] = $t4;
        }
      }
    }

    return implode(" ", $bits);
  }

  public function getPoints()
  {
    if (!$this->isActive()) {
      return 0;
    }
    return $this->Points * 250;
  }

  public function isActive()
  {
    return ($this->TriggerA[0]->hasData() || $this->TriggerA[1]->hasData() || $this->TriggerB[0]->hasData() || $this->TriggerB[1]->hasData());
  }
}
