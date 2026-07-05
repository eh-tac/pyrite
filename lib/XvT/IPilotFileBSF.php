<?php

namespace Pyrite\XvT;

interface IPilotFileBSF
{
    public static function fromHex(string $hex, ?\Pyrite\PyriteModel $TIE = null);
    public function getCompletedMissions(bool $isCampaign = false);
    public function getCompletedMissionScores(bool $isCampaign = false);
    public function getCompletedMissionTimes(bool $isCampaign = false);
    public function getLasersFired();
    public function getLasersHit();
    public function getWarheadsFired();
    public function getWarheadsHit();
    public function getKills();
}
