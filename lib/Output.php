<?php

namespace Pyrite;

interface Output
{
	/** @return string hex encoder for this object */
	public function toHex(): string;
}
