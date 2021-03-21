<?php

namespace Pyrite\XWA;

class PilotFile extends Base\PilotFileBase
{

    public function getCompletedMissionScores()
    {
        $missions = $this->getCompletedMissions();
        return array_map(function (MissionData $mission) {
            return $mission->Score + $mission->BonusScoreTen / 10;
        }, array_values($missions));
    }

    public function getCompletedMissionTimes()
    {
        $missions = $this->getCompletedMissions();
        return array_map(function (MissionData $mission) {
            return $mission->Time;
        }, array_values($missions));
    }

    public function getCompletedMissions()
    {
        return array_filter($this->MissionData, function (MissionData $mission) {
            return $mission->WinCount > 0 && $mission->AttemptCount > 0;
        });
    }


}
