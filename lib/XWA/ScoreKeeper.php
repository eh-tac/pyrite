<?php

namespace Pyrite\XWA;

use Pyrite\IScoreKeeper;
use Pyrite\ScoreRow;

class ScoreKeeper  implements IScoreKeeper
{
    private $TIE;

    /** @var FlightGroup */
    private $playerCraft = array();
    private $globalGoals = array();
    private $fgGoals = array();
    private $fgs = array();
    private $win = 250;
    private $goalPoints = 0;
    private $difficultyFilter;

    public $total = 0;
    public $player = null;
    public $warhead = null;

    /** @var ScoreRow[] */
    public $flightGroups = [];
    /** @var ScoreRow[] */
    public $goals = [];
    /** @var ScoreRow[] */
    public $craftOptions = [];

    public function __construct(Mission $TIE, $difficulty = 'Hard')
    {
        $this->TIE = $TIE;
        $this->difficultyFilter = $difficulty;
        if ($this->TIE->valid()) {
            $this->process();
        }
    }

    public function getData(): array
    {
        return array_merge(
            [ScoreRow::header("Flight Groups")],
            $this->flightGroups,
            [ScoreRow::header("Goals")],
            $this->goals,
            [ScoreRow::header("Player Craft")],
            $this->craftOptions
        );
    }

    public function getTotal(): int
    {
        return 0;
    }

    public function process()
    {
        /** @var FlightGroup $fg */
        foreach ($this->TIE->FlightGroups as $idx => $fg) {
            if (!$fg->isInDifficultyLevel($this->difficultyFilter)) continue;

            $name = (string)$fg;
            $points = $fg->pointValue($this->difficultyFilter);

            if ($points > 0) {
                $this->total += $points;
                $this->fgs[] = $name . ': ' . $points;
            } else {
                $this->fgs[] = $name . ' - no points';
            }

            /** @var GoalFG $goal */
            foreach ($fg->Goals as $goal) {
                if ($goal->getPoints()) {
                    $this->fgGoals[] = $fg . " - " . $goal;
                    $this->total += $goal->getPoints();
                    $this->goalPoints += $goal->getPoints();
                }
            }

            if ($fg->isPlayerCraft()) {
                $this->playerCraft[] = $fg;
            }
        }

        $primary = $this->TIE->GlobalGoals[0]->Goal[0];
        if ($primary->isActive()) {
            $this->globalGoals['Primary'] = (string)$primary;
            $this->goalPoints += $primary->getPoints();
        }
        $bonus = $this->TIE->GlobalGoals[0]->Goal[2];
        if ($bonus->isActive()) {
            $this->globalGoals['Bonus'] = (string)$bonus;
            $this->goalPoints += $bonus->getPoints();
        }
    }

    public function printDump()
    {
        $goals = array("Primary" =>  "{$this->win} pts");
        $this->total += $this->win;
        $craft = array();
        $pcMax = array();
        if (!empty($this->playerCraft)) {
            foreach ($this->playerCraft as $pc) {
                $craft[] = (string)$pc;
                $hangarPoints = $pc->pointValue('Medium', FALSE) * -1; //ignore friendly filter //always just get medium points
                //
                $pcMax[] = $hangarPoints;
                $craft[] = 'Hanger/hyper points: ' . $hangarPoints . ' pts';
                $this->player = (string)$pc;
            }
            //            $this->warhead = $this->playerCraft->general['Warheads'];
        } else {
            $craft[] = 'Player craft not found';
        }
        $this->total += count($pcMax) ? max($pcMax) : 0;

        return array(
            'Difficulty' => $this->difficultyFilter,
            'Enemies' => $this->fgs,
            'Craft options' => $craft,
            'Goals' => array_merge($goals, $this->globalGoals),
            'FGGoals' => $this->fgGoals,
            'Total Potential Score' => $this->total . ' pts',
        );
    }

    public function getGoals()
    {
        return [
            'Global Goals' => $this->globalGoals,
            'FG Goals' => $this->fgGoals,
            'Total Goal Points Available' => $this->goalPoints
        ];
    }
}
