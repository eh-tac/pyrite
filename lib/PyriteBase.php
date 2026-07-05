<?php

namespace Pyrite;

class PyriteBase implements PyriteModel
{
	public function __construct(public string $hex, public ?PyriteModel $TIE) {}

	public function jsonSerialize(): mixed
	{
		return $this->__debugInfo();
	}

	public function __debugInfo(): array
	{
		return [];
	}

	public function __toString(): string
	{
		return get_class($this);
	}

	public function compareHex(string $otherHex): bool
	{
		return $this->hex === $otherHex;
	}

	public function loadHex(): static
	{
		return $this;
	}

	public function toHexString(): string
	{
		return '';
	}

	public function getLength(): int
	{
		return 0;
	}

	protected function beforeConstruct() {}
}
