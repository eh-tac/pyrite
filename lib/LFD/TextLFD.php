<?php

namespace Pyrite\LFD;

use Pyrite\Byteable;
use Pyrite\PyriteModel;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;

class TextLFD extends LFD
{
	public int $NumberOfStrings; // number of missions + 4
	/** @var array<LFDString> */
	public array $Strings = [];

	public function __construct(public string $hex, public ?PyriteModel $TIE = NULL)
	{
		parent::__construct($hex, $TIE);
		$this->NumberOfStrings = $this->getShort($hex, 0x10);
		$off                   = 0x12;
		for ($i = 0; $i < $this->NumberOfStrings; $i++) {
			$str             = new LFDString(substr($hex, $off));
			$off             += $str->getLength();
			$this->Strings[] = $str;
		}
	}

	public function __debugInfo(): array
	{
		return [
			'type'            => $this->HeaderType,
			'name'            => $this->HeaderName,
			'length'          => $this->HeaderLength,
			'NumberOfStrings' => $this->NumberOfStrings,
			'Strings'         => $this->Strings,
		];
	}
}

class LFDString implements Byteable, \ArrayAccess
{
	use HexDecoder;
	use HexEncoder;

	public int $Length; // total length of all SubStrings and the final Reserved value.
	public array $SubStrings = []; // Null terminated
	public int $Reserved; // 0x00
	public string $Hex;

	public function __construct(string $hex)
	{
		$this->Length = $this->getShort($hex);
		if ($this->Length > 1) {
			$this->SubStrings = explode(chr(0), substr($hex, 2, $this->Length - 2));
		}
		$this->Reserved = $this->getByte($hex, $this->Length + 1);
		//		$this->Hex      = Hex::hexToStr(substr($hex, 2, $this->Length - 1));
	}

	public function getLength()
	{
		return $this->Length + 2;
	}

	public function offsetExists($offset): bool
	{
		return isset($this->SubStrings[$offset]);
	}

	public function offsetGet($offset): string
	{
		return isset($this->SubStrings[$offset]) ? $this->SubStrings[$offset] : '';
	}

	public function offsetSet($offset, $value): void
	{
		$this->SubStrings[$offset] = $value;
	}

	public function offsetUnset($offset): void
	{
		unset($this->SubStrings[$offset]);
	}
}
