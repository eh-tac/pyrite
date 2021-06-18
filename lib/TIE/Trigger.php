<?php

namespace Pyrite\TIE;

class Trigger extends Base\TriggerBase
{
	public function __toString()
	{
		if ($this->Condition === 0) {
			return 'Always';
		}
		$parts = [$this->getTriggerAmountLabel(), 'of', $this->getVariableTypeLabel()];

		if ($this->VariableType === 1) {
			$fg      = $this->TIE->FlightGroups[$this->Variable];
			$parts[] = (string)$fg;
		} else if ($this->VariableType === 2) {
			// ship type
		} else if ($this->VariableType === 3) {
			// craft category
		} else if ($this->VariableType === 4) {
			// object category
		} else if ($this->VariableType === 5) {
			// iff
			$iff = $this->TIE->lookupIFF($this->Variable);
			$parts[] = $iff;
		} else if ($this->VariableType === 6) {
			// order
		} else if ($this->VariableType === 7) {
			// craft when
		} else if ($this->VariableType === 8) {
			// global group
		}
		$parts[] = 'must';
		$parts[] = $this->getConditionLabel();
		return implode(' ', $parts);
	}

	public function hasData()
	{
		return $this->Condition !== 0 && $this->Condition !== 10; // not always or none
	}
}
