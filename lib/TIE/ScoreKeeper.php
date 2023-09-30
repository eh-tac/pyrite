<?php

namespace Pyrite\TIE;

use Pyrite\ScoreRow;

class ScoreKeeper
{
    private $TIE;

    private $playerCraft = null;
    private $globalGoals = array();
    private $fgGoals = array();
    private $fgs = array();
    private $goalTypes = array('Primary' => array(), 'Secondary' => array(), 'Bonus' => array());
    private $goalPoints = array('Hard' => 7750, 'Medium' => 5000, 'Easy' => 2250);
    private $badBonus = false;
    private $invincible = array();
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
        $this->process();
    }

    public function process()
    {
        foreach (['Primary', 'Secondary', 'Bonus'] as $idx => $type) {
            $gg = $this->TIE->GlobalGoals[$idx];
            if ($gg instanceof GlobalGoal && $gg->hasData()) {
                $this->goalTypes[$type][] = (string) $gg;
            }
        }

        foreach ($this->TIE->FlightGroups as $idx => $fg) {
            if (!$fg->isInDifficultyLevel($this->difficultyFilter)) {
                continue;
            }

            $name = (string) $fg;
            $points = $fg->pointValue($this->difficultyFilter);

            if ($points > 0) {
                if ($fg->capturable()) {
                    if (count($fg) == 1) {
                        $points *= 5;
                        $name .= ' capturable ';
                    } else {
                        $count = $fg->captureCount();
                        $points += $count * $points / count($fg) * 4;
                        $name .= ", $count capturable";
                    }
                } elseif (!$fg->destroyable()) {
                    $points = 0;
                }
                if ($points) {
                    $this->total += $points;
                    $this->fgs[] = $name . ': ' . $points;
                    $this->flightGroups[] = ScoreRow::create((string)$fg, count($fg), $points);
                }
            }

            if ($fg->invincible()) {
                $this->invincible[] = (string)$fg;
            }

            $goalIndex = ['Primary' => 0, 'Secondary' => 1, 'Secret' => 2, 'Bonus' => 3];

            foreach ($this->goalTypes as $type => &$goals) {
                $idx = $goalIndex[$type];
                $goal = $fg->FlightGroupGoals[$idx];
                if ($goal->hasData()) {
                    $label = "$fg must be $goal";
                    if ($type === 'Bonus' && $fg->getBonusPoints()) {
                        $label .= " ({$fg->getBonusPoints()} pts)";
                        $pts = (int)$fg->getBonusPoints();
                        if ($pts < 0) {
                            $this->badBonus = true;
                        } else {
                            $this->total += $pts;
                        }
                    }
                    $goals[] = $label;
                }
            }

            if ($fg->isPlayerCraft()) {
                $this->playerCraft = $fg;
                $this->craftOptions = [ScoreRow::create("Player craft: $fg", 1, 0)];
            }
        }

        $goalPoints = $this->goalPoints[$this->difficultyFilter];
        if (count($this->goalTypes['Primary'])) {
            $this->goals[] = ScoreRow::create("Primary goals: ", 1, $goalPoints);
        }
        if (count($this->goalTypes['Secondary'])) {
            $this->goals[] = ScoreRow::create("Secondary goals: ", 1, $goalPoints);
        }
        if (count($this->goalTypes['Bonus'])) {
            $this->goals[] = ScoreRow::create("All Bonus goals: ", 1, 3100);
        }
    }

    public function bonus()
    {
        return $this->goalTypes['Bonus'];
    }

    public function printDump()
    {
        $goalPoints = $this->goalPoints[$this->difficultyFilter];
        if (count($this->goalTypes['Primary'])) {
            $this->total += $goalPoints;
            $goals[] = "Primary goals: $goalPoints pts";
        } else {
            unset($this->goalTypes['Primary']);
        }
        if (count($this->goalTypes['Secondary'])) {
            $this->total += $goalPoints;
            $goals[] = "Secondary goals: $goalPoints pts";
        } else {
            unset($this->goalTypes['Secondary']);
        }
        if ($c = count($this->goalTypes['Bonus'])) {
            $this->total += 3100;
            if ($this->badBonus) {
                $goals[] = 'Some bonus goals have negative points and should not be completed';
                $goals[] = "All positive bonus goals: 3100 pts";
            } else {
                $goals[] = "All $c bonus goals: 3100 pts";
            }
        } else {
            unset($this->goalTypes['Bonus']);
        }
        $craft = array((string) $this->playerCraft);
        if ($this->playerCraft) {
            $warheadPts = $this->playerCraft->maxWarheads() * 50;
            $this->total += $warheadPts;
            $craft[] = 'Maximum warhead points: ' . $warheadPts . ' pts';
            $this->player = (string) $this->playerCraft;
            $this->warhead = $this->playerCraft->general['Warheads'];
        } else {
            $craft[] = 'Player craft not found';
        }

        //        return array('Difficulty' => $this->difficultyFilter, 'Points' => array_merge($this->fgs, $goals, $craft, array('Total score: ' . $this->total . ' pts')), 'Goals' => $this->goalTypes);
        return array(
            'Difficulty' => $this->difficultyFilter,
            'Enemies' => $this->fgs,
            'Invincible' => $this->invincible,
            'Player Craft' => $craft,
            'Goals' => array_merge($goals, $this->goalTypes),
            //            'FGGoals' => $this->fgGoals,
            'Total Potential Score' => $this->total . ' pts'
        );
    }

    public function getData()
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

    public function getTotal()
    {
        $rows = array_filter($this->getData(), fn ($row) => $row->number > 0);
        return array_sum(array_map(fn ($row) => $row->points, $rows));
    }
}
