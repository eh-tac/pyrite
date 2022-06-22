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

    public function getCompletedMissionScores()
    {
        return array_reduce($this->BattleSummary(), function ($carry, $battleSummary) {
            return array_merge($carry, array_map(function ($mission) {
                return $mission['score'];
            }, $battleSummary['missions']));
        }, []);
    }
}
