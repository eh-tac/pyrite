<?php

namespace Pyrite\XvT;

use Countable;
use Pyrite\FlightGroupScoring;

class FlightGroup extends Base\FlightGroupBase implements FlightGroupScoring, Countable
{
  public function getCraftType(): CraftType
  {
    return new CraftType($this->CraftType);
  }

  public function isInDifficultyLevel($difficulty): bool
  {
    if (!$this->arrives()) return FALSE;

    if ($this->getArrivalDifficultyLabel() === 'All') return TRUE;

    return strpos($this->getArrivalDifficultyLabel(), $difficulty) !== FALSE;
  }

  private function arrives(): bool
  {
    //TODO add conditions which might stop the FG arriving.
    //e.g. on 100% player destruction is the trigger
    return TRUE;
  }

  /**
   * @param mixed $level 
   * @return int Pyrite\points 
   */
  public function pointValue($level = NULL)
  {
    $ct = $this->getCraftType();
    $perShip = $ct->getPoints();
    $perShip += $this->getWarheadPoints();
    $total = count($this) * $perShip;

    if ($level == 'Easy')     $total *= 0.5;
    if ($level == 'Hard')     $total *=   2;

    if ($this->isFriendly())   $total *=  -1;

    return $total;
  }

  public function getWarheadPoints()
  {
    $wh = 0;
    if ($this->Warhead === Constants::$WARHEAD_CONCUSSIONMISSILE) {
      $wh = 80;
    } else if ($this->Warhead === Constants::$WARHEAD_ADVANCEDCONCUSSIONMISSILE) {
      $wh = 200;
    } else if ($this->Warhead === Constants::$WARHEAD_TORPEDO) {
      $wh = 90;
    } else if ($this->Warhead === Constants::$WARHEAD_ADVANCEDTORPEDO) {
      $wh = 120;
    } else if ($this->Warhead === Constants::$WARHEAD_HEAVYROCKET) {
      $wh = 120;
    } else if ($this->Warhead === Constants::$WARHEAD_SPACEBOMB) {
      $wh = 80;
    } else if ($this->Warhead === Constants::$WARHEAD_MAGPULSETORPEDO) {
      $wh = 80;
    }
    if ($this->Status1 == Constants::$STATUS_N12WARHEADS || $this->Status2 === Constants::$STATUS_N12WARHEADS) {
      $wh *= 0.5;
    }
    if ($this->Status1 == Constants::$STATUS_N2XWARHEADS || $this->Status2 === Constants::$STATUS_N2XWARHEADS) {
      $wh *= 2;
    }
    return $wh;
  }

  public function getHangarHyperPoints()
  {
    $ct = $this->getCraftType();
    return $this->maxHangarHyperPoints($ct, $this->NumberOfWaves, $this->NumberOfCraft);
  }

  public function getWaveOptions()
  {
    $options = [];
    foreach ($this->OptionalCraft as $idx => $craftID) {
      if (!$craftID) {
        continue;
      }
      $ct = new CraftType($craftID);
      $perWave = $this->NumberOfOptionalCraft[$idx];
      $extraWaves = $this->NumberOfOptionalCraftWaves[$idx];
      $waves = $extraWaves + 1;
      $label = "{$waves} x $perWave {$ct->Abbr} {$this->Name}";
      $options[] = [
        'label' => $label,
        'maxPoints' => $this->maxHangarHyperPoints($ct, $extraWaves, $perWave)
      ];
    }
    return $options;
  }

  private function maxHangarHyperPoints($craftType, $extraWaves, $perWave)
  {
    $perShip = $craftType->getPoints();
    return ($extraWaves * $perWave * 2 * $perShip) + ($perWave - 1) * $perShip;
  }

  public function isFriendly()
  {
    return $this->Team == 0;
  }

  public function destroyable()
  {
    return !$this->invincible();
  }

  public function invincible()
  {
    return $this->GroupAI !== Constants::$GROUPAI_JEDIINVINCIBLE;
  }

  public function maxWarheads()
  {
    return 0;
  }

  public function isPlayerCraft()
  {
    return (bool) $this->PlayerNumber;
  }

  public static function fromHex($hex, $tie = null)
  {
    return (new FlightGroup($hex, $tie))->loadHex();
  }

  public function __toString()
  {
    $ct = $this->getCraftType();
    $waves = (int) ($this->NumberOfWaves + 1);
    $perWave = (int) $this->NumberOfCraft;
    return "$waves x $perWave {$ct->Abbr} {$this->Name}";
  }

  public function count(): int
  {
    return (int) ($this->NumberOfWaves + 1) * (int) $this->NumberOfCraft;
  }

  public function coop()
  {
    $c = (int) ($this->NumberOfWaves + 1) * (int) $this->NumberOfCraft;
    $ct = $this->getCraftType();
    return $c . 'x ' . $ct->Abbr;
  }
}
