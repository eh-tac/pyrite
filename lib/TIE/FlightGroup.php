<?php

namespace Pyrite\TIE;

use Countable;
use Pyrite\Summary;

class FlightGroup extends Base\FlightGroupBase implements Summary, Countable
{
    public $destroyable = true;
    public $captureable = false; // in case these need to be overridden for special reasons.

    public function getShipType()
    {
        return new ShipType($this->CraftType);
    }

    public function isInDifficultyLevel($level)
    {
        if (!$this->arrives()) {
            return false;
        }
        $fgDiff = $this->getArrivalDifficultyLabel();
        if ($fgDiff === 'All') {
            return true;
        }
        return strpos($fgDiff, $level) !== false;
    }

    public function arrives()
    {
        // TODO check for impossible arrival conditions.
        return TRUE;
    }

    public function pointValue($level)
    {
        $coeff = 1;
        if ($level === 'Hard') $coeff = 1.25;
        if ($level === 'Easy') $coeff = 0.75;
        $typeValue = $this->getShipType()->pointValue();

        $pts = round(count($this) * $typeValue * $coeff);
        $pts = round($pts * 1.125); // collision on
        return $this->isFriendly() ? -10000 : $pts;
    }

    public function getBonusPoints()
    {
        return $this->BonusGoalPoints * 50;
    }

    public function capturable()
    {
        return count(array_filter($this->FlightGroupGoals, function ($g) {
            return $g->isCapture();
        }));
    }

    public function maxWarheads()
    {
        if ($this->getWarheadLabel() === 'None') {
            return 0;
        }
        $missiles = $this->getShipType()->missileCount();
        $status = $this->getStatusLabel();
        switch ($status) {
            case '2X Warheads':
                return $missiles * 2;
            case '1/2 Warheads':
                return ceil($missiles * 0.5);
            default:
                return $missiles;
        }
    }

    public function captureCount()
    {
        // $count = 0;
        // foreach (array('Primary', 'Secondary', 'Bonus') as $goal) {
        //     if ($this->goals[$goal . 'What'] === 'Captured') {
        //         switch ($this->goals[$goal . 'Who']) {
        //             case 'The special craft':
        //                 $count = 1;
        //                 break;
        //             case '50%':
        //                 $count = ceil($this->count() / 2);
        //                 break;
        //             case '100%':
        //                 $count = $this->count();
        //                 break;
        //         }
        //     }
        // }
        // return min($count, $this->count());
        return 1; // TODO
    }

    public function count()
    {
        return ($this->NumberOfWaves + 1) * $this->NumberOfCraft;
    }

    public function destroyable()
    {
        $mustSurvive = count(array_filter($this->FlightGroupGoals, function ($g) {
            return $g->requiresSurvival();
        })) > 0;

        return !$mustSurvive &&
            !$this->invincible() &&
            $this->destroyable;
    }

    public function invincible()
    {
        return $this->GroupAI === 5;
    }

    public function isPlayerCraft()
    {
        return $this->PlayerCraft > 0;
    }

    public function isFriendly()
    {
        return $this->PlayerCraft > 0 || $this->Iff === 1;
    }

    public function hasMothership()
    {
        return $this->ArriveViaMothership === true || $this->AlternateArriveViaMothership === true;
    }

    public function getMothershipFG()
    {
        return $this->TIE->FlightGroups[$this->ArrivalMothership];
    }

    public function label()
    {
        $waves = $this->NumberOfWaves === 0 ? '' : ($this->NumberOfWaves + 1) . 'x';
        $parts = [
            $this->getIFFLabel(),
            "{$waves}{$this->NumberOfCraft}",
            $this->getCraftTypeLabel(),
            $this->Name
        ];

        return trim(implode(" ", $parts));
    }

    public function __toString()
    {
        $shipType = $this->getShipType();
        $waves = $this->NumberOfWaves === 0 ? '' : ($this->NumberOfWaves + 1) . 'x';
        $craft = $waves || $this->NumberOfCraft > 1 ? $this->NumberOfCraft : '';

        $parts = [
            "{$waves}{$craft}",
            $shipType->Abbr,
            $this->Name
        ];

        return trim(implode(" ", $parts));
    }

    public function hasMultipleWaves()
    {
        return $this->NumberOfWaves > 0;
    }

    public function getIFFLabel()
    {
        return $this->TIE->lookupIFF($this->Iff);
    }

    public function summaryHash()
    {
        $waves = $this->NumberOfWaves === 0 ? '' : ($this->NumberOfWaves + 1) . 'x';
        $diff = $this->getArrivalDifficultyLabel();
        return [
            'IFF'        => $this->getIFFLabel(),
            'Craft'      => "{$waves}{$this->NumberOfCraft}",
            'Type'       => $this->getCraftTypeLabel(),
            'Name'       => $this->printChar($this->Name),
            'Difficulty' => $diff
        ];
    }
}
