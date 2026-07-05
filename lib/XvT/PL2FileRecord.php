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

  public function hasValidCampaignData()
  {
    $imperial = array_slice($this->getImperialFaction()->missionSPCampaign, 51, 15);
    $imperialSum = array_sum(array_map(static function (PL2CampaignRecord $mission) {
      return $mission->bestScore;
    }, $imperial));

    $imperialStateBest = max(array_map(fn($c) => $c->bestScore, $this->getImperialFaction()->statusSPCampaign));

    if ($imperialSum !== $imperialStateBest) {
      return false;
    }

    $rebel = array_slice($this->getRebelFaction()->missionSPCampaign, 71, 15);
    $rebelSum = array_sum(array_map(static function (PL2CampaignRecord $mission) {
      return $mission->bestScore;
    }, $rebel));

    $rebelStateBest = max(array_map(fn($c) => $c->bestScore, $this->getRebelFaction()->statusSPCampaign));

    if ($rebelSum !== $rebelStateBest) {
      return false;
    }


    return true;
  }

  public function getCompletedMissionScores($isCampaign = false)
  {
    return array_map(function (PL2CampaignRecord $mission) {
      return $mission->bestScore;
    }, $this->getCompletedMissions($isCampaign));
  }

  public function getCampaignTotalScore()
  {
    return array_sum($this->getCompletedMissionScores(true));
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

  public static function fromHex(string $hex, ?\Pyrite\PyriteModel $TIE = null): PL2FileRecord
  {
    return (new PL2FileRecord($hex, $TIE))->loadHex();
  }
}
