<?php

namespace Pyrite\XvT;

use Pyrite\EHBL\BattleType;
use Pyrite\EHBL\Platform;

class Battle extends \Pyrite\EHBL\Battle
{
	public $missionLst;

	public function __construct($type = BattleType::UNKNOWN, $num = 0, $title = '', $folder = '', array $missionFiles = [], array $resourceFiles = [])
	{
		parent::__construct(Platform::XvT, $type, $num, $title, $folder, $missionFiles, $resourceFiles);
	}

	public static function fromFolder($type = BattleType::UNKNOWN, $num = 0, $folder = '', array $lsts = [], array $missionFiles = [], array $resourceFiles = [])
	{
		$missionLst = file_get_contents($folder . $lsts[0]);
		$bits = explode("\n", $missionLst);
		$title = str_replace(["[", "]"], "", $bits[1]);

		$b = new Battle($type, $num, $title, $folder, $missionFiles, $resourceFiles);
		$b->missionLst = MissionLst::fromString($missionLst);
		$b->sortMissions();
		return $b;
	}

	protected function sortMissions(){
		usort($this->missionFiles, fn($a, $b) =>  $this->missionLst->getMissionIndexForFile($a) <=> $this->missionLst->getMissionIndexForFile($b));
	}

	protected function loadScoreKeeper($tie, $filename)
	{
		$sk = new \Pyrite\XvT\ScoreKeeper($tie);
		foreach ($this->missionLst->entries as $entry) {
			if (strtolower(trim($entry['filename'])) === strtolower(trim($filename))) {
				$sk->lstData = $entry;
			}
		}	
		return $sk;
	}


}
