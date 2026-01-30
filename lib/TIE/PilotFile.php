<?php

namespace Pyrite\TIE;

class PilotFile extends Base\PilotFileBase
{
    public $filename = "";

    public static function load($file)
    {
        $hex = file_get_contents($file);
        $info = pathinfo($file);
        $plt = new PilotFile($hex);
        $plt->filename = $info['filename'];

        return $plt;
    }

    public static function fromHex($hex, $tie = null)
    {
        return (new PilotFile($hex, $tie))->loadHex();
    }

    public function beforeConstruct()
    {
    }

    public function __toString()
    {
        return "TIE PLT: {$this->filename}";
    }

    public function hasIncompleteBattle()
    {
        $incomplete = array_filter($this->BattleSummary(), function ($summary) {
            return count($summary['missions']) > 0 && !$summary['completed'];
        });
        return count($incomplete) > 0;
    }

    public function BattleSummary()
    {
        $battles = array_chunk($this->BattleScores, 8);
        return array_map(function ($scores, $battleIdx) {
            $statusCode = $this->BattleStatuses[$battleIdx];
            $last = $this->BattleLastMissions[$battleIdx] ?? 0;
            $secret = $this->getByteString($this->SecretObjectives[$battleIdx]);
            $bonus = $this->getByteString($this->SecretObjectives[$battleIdx]);

            $status = Constants::$BATTLESTATUS[$statusCode];

            $scores = array_slice($scores, 0, $last);
            return [
                'completed' => $status === 'Completed',
                'status'    => $status,
                'missions'  => array_map(function ($score, $missionIdx) use ($secret, $bonus) {
                    return [
                        'completed' => true,
                        'score'     => $score,
                        'secret'    => $secret[$missionIdx] === '1',
                        'bonus'     => $bonus[$missionIdx] === '1'
                    ];
                }, $scores, array_keys($scores))
            ];
        }, $battles, array_keys($battles));
    }

    public function getAllMissionScores() {
        $chunks = array_chunk($this->BattleScores, 8);
        $normalisedChunks = array_map(function ($scores, $battleIdx) {
            $status = $this->BattleStatuses[$battleIdx];
            return $status === Constants::$BATTLESTATUS_COMPLETED ? $scores : array_fill(0, 8, 0);
        }, $chunks, array_keys($chunks));
        return array_merge(...$normalisedChunks);
    }

    public function getCompletedMissionScores($campaignMode = false)
    {
        $allBattles = $this->BattleSummary();
        // in campaign mode, we want all scores to be included at a cumulative index position - battle 1 at position 0, battle 2 at position 8, etc
        // (battles have different lengths but in the pilot file they have room for 8 missions each)
        if ($campaignMode) {
            return $this->getAllMissionScores();
        }

        return array_reduce($allBattles, function ($carry, $battleSummary) {
            return array_merge($carry, array_map(function ($mission) {
                return $mission['score'];
            }, $battleSummary['missions']));
        }, []);
    }
}
