<?php

namespace Pyrite\XW;

use Countable;

class FlightGroup extends Base\FlightGroupBase implements Countable
{

    public function beforeConstruct()
    {
    }

    public function __toString()
    {
        $w = $this->NumberOfWaves + 1;
        $c = $this->NumberOfCraft;

        $t = $this->getCraftTypeLabel();
        $n = implode($this->Name);

        return "$w x $c $t $n";
    }

    public function count(): int
    {
        return (int)$this->NumberOfCraft * ((int)$this->NumberOfWaves + 1);
    }

    public function pointValue($difficultyIsIrrelevant = NULL)
    {
        $FG_POINTS = array(
            0, 600, 400, 800, 400, 600, 600, 800, 600, 800,
            200, 800, 1200, 6000, 4000, 1600, 8000,
            1800, 1800 //only guessing re: BWing
        );

        $pts = count($this) * $FG_POINTS[$this->CraftType];
        return $this->isFriendly() ? -5000 : $pts;
    }

    public function isFriendly()
    {
        return $this->IFF == 1;
    }

    /** @return bool whether the object is able to be destroyed - whether invincible or mission critical */
    public function destroyable()
    {
        return TRUE;
    }

    /** @return bool whether the object is invincible */
    public function invincible()
    {
        return FALSE;
    }

    /** @return bool whether the object is the player craft */
    public function isPlayerCraft()
    {
        return $this->PlayerCraft != 0;
    }

    /** @return int the maximum number of warheads the craft may carry */
    public function maxWarheads()
    {
        return 6; // XW torps 6 AW miss 12 YW torp 8
    }

    public function isGoal()
    {
        return $this->Objective;
    }

    public function goalLabel()
    {
        $a = $this->getArriveLabel();
        return $this . ' - must be ' . $this->getObjectiveLabel() . ' ' . $a;
    }

    public function getArriveLabel()
    {
        if (!$this->ArrivalEvent && !$this->ArrivalDelay) {
            return '';
        }
        $e = $this->getArrivalEventLabel();
        if ($this->ArrivalFG) {
            $fg = $this->TIE->getFG($this->ArrivalFG);
            $e = $fg . ' - be ' . $e;
        }
        $d = $this->ArrivalDelay;
        if ($d) {
            if ($d <= 20) {
                // If ArrivalDelay <= 20, the value is interpreted as minutes.
                $d .= 'm';
            } else {
                $d -= 20;
                // If ArrivalDelay > 20, subtract 20, then multiply the result by 6 seconds.
                $d *= 6;
                $d .= 's';
            }
        }
        return "arrives $d after $e";
    }
}
