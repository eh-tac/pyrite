<?php

namespace Pyrite\XWA;

class MissionData extends Base\MissionDataBase
{

  public function beforeConstruct()
  {
  }

  public function __toString()
  {
    return '';
  }

  public function getTotal()
  {
    return $this->Score + $this->BonusScoreTen / 10;
  }

  public function getTimeDisplay()
  {
    $min = floor($this->Time / 60);
    $sec = $this->Time % 60;

    return str_pad($min, 2, "0", STR_PAD_LEFT) . ':' . str_pad($sec, 2, "0", STR_PAD_LEFT);
  }
}
