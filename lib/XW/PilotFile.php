<?php

namespace Pyrite\XW;

class PilotFile extends Base\PilotFileBase
{

    public function beforeConstruct()
    {
    }

    public function __toString()
    {
        return '';
    }

    public static function fromHex($hex, $tie = null)
    {
        return (new PilotFile($hex, $tie))->loadHex();
    }

    public function getCompletedTrainingMissionScores()
    {
        $scores = array_merge($this->XWingHistoricalScore, $this->YWingHistoricalScore, $this->AWingHistoricalScore);
        $compls = array_merge(
            $this->XWingHistoricalComplete,
            $this->YWingHistoricalComplete,
            $this->AWingHistoricalComplete
        );

        $missions = [];
        foreach ($compls as $i => $complete) {
            if ($complete) {
                $missions[] = $scores[$i];
            }
        }
        return $missions;
    }

    public function getCompletedTourMissionScores()
    {
        $scores = [$this->Tour1Scores, $this->Tour2Scores, $this->Tour3Scores, $this->getTour4Scores(), $this->getTour5Scores()];

        $missions = [];
        foreach ($this->TourOperationsComplete as $i => $tourCompleteCount) {
            $missions = array_merge($missions, array_slice($scores[$i], 0, $tourCompleteCount));
        }
        return $missions;
    }

    // To get the 20 mission scores from the 24 number array, handle the optional missions
    // Tour 4 has optional missions 6, 8, 12, and 16. For these, only the higher of the two scores is counted.
    public function getTour4Scores(){
        $optionalMissions = [6, 8, 12, 16];
        $scores = [];
        $index = 0;
        for ($m = 1; $m <= 20; $m++) {
            if (in_array($m, $optionalMissions)) {
                // this is an optional mission, so we include the highest of the next two scores (one should be 0)
                $scores[] = max($this->Tour4Scores[$index], $this->Tour4Scores[$index + 1]);
                $index += 2;
            } else {
                $scores[] = $this->Tour4Scores[$index];
                $index++;
            }
        }
        return $scores;
    }

    // Tour 5 has optional missions 11, 14, 17, and 20. For these, only the higher of the two scores is counted.
    public function getTour5Scores(){
        // 11 14 17 20
        $optionalMissions = [11, 14, 17, 20];
        $scores = [];
        $index = 0;
        for ($m = 1; $m <= 20; $m++) {
            if (in_array($m, $optionalMissions)) {
                // this is an optional mission, so we include the highest of the next two scores (one should be 0)
                $scores[] = max($this->Tour5Scores[$index], $this->Tour5Scores[$index + 1]);
                $index += 2;
            } else {
                $scores[] = $this->Tour5Scores[$index];
                $index++;
            }
        }
        return $scores;
    }

    // get the scores for all tour missions in this pilot file.
    // in order to allow processing with offsets, we include each tour but fill in 0s if incomplete
    public function getAllTourMissionScores(){
        return array_merge(
            $this->TourOperationsComplete[0] == 12 ? $this->Tour1Scores : array_fill(0, 12, 0), 
            $this->TourOperationsComplete[1] == 12 ? $this->Tour2Scores : array_fill(0, 12, 0),
            $this->TourOperationsComplete[2] == 14 ? $this->Tour3Scores : array_fill(0, 14, 0),
            $this->TourOperationsComplete[3] == 20 ? $this->getTour4Scores() : array_fill(0, 20, 0),
            $this->TourOperationsComplete[4] == 20 ? $this->getTour5Scores() : array_fill(0, 20, 0)
        );
    }

    /**
     * get the scores for all completed missions in this pilot file.
     * For BSF processing, we're getting a flat list of all training missions and all tour missions that are marked as completed.
     */
    public function getCompletedMissionScores($campaignMode = false)
    {
        if ($campaignMode) {
            return $this->getAllTourMissionScores();
        }
        
        return array_merge(
            $this->getCompletedTrainingMissionScores(),
            $this->getCompletedTourMissionScores()
        );
    }

    public function getTotalKills()
    {
        return array_sum($this->TODKills);
    }
}
