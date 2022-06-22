<?php

namespace Pyrite;

class PyriteBase implements \JsonSerializable
{
	public $TIE;
	public $diffLimit = FALSE;

	public $hex;

	public function __construct($hex, $tie)
	{
		$this->hex = $hex;
		$this->TIE = $tie;
	}

	public function jsonSerialize()
	{
		return $this->__debugInfo();
	}

	public function __debugInfo()
	{
	}

	public function compareHex($otherHex)
	{
		return $this->hex === $otherHex;
	}

	public function loadHex()
	{
		return $this;
	}

	protected function beforeConstruct()
	{
	}
}
