<?php

namespace Pyrite\XWA;

use Pyrite\EHBL\BattleType;
use Pyrite\EHBL\Platform;

class Battle extends \Pyrite\EHBL\Battle
{
	public function __construct(BattleType $type = BattleType::UNKNOWN, int $num = 0, string $folder = '', array $missionFiles = [], array $resourceFiles = [])
	{
		parent::__construct(Platform::XWA, $type, $num, '', $folder, $missionFiles, $resourceFiles);
		// try to get the title from the mission lst if we can find it
		if (count($resourceFiles) > 0 && file_exists($folder . $resourceFiles[0])) {
			$missionLst = file_get_contents($folder . $resourceFiles[0]);

			if (preg_match('/BATTLE_8_HEADER!\[(.*)\]/m', $missionLst, $m)) {
				$this->title = str_replace("Battle 8:", "", $m[1]);
			}
		}
	}
}
