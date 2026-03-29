<?php

namespace Pyrite\XvT;

class PL2FileRecord extends Base\PL2FileRecordBase implements IPilotFileBSF
{
  public function getCompletedMissions($isCampaign = false)
  {
    if (!$isCampaign) {
      return []; // PL2 files are only used for campaign submissions
    }
    // the first 15 we want are offsets 51-65 in the imperial faction's campaign record
    $imperial = array_slice($this->getImperialFaction()->missionSPCampaign, 51, 15);
    // the next 15 we want are offsets 71-85 in the rebel faction's campaign record
    $rebel = array_slice($this->getRebelFaction()->missionSPCampaign, 71, 15);
    $combined = array_merge($imperial, $rebel);
    return array_filter($combined, function (PL2CampaignRecord $mission) {
      return $mission->isMissionComplete === 1;
    });
  }

  public function getRebelFaction()
  {
    return $this->faction[0];
  }

  public function getImperialFaction()
  {
    return $this->faction[1];
  }

  public function getCompletedMissionScores($isCampaign = false)
  {
    return array_map(function (PL2CampaignRecord $mission) {
      return $mission->bestScore;
    }, $this->getCompletedMissions($isCampaign));
  }

  public function getCompletedMissionTimes($isCampaign = false)
  {
    return array_map(function (PL2CampaignRecord $mission) {
      return $mission->bestTimeAsSeconds;
    }, $this->getCompletedMissions($isCampaign));
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
    return (new PL2FileRecord($hex, $tie))->loadHex();
  }
}
