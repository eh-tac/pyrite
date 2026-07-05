<?php

namespace Pyrite\XWA;

use Countable;

class FlightGroup extends Base\FlightGroupBase implements Countable
{
  public $craft;

  public static function fromHex(string $hex, ?\Pyrite\PyriteModel $TIE = NULL): FlightGroup
  {
    $fg = (new FlightGroup($hex, $TIE))->loadHex();
    $fg->craft = new CraftType($fg->CraftType);
    return $fg;
  }

  public function __toString()
  {
    $this->craft = new CraftType($this->CraftType);
    return count($this) . 'x ' . $this->craft->Abbr . ' ' . $this->Name;
  }

  public function getLabel()
  {

    return (string)$this .
      " " . Constants::$GROUPAI[$this->GroupAI] . " " .
      "[{$this->ArrivalDifficulty}]" .
      ($this->Warhead != "None" ? ' (' . $this->Warhead . ')' : "") .
      ($this->GlobalGroup ? ' (GG ' . $this->GlobalGroup . ')' : "") .
      ($this->GlobalUnit ? ' (GU ' . $this->GlobalUnit . ')' : "");
  }

  public function isInDifficultyLevel($level)
  {
    $arrival = $this->getArrivalDifficultyLabel();
    if ($arrival === 'All') {
      return true;
    }
    return strpos($arrival, $level) !== FALSE;
  }

  public function pointValue($level)
  {
    return 1;
  }

  public function isPlayerCraft()
  {
    return $this->PlayerNumber;
  }

  public function count(): int
  {
    return (int)$this->NumberOfCraft * ((int)$this->NumberOfWaves + 1);
  }
}
