<?php

namespace Pyrite\XvT;

class FlightGroup extends Base\FlightGroupBase
{

  public static function fromHex($hex, $tie = null)
  {
    return (new FlightGroup($hex, $tie))->loadHex();
  }

  public function __toString()
  {
    return count($this) . 'x ' . $this->ShipType->Abbr . ' ' . $this->Name .
      "";
  }

  public function count()
  {
    return (int) ($this->NumberOfWaves + 1) * (int) $this->NumberOfCraft;
  }

  public function coop()
  {
    $c = (int) ($this->NumberOfWaves + 1) * (int) $this->NumberOfCraft;
    $ct = new CraftType($this->CraftType);
    return $c . 'x ' . $ct->Abbr;
  }

  public function isPlayerCraft()
  {
    return (bool) $this->PlayerNumber;
  }
}
