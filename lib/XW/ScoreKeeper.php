<?php

namespace Pyrite\XW;

use Pyrite\ScoreRow;

class ScoreKeeper
{
    /** @var Mission */
    private $TIE;

    private $playerCraft = null;
    private $fgs = array();
    private $victoryPoints = 1500;
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

    public function __construct(Mission $TIE)
    {
        $this->TIE = $TIE;
        $this->process();
    }

    public function process()
    {
        $this->goals = [
            ScoreRow::create("Mission Victory", 1, $this->victoryPoints)
        ];
        foreach ($this->TIE->FlightGroups as $idx => $fg) {
            $name = (string)$fg;
            $points = $fg->pointValue($this->difficultyFilter);

            if ($points > 0) {
                if (!$fg->destroyable()) {
                    $points = 0;
                    $name .= ' invincible or mission critical ';
                }
                $this->total += $points;
                $this->fgs[] = $name . ': ' . $points;
                $this->flightGroups[] = ScoreRow::create((string)$fg, count($fg), $points);
                //                $this->fgs[] = $fg;
            }

            if ($fg->invincible()) {
                $this->invincible[] = 'Invincible: ' . $fg;
            }

            if ($fg->getObjectiveLabel() !== 'None') {
                $this->goals[] = ScoreRow::create('Flight Group ' . $fg . ' must be ' . $fg->getObjectiveLabel(), 1, 0);
            }

            if ($fg->isPlayerCraft()) {
                $this->playerCraft = $fg;
                $this->craftOptions = [
                    ScoreRow::create("Player craft: $fg", 1, 0)
                ];
            }
        }
    }

    public function printDump()
    {
        $goalPoints = $this->victoryPoints;
        $this->total += $goalPoints; //primary goals

        $craft = array('Player craft: ' . (string)$this->playerCraft);
        if ($this->playerCraft) {
            $warheadPts = $this->playerCraft->maxWarheads() * 50;
            $this->total += $warheadPts;
            $craft[] = 'Maximum warhead points: ' . $warheadPts . ' pts';
        } else {
            $craft[] = 'Player craft not found';
        }

        return array(
            'Points' => array_merge($this->fgs, $craft, array('Victory: 1500 pts', 'Total score: ' . $this->total . ' pts')),
            'Goals' => $this->goals
        );
    }

    public function getData(): array
    {
        return array_merge(
            [ScoreRow::header("Flight Groups")],
            $this->flightGroups,
            [ScoreRow::header("Goals")],
            $this->goals,
            [ScoreRow::header("Craft Options")],
            $this->craftOptions
        );
    }

    public function getTotal(): int
    {
        $rows = array_filter($this->getData(), fn ($row) => $row->number > 0);
        return array_sum(array_map(fn ($row) => $row->points, $rows));
    }
}
