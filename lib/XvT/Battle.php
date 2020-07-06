<?php

namespace Pyrite\XvT;

use Pyrite\EHBL\BattleType;
use Pyrite\EHBL\Platform;

class Battle extends \Pyrite\EHBL\Battle {
	public function __construct($type = BattleType::UNKNOWN, $num = 0, $title = '', $folder = '', array $missionFiles = [], array $resourceFiles = []) {
		parent::__construct(Platform::XvT, $type, $num, $title, $folder, $missionFiles, $resourceFiles);
	}

	public static function fromFolder($type = BattleType::UNKNOWN, $num = 0, $folder = '', array $lsts = [], array $missionFiles = [], array $resourceFiles = []) {
		$missionLst = file_get_contents($folder . $lsts[0]);
		$bits = explode("\n", $missionLst);
		$title = str_replace(["[", "]"], "", $bits[1]);

		return new Battle($type, $num, $title, $folder, $missionFiles, $resourceFiles);
	}
}