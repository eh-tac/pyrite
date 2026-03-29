<?php

namespace Pyrite\XvT;

interface IPilotFileBSF
{
    public static function fromHex($hex, $tie = null);
    public function getCompletedMissions($isCampaign = false);
    public function getCompletedMissionScores($isCampaign = false);
    public function getCompletedMissionTimes($isCampaign = false);
    public function getLasersFired();
    public function getLasersHit();
    public function getWarheadsFired();
    public function getWarheadsHit();
    public function getKills();
}
