<?php

namespace Pyrite\XW;

use Pyrite\EHBL\BattleType;
use Pyrite\EHBL\Platform;

class Battle extends \Pyrite\EHBL\Battle
{
    public function __construct(
        $type = BattleType::UNKNOWN,
        $num = 0,
        $title = '',
        $folder = '',
        array $missionFiles = [],
        array $resourceFiles = []
    ) {
        parent::__construct(Platform::XW, $type, $num, $title, $folder, $missionFiles, $resourceFiles);
    }

    public static function fromFolder(
        $type = BattleType::UNKNOWN,
        $num = 0,
        $folder = '',
        array $lsts = [],
        array $missionFiles = [],
        array $resourceFiles = []
    ) {
        $title = '';

        return new Battle($type, $num, $title, $folder, $missionFiles, $resourceFiles);
    }

    public function goalReport()
    {
        $print = [];

        $lookup = [
            'waistem.xwi' => 'm1', 'max4.xwi' => 'm2', 'satlit1.xwi' => 'm3', 'max5.xwi' => 'm4', 'halley.xwi' => 'm5', 'keyan.xwi' => 'm6', 'ywaistem.xwi' => 'm7', 'ywastem.xwi' => 'm8', 'hello.xwi' => 'm9'
        ];

        foreach ($this->missionFiles as $missionFile) {
            $f = strtolower($missionFile);
            $missionNum = isset($lookup[$f]) ? $lookup[$f] : $f;
            $m = file_get_contents($this->folder . $missionFile);
            $tie = new Mission($m);
            $p = [];
            foreach ($tie->FlightGroups as $fg){
                if ($fg->isGoal()){
                    $p[] = $fg->goalLabel();
                }
            }
            foreach ($tie->ObjectGroups as $og){
                if ($og->isGoal()){
                    $p[] = $og->goalLabel();
                }
            }
            $print[$missionNum] = $p;
        }
        ksort($print);
        return $print;
    }
}