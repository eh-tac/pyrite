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

    public function getTotalKills()
    {
        return array_sum($this->TODKills);
    }
}
