<?php

namespace Pyrite\XvT;

use Pyrite\EHBL\BattleType;
use Pyrite\EHBL\Platform;
use Pyrite\PyriteModel;

class Battle extends \Pyrite\EHBL\Battle
{
	public ?MissionLst $missionLst;

	public function __construct(BattleType $type = BattleType::UNKNOWN, int $num = 0, string $folder = '', array $missionFiles = [], array $resourceFiles = [])
	{
		parent::__construct(Platform::XvT, $type, $num, '', $folder, $missionFiles, $resourceFiles);

		// try to load the mission list and get the title / sort the missions
		$missionLst = "";
		if (count($resourceFiles) > 0 && file_exists($folder . $resourceFiles[0])) {
			$missionLst = file_get_contents($folder . $resourceFiles[0]);

			$bits = explode("\n", $missionLst);
			$this->title = str_replace(["[", "]"], "", $bits[1]);

			$this->missionLst = MissionLst::fromString($missionLst);
			$this->sortMissions();
		}
	}

	protected function sortMissions()
	{
		if ($this->missionLst) {
			usort($this->missionFiles, fn($a, $b) =>  $this->missionLst->getMissionIndexForFile($a) <=> $this->missionLst->getMissionIndexForFile($b));
		}
	}

	protected function loadScoreKeeper(?PyriteModel $TIE, string $filename)
	{
		if (!$TIE instanceof Mission) {
			throw new \Exception("Must provide XvT Mission to load XvT ScoreKeeper");
		}
		$sk = new \Pyrite\XvT\ScoreKeeper($TIE);
		if ($this->missionLst) {
			foreach ($this->missionLst->entries as $entry) {
				if (strtolower(trim($entry['filename'])) === strtolower(trim($filename))) {
					$sk->lstData = $entry;
				}
			}
		}
		return $sk;
	}
}
