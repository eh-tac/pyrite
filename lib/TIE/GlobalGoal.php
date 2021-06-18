<?php

namespace Pyrite\TIE;

use Pyrite\Summary;

class GlobalGoal extends Base\GlobalGoalBase implements Summary
{
	public function summaryHash()
	{
		$triggas = [];
		/** @var Trigger $trig */
		foreach ($this->Triggers as $n => $trig) {
			$trig->TIE = $this->TIE;
			if ($trig->Condition === 10 || ($n === 1 && $trig->Condition === 0)) {
				continue;
			}
			$triggas[] = (string)$trig;
		}
		if (count($triggas) === 0) {
			return false;
		}

		$glue = $this->Trigger1OrTrigger2 ? 'OR' : 'AND';

		return [
			'Triggers' => implode("<br />$glue<br />", $triggas),
		];
	}

	public function __toString()
	{
		$strings = array_map(function ($t) {
			return (string)$t;
		}, array_filter($this->Triggers, function ($t) {
			return $t->hasData();
		}));
		return implode($this->Trigger1OrTrigger2 ? 'OR' : 'AND', $strings);
	}

	public function hasData()
	{
		foreach ($this->Triggers as $trig) {
			if ($trig->hasData()) {
				return TRUE;
			}
		}
		return FALSE;
	}
}
