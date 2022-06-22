<?php

namespace Pyrite\XvT;

class PilotFile extends Base\PilotFileBase
{
    public static function fromHex($hex, $tie = null)
    {
        return (new PilotFile($hex, $tie))->loadHex();
    }

    public function getCompletedTrainingMissions()
    {
        return array_filter($this->ImperialStats->TrainingMissionData, function (MissionData $mission) {
            return $mission->WinCount > 0;
        });
    }

    public function getCompletedTrainingMissionScores()
    {
        $missions = $this->getCompletedTrainingMissions();
        return array_map(function (MissionData $mission) {
            return $mission->BestScore;
        }, $missions);
    }

    public function getCompletedTrainingMissionTimes()
    {
        $missions = $this->getCompletedTrainingMissions();
        return array_map(function (MissionData $mission) {
            return $mission->BestTime;
        }, $missions);
    }
}
