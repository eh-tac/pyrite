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
  public function killPointValue($level = NULL)
  {
    $ct = $this->getCraftType();
    $perShip = $ct->getPoints();
    $perShip += $this->getWarheadPoints($ct->missileCount);
    $perShip += $this->getBeamPoints();
    $perShip += $this->getCountermeasurePoints();
    $total = count($this) * $perShip;

    if ($level == 'Easy')     $total *= 0.5;
    if ($level == 'Hard')     $total *=   2;

    if ($this->isFriendly() || $this->isInvincible())   $total *=  -1;

    return $total;
  }
  public function getBeamPoints()
  {
    if ($this->Beam === Constants::$BEAM_DECOYBEAM) {
      return 250;
    } else if ($this->Beam === Constants::$BEAM_TRACTORBEAM) {
      return 150;
    } else if ($this->Beam === Constants::$BEAM_JAMMINGBEAM) {
      return 150;
    } else if ($this->Beam === Constants::$BEAM_ENERGYBEAM) {
      return 50;
    }
  }

  public function getCounterMeasurePoints()
  {
    if ($this->Countermeasures === Constants::$COUNTERMEASURES_CHAFF) {
      return 150;
    } else if ($this->Countermeasures === Constants::$COUNTERMEASURES_FLARE) {
      return 100;
    } else if ($this->Countermeasures === Constants::$COUNTERMEASURES_CLUSTERMINE) {
      return 150;
    }
  }

  public function getWarheadPoints($singleLauncherMissileCount = 0)
  {
    $pointPerWarhead = 0;
    $warheadCount = 0;
    if ($this->Warhead === Constants::$WARHEAD_CONCUSSIONMISSILE) {
      $pointPerWarhead = 10;
      $warheadCount = $singleLauncherMissileCount;
    } else if ($this->Warhead === Constants::$WARHEAD_ADVANCEDCONCUSSIONMISSILE) {
      $pointPerWarhead = 25;
      $warheadCount = $singleLauncherMissileCount;
    } else if ($this->Warhead === Constants::$WARHEAD_TORPEDO) {
      $pointPerWarhead = 15;
      $warheadCount = ceil($singleLauncherMissileCount * .75);
    } else if ($this->Warhead === Constants::$WARHEAD_ADVANCEDTORPEDO) {
      $pointPerWarhead = 25;
      $warheadCount = ceil($singleLauncherMissileCount * .75);
    } else if ($this->Warhead === Constants::$WARHEAD_HEAVYROCKET) {
      $pointPerWarhead = 30;
      $warheadCount = ceil($singleLauncherMissileCount * .50);
    } else if ($this->Warhead === Constants::$WARHEAD_SPACEBOMB) {
      $pointPerWarhead = 40;
      $warheadCount = ceil($singleLauncherMissileCount * .25);
    } else if ($this->Warhead === Constants::$WARHEAD_MAGPULSETORPEDO) {
      $pointPerWarhead = 10;
      $warheadCount = $singleLauncherMissileCount;
    } else if ($this->Warhead === Constants::$WARHEAD_IONPULSE) {
      $pointPerWarhead = 25;
      $warheadCount = $singleLauncherMissileCount;
    }
    if ($this->Status1 === Constants::$STATUS_N12WARHEADS || $this->Status2 === Constants::$STATUS_N12WARHEADS) {
      $warheadCount *= 0.5;
    }
    if ($this->Status1 === Constants::$STATUS_N2XWARHEADS || $this->Status2 === Constants::$STATUS_N2XWARHEADS) {
      $warheadCount *= 2;
    }


    // special handling for Missile Boat. 
    // If it has warheads, it will have 2x20 adv missiles in the second launcher and 2x the points per warhead count
    if ($this->CraftType === Constants::$SHIPS_MISSILEBOAT) {
      // warhead count is correct because has the second launcher so it was already x2
      if ($pointPerWarhead > 0) {
        return $pointPerWarhead * $warheadCount + 25 * 40;
      }
    } else {
      $warheadCount *= 2; // everyone has two launchers
      return $pointPerWarhead * $warheadCount;
    }
  }

  public function getCraftPoints()
  {
    $ct = $this->getCraftType();
    return $ct->craftPoints;
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

  public function hasMultipleWaves()
  {
    return $this->NumberOfWaves > 0;
  }

  public function isFriendly()
  {
    return $this->Team == 0;
  }

  public function destroyable()
  {
    return !$this->isInvincible();
  }

  public function isInvincible()
  {
    return $this->GroupAI === Constants::$GROUPAI_JEDIINVINCIBLE || $this->Status1 === Constants::$STATUS_INVINCIBLE || $this->Status2 === Constants::$STATUS_INVINCIBLE;
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
