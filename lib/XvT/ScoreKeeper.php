<?php

namespace Pyrite\XvT;

use Pyrite\IScoreKeeper;
use Pyrite\ScoreRow;

class ScoreKeeper implements IScoreKeeper
{
    /** @var Mission */
    private $TIE;

    private $difficultyFilter;

    public $total = 0;
    public $player = null;
    public $warhead = null;
    public $bonus = 0;

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
        $this->process();
    }

    public function process()
    {
        // XvT has 10000 points for victory regardless of difficulty level
        $this->goals = [
            ScoreRow::create("Mission Victory {$this->difficultyFilter}", 1, 10000)
        ];

        $flightGroups = array_filter($this->TIE->FlightGroups, fn ($fg) => $fg->isInDifficultyLevel($this->difficultyFilter));
        $playerCraft = array_filter($flightGroups, fn ($fg) => $fg->isPlayerCraft());

        $hasBonusGoals = FALSe;

        /** @var GlobalGoal */
        $team1GG = $this->TIE->GlobalGoals[0];
        // TODO improve trigger string lookup so it can handle conditions and vairablets things
        // TODO open question - if the prevent goals award points, do you get them? on mission completion?
        foreach ([0 => 'Primary', 1 => 'Prevent', 2 => 'Bonus'] as $idx => $type) {
            /** @var GoalGlobal */
            $gg = $team1GG->Goal[$idx];
            if ($gg->getPoints() > 0) {
                $goal = ScoreRow::create("$type goal: " . $gg, 1, $gg->getPoints());
                $this->goals[] = $goal;
                if ($type === 'Bonus') {
                    $hasBonusGoals = TRUE;
                }
                if ($type === 'Prevent') {
                    $goal->label .= '(PREVENT??)';
                    $goal->disable();
                }
            }
        }

        foreach ($flightGroups as $fg) {
            $pointValue = $fg->pointValue($this->difficultyFilter);
            if ($pointValue > 0) {
                $this->flightGroups[] = ScoreRow::create((string) $fg, count($fg), $pointValue);
            }

            /** @var GoalFG $goal */
            foreach ($fg->Goals as $goal) {
                if ($goal->getPoints() > 0 && $goal->enabledForTeam1()) {
                    $this->goals[] = ScoreRow::create("$fg - $goal", 1, $goal->getPoints());
                    if ($goal->isBonus()) {
                        $hasBonusGoals = TRUE;
                    }
                }
            }
        }

        if ($hasBonusGoals) {
            $this->goals[] = ScoreRow::create("All bonus goals", 1, 2500);
        }

        // TODO need to account for double wave points.
        foreach ($playerCraft as $fg) {
            $this->craftOptions[] = ScoreRow::create("$fg hangar/hyper points", count($fg), $fg->getHangarHyperPoints());
            foreach ($fg->getWaveOptions() as $wave) {
                $this->craftOptions[] = ScoreRow::create("Wave option {$wave['label']} hangar/hyper points", 1, $wave['maxPoints']);
            }
        }
        usort($this->craftOptions, fn ($a, $b) => $b->points - $a->points);
        for ($i = 1; $i < count($this->craftOptions); $i++) {
            $this->craftOptions[$i]->disable();
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

    public function printDump()
    {
        return $this->getData();
    }

    public function getTotal(): int
    {
        $rows = array_filter($this->getData(), fn ($row) => $row->number > 0);
        return array_sum(array_map(fn ($row) => $row->points, $rows));
    }
}
