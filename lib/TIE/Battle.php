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
        // TODO validation that LFD matches mission files etc
        // TODO handle multiple LFD battles
        try {
            $lfds = array_values(array_filter($resourceFiles, fn($f) => str_ends_with(strtolower($f), '.lfd')));
            if (count($lfds) > 0 && file_exists($folder . $lfds[0])) {
                $lfd = new BattleLFD(file_get_contents($folder . $lfds[0]));
                $this->title = $lfd->BattleText->BattleName;
            }
        } catch (\Exception $e) {
            // ignore errors, just don't set the title
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
