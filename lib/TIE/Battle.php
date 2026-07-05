<?php

namespace Pyrite\TIE;

use Pyrite\EHBL\BattleType;
use Pyrite\EHBL\Platform;
use Pyrite\LFD\BattleLFD;

class Battle extends \Pyrite\EHBL\Battle
{
    public function __construct(BattleType $type = BattleType::UNKNOWN, int $num = 0, string $folder = '', array $missionFiles = [], array $resourceFiles = [])
    {
        parent::__construct(Platform::TIE, $type, $num, '', $folder, $missionFiles, $resourceFiles);
        // try to get the title from the battle lfd if we can find it
        // TODO validation that LFDs has items
        // TOTO validation that LFD matches mission files etc
        // TODO handle multiple LFD battles
        if (count($resourceFiles) > 0 && file_exists($folder . $resourceFiles[0])) {
            $lfd = new BattleLFD(file_get_contents($folder . $resourceFiles[0]));

            $this->title = $lfd->BattleText->BattleName;
        }
    }

    public function validate(\Pyrite\EHBL\Battle $zipB): array
    {
        $errors = parent::validate($zipB);

        foreach ($this->missionFiles as $mission) {
            if (strlen($mission) > 12) {
                $errors[] = "has filename $mission which might not work in TIECD due to length";
            }
        }

        return $errors;
    }

    public function validateMission(string $missionFile, array &$errors)
    {
        $m = file_get_contents($this->folder . $missionFile);
        $tie = new Mission($m);
        $me = $tie->validate();
        if (count($me)) {
            $me[] = $this->folder . $missionFile;
            $errors[$missionFile] = $me;
        }
    }
}
