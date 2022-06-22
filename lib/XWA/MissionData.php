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

  public function empty()
  {
    $this->UnkA = $this->UnkB = $this->UnkC = $this->UnkD = $this->UnkE = $this->UnkF = $this->UnkG = 0;
    $this->AttemptCount = 0;
    $this->WinCount = 0;
    $this->Score = 0;
    $this->Time = 0;
    $this->BonusScoreTen = 0;
    return $this;
  }

  public function skip()
  {
    $this->WinCount = 1;
    return $this;
  }
}
