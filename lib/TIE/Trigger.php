<?php

namespace Pyrite\TIE;

class Trigger extends Base\TriggerBase
{
	public Mission $mission;

	public function __construct(string $hex = null, ?\Pyrite\PyriteModel $TIE = null)
	{
		parent::__construct($hex, $TIE);
		if ($TIE instanceof Mission) {
			$this->mission = $TIE;
		}
	}

	public function __toString()
	{
		if ($this->Condition === 0) {
			return 'Always';
		}
		$parts = [$this->getTriggerAmountLabel(), 'of', $this->getVariableTypeLabel()];

		if ($this->VariableType === 1) {
			$fg      = $this->mission->FlightGroups[$this->Variable];
			$parts[] = (string)$fg;
		} else if ($this->VariableType === 2) {
			// ship type
		} else if ($this->VariableType === 3) {
			// craft category
		} else if ($this->VariableType === 4) {
			// object category
		} else if ($this->VariableType === 5) {
			// iff
			$iff = $this->mission->lookupIFF($this->Variable);
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
