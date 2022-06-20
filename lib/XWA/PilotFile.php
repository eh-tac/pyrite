<?php

namespace Pyrite\XWA;

class PilotFile extends Base\PilotFileBase
{

    public function getCompletedMissionScores($resetNumbering = true)
    {
        $missions = $this->getCompletedMissions();
        if ($resetNumbering) {
            $missions = array_values($missions);
        }
        return array_map(function (MissionData $mission) {
            return $mission->getTotal();
        }, $missions);
    }

    public function getCompletedMissionTimes($resetNumbering = true)
    {
        $missions = $this->getCompletedMissions();
        if ($resetNumbering) {
            $missions = array_values($missions);
        }
        return array_map(function (MissionData $mission) {
            return $mission->Time;
        }, $missions);
    }

    public function getCompletedMissions()
    {
        return array_filter($this->MissionData, function (MissionData $mission) {
            return $mission->WinCount > 0 && $mission->AttemptCount > 0;
        });
    }

    public function getTotalKills()
    {
        return array_sum($this->TourOfDutyKills);
    }

    public function getCurrentMissionID()
    {
        $win = 1;
        $i = -1;
        while ($win) {
            $i++;
            $win = $this->MissionData[$i]->WinCount;
        }
        return $i;
    }

    public function setUpForMissionID($id)
    {
        for ($i = 0; $i < $id; $i++) {
            $this->MissionData[$i]->empty()->skip();
        }
        for ($i = $id; $i < count($this->MissionData); $i++) {
            $this->MissionData[$i]->empty();
        }
    }
}
