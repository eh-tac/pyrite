<?php

namespace Pyrite\TIE;

class Complexity
{
    private ?FlightGroup $playerCraft = null;
    private $fgs = array();
    private $goalTypes = array('Primary' => array(), 'Secondary' => array());
    private $points = array('Friendly' => 0, 'Hostile' => 0);

    public $total = 0;

    public function __construct(public Mission $TIE)
    {
        if ($this->TIE->valid()) {
            $this->process();
        }
    }

    public function process()
    {
        $difficultyFilter = 'Easy';
        if ($this->TIE->FileHeader->BriefingOfficers !== Constants::$BRIEFINGOFFICERS_SECRETORDER) {
            unset($this->goalTypes['Secondary']);
        }

        foreach ($this->goalTypes as $type => &$goals) {
            foreach ($this->TIE->GlobalGoals[$type]->Triggers as $trigger) {
                if ($trigger instanceof Trigger && $trigger->hasData()) {
                    $goalPts = $this->goalPoints($trigger->getConditionLabel(), $trigger->getTriggerAmountLabel(), 1);
                    $this->total += $goalPts;
                    $goals[] = (string)$trigger . ' = ' . $goalPts;
                }
            }
        }

        foreach ($this->TIE->FlightGroups as $idx => $fg) {
            if (!$fg->isInDifficultyLevel($difficultyFilter)) continue;

            $name = (string)$fg;
            $pts = $fg->pointValue($difficultyFilter);
            if ($fg->isFriendly()) {
                $this->points['Friendly'] += $pts;
                $this->fgs[] = $name . ' friendly ' . $pts;
            } else {
                $this->points['Hostile'] += $pts;
                $this->fgs[] = $name . ' hostile ' . $pts;
            }

            $win = $fg->FlightGroupGoals;
            foreach ($this->goalTypes as $type => &$goals) {
                if ($win[$type . 'What'] !== 'None') {
                    $goalPts = $this->goalPoints($win[$type . 'What'], $win[$type . 'Who'], sqrt(count($fg)));
                    $goals[] = $win[$type . 'Who'] . ' Flight Group ' . $fg . ' must be ' . $win[$type . 'What'] . ' = ' . $goalPts;
                    $this->total += $goalPts;
                }
            }

            if ($fg->isPlayerCraft()) {
                $this->playerCraft = $fg;
            }
        }
    }

    private function goalPoints(string $condition, string $who, float $fgCount): int
    {
        $multiplier = array(
            'Always' => 0,
            'Created' => 10,
            'Destroyed' => 2,
            'Attacked' => 1,
            'Captured' => 100,
            'Identified' => 1,
            'Boarded' => 50,
            'Docked' => 50,
            'Disabled' => 30,
            'Survived' => 10,
            'Completed Mission' => 30
        );
        $multi = isset($multiplier[$condition]) ? $multiplier[$condition] : 100;
        switch ($who) {
            case 'At least one':
            case 'Player craft':
            case 'Special craft':
                $fgCount = 1;
                break;
            case '50%':
                $fgCount *= 0.50;
                break;
            case '25%':
                $fgCount *= 0.25;
                break;
            case '75%':
                $fgCount *= 0.75;
                break;
            case 'All but one':
            case 'Non-player craft':
            case 'Non special craft':
                $fgCount = max(1, $fgCount - 1);
                break;
        }
        return $multi * $fgCount;
    }

    public function printDump()
    {
        foreach ($this->goalTypes as $goals) {
            foreach ($goals as $goal) {
                $this->total *= 1.1; //more goals = more harder
            }
        }

        $allyRatio = $this->points['Hostile'] / max($this->points['Friendly'], 1) * 2; //player makes friendlies much more powerful
        $this->total *= max(0.66, min($allyRatio, 2));

        $pm = $this->playerMulti();
        $craft = array('Player craft: ' . (string)$this->playerCraft . ' x' . $pm);
        $this->total *= $pm;

        return array_merge($this->fgs, $craft, $this->points, $this->goalTypes, array('Total score: ' . $this->total . ' pts'));
    }

    private function playerMulti()
    {
        if (!$this->playerCraft) return 1000;
        $multiplier = array('TIE Fighter' => 5, 'TIE Interceptor' => 4, 'TIE Bomber' => 6, 'TIE Advanced' => 2, 'TIE Defender' => 1, 'Missile Boat' => 1, 'Assault Gunboat' => 3);
        $type = $this->playerCraft->getCraftTypeLabel();

        $multi = isset($multiplier[$type]) ? $multiplier[$type] : 5; //most patches are good ships, but patches are hassle too.
        if ($this->playerCraft->maxWarheads() == 0) $multi *= 5;
        return min($multi, 10);
    }
}
