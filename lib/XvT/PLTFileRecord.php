<?php

namespace Pyrite\XvT;

class PLTFileRecord extends Base\PLTFileRecordBase implements IPilotFileBSF
{
  public function getCompletedMissions($isCampaign = false)
  {
    return array_filter($this->imperialSingleplayerData->missionSPExercise, function (PLTMissionSPRecord $mission) {
      return $mission->totalCountVictory > 0;
    });
  }

  public function getCompletedMissionScores($isCampaign = false)
  {
    $missions = $this->getCompletedMissions($isCampaign);
    return array_map(function (PLTMissionSPRecord $mission) {
      return $mission->bestScore;
    }, $missions);
  }

  public function getCompletedMissionTimes($isCampaign = false)
  {
    $missions = $this->getCompletedMissions($isCampaign);
    return array_map(function (PLTMissionSPRecord $mission) {
      return $mission->bestTimeAsSeconds;
    }, $missions);
  }

  public function getLasersFired()
  {
    return $this->totalLaserFired->exercise;
  }

  public function getLasersHit()
  {
    return $this->totalLaserHit->exercise;
  }

  public function getWarheadsFired()
  {
    return $this->totalWarheadFired->exercise;
  }

  public function getWarheadsHit()
  {
    return $this->totalWarheadHit->exercise;
  }

  public function getKills()
  {
    return $this->totalKillCount->exercise;
  }

  public static function fromHex($hex, $tie = null)
  {
    return (new PLTFileRecord($hex, $tie))->loadHex();
  }
}
