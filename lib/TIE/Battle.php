<?php

namespace Pyrite\TIE;

use Pyrite\EHBL\BattleType;
use Pyrite\EHBL\Platform;
use Pyrite\LFD\BattleLFD;

class Battle extends \Pyrite\EHBL\Battle {
	public function __construct($type = BattleType::UNKNOWN, $num = 0, $title = '', $folder = '', array $missionFiles = [], array $resourceFiles = []) {
		parent::__construct(Platform::TIE, $type, $num, $title, $folder, $missionFiles, $resourceFiles);
	}

	public static function fromFolder($type = BattleType::UNKNOWN, $num = 0, $folder = '', array $lfds = [], array $missionFiles = [], array $resourceFiles = []) {
		// TODO validation that LFDs has items
		// TOTO validation that LFD matches mission files etc
		// TODO handle multiple LFD battles
		$lfd = new BattleLFD(file_get_contents($folder . reset($lfds)));
		return new Battle($type, $num, $lfd->BattleText->BattleName, $folder, $missionFiles, $resourceFiles);
	}

    /**
     * @param Battle $zipBattle
     * @return array
     */
    public function validate($zipB){
	    $errors = parent::validate($zipB);

        foreach ($this->missionFiles as $mission) {
            if (strlen($mission) > 12) {
                $errors[] = "has filename $mission which might not work in TIECD due to length";
            }
        }

	    return $errors;
    }

    public function validateMission($missionFile, &$errors){
        $m = file_get_contents($this->folder . $missionFile);
        $tie = new Mission($m);
        $me = $tie->validate();
        if (count($me)){
            $me[] = $this->folder . $missionFile;
            $errors[$missionFile] = $me;
        }
    }
}