<?php

namespace Pyrite\XvT;

use Pyrite\IScoreKeeper;
use Pyrite\ScoreRow;

class ScoreKeeper implements IScoreKeeper
{
    /** @var Mission */
    private $TIE;
    public $lstData;
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

        $flightGroups = array_filter($this->TIE->FlightGroups, fn($fg) => $fg->isInDifficultyLevel($this->difficultyFilter));
        $playerCraft = array_filter($flightGroups, fn($fg) => $fg->isPlayerCraft());

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
                // if ($type === 'Prevent') {
                //     $goal->label .= '(PREVENT??)';
                //     $goal->disable();
                // }
            }
        }

        foreach ($flightGroups as $fg) {
            $pointValue = $fg->killPointValue($this->difficultyFilter);
            if ($pointValue > 0) {
                $this->flightGroups[] = ScoreRow::create((string) $fg, count($fg), $pointValue);
            }

            /** @var GoalFG $goal */
            foreach ($fg->Goals as $goal) {
                if (!$goal->hasConditionSet()){
                    continue;
                }
                if (($goal->getPoints() > 0 || $goal->isBonus()) && $goal->enabledForTeam1()) {
                    $this->goals[] = $row = ScoreRow::create("$fg - $goal", 1, $goal->getPoints());
                    if ($goal->isBonus()) {
                        $hasBonusGoals = TRUE;
                    }
                    if ($row->points < 0) {
                        $row->label .= ' (NEGATIVE POINTS)';
                        $row->disable();
                    }
                }
            }
        }

        if ($hasBonusGoals) {
            $this->goals[] = ScoreRow::create("All bonus goals", 1, 2500);
        }

        $this->handlePlayerCraft($playerCraft);
    }

    /**
     * 
     * @param FlightGroup[] $playerCraft 
     * @return void 
     */
    private function handlePlayerCraft($playerCraft)
    {
        // [$fg, total points, first wave, unused waves]

        $options = [];
        foreach ($playerCraft as $fg) {
            // foreach ($fg->getWaveOptions() as $wave) {
            //     $this->craftOptions[] = ScoreRow::create("Wave option {$wave['label']} hangar/hyper points", 1, $wave['maxPoints']);
            // }

            // if there are multiple waves, you get double points when they are unused
            $unusedWave = 0;

            $craftPoints = $fg->getCraftPoints();
            $firstWaveCount = $fg->NumberOfCraft;

            if ($fg->hasMultipleWaves()) {
                $firstWaveCount--;
                $unusedWave = 2 * $craftPoints * $fg->NumberOfCraft * $fg->NumberOfWaves;
            }
            $firstWave = $firstWaveCount * $craftPoints;
            $options[] = [
                'fg' => $fg,
                'total' => $firstWave + $unusedWave,
                'first' => $firstWave,
                'firstCount' => $firstWaveCount,
                'unusedWave' => $unusedWave
            ];
        }
        usort($options, fn($a, $b) => $b['total'] - $a['total']);

        $disableIndex = 1;
        foreach ($options as $o => $option) {
            $fg = $option['fg'];

            $this->craftOptions[] = ScoreRow::create("$fg hangar/hyper points", $option['firstCount'], $option['first']);
            if ($option['unusedWave'] > 0) {
                if ($o === 0) $disableIndex = 2;
                $this->craftOptions[] = ScoreRow::create("$fg unused wave points", 1, $option['unusedWave']);
            }
        }

        for ($i = $disableIndex; $i < count($this->craftOptions); $i++) {
            $this->craftOptions[$i]->disable();
        }
    }

    public function getData(): array
    {
        return array_merge(
            $this->lstData ? [
                ScoreRow::header("imperial.lst data"),
                new ScoreRow($this->lstData['title'], 1, 0),
                new ScoreRow($this->lstData['filename'], 1, 0),
                new ScoreRow("Mission Index: " . $this->lstData['index'], 1, 0),
                
                
            ] : [], 
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
        $rows = array_filter($this->getData(), fn($row) => $row->number > 0);
        return array_sum(array_map(fn($row) => $row->points, $rows));
    }
}
