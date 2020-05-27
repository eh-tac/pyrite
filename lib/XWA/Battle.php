<?php

namespace Pyrite\XWA;

use Pyrite\EHBL\BattleType;
use Pyrite\EHBL\Platform;

class Battle extends \Pyrite\EHBL\Battle {
	public function __construct($type = BattleType::UNKNOWN, $num = 0, $title = '', $folder = '', array $missionFiles = [], array $resourceFiles = []) {
		parent::__construct(Platform::XWA, $type, $num, $title, $folder, $missionFiles, $resourceFiles);
	}

	public static function fromFolder($type = BattleType::UNKNOWN, $num = 0, $folder = '', array $lsts = [], array $missionFiles = [], array $resourceFiles = []) {
		$missionLst = file_get_contents($folder . $lsts[0]);
		$title      = '';
		if (preg_match('/BATTLE_8_HEADER!\[(.*)\]/m', $missionLst, $m)) {
			$title = $m[1];
		}

		return new Battle($type, $num, $title, $folder, $missionFiles, $resourceFiles);
	}
}