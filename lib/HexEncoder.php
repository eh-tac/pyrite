<?php

namespace Pyrite;

trait HexEncoder
{
	public function write(string $value, string $hex, int $off): string
	{
		return substr_replace(
			$hex,
			$value,
			$off,
			strlen($value)
		);
	}

	public function writeBool(bool $value, string $hex, int $off): string
	{
		return $this->write($value ? chr(1) : chr(0), $hex, $off);
	}

	public function writeByte(int $byte, string $hex, int $off): string
	{
		return $this->write(pack('C', $byte), $hex, $off);
	}

	public function writeSByte(int $byte, string $hex, int $off): string
	{
		return $this->write(pack('c', $byte), $hex, $off);
	}

	public function writeChar(string $chr, string $hex, int $off): string
	{
		return $this->write($chr, $hex, $off);
	}

	public function writeShort(int $short, string $hex, int $off): string
	{
		return $this->write(pack('s', $short), $hex, $off);
	}

	public function writeUShort(int $short, string $hex, int $off): string
	{
		return $this->write(pack('S', $short), $hex, $off);
	}

	public function writeInt(int $int, string $hex, int $off): string
	{
		return $this->write(pack('l', $int), $hex, $off);
	}

	public function writeString(string $chr, string $hex, int $off): string
	{
		return $this->write($chr . chr(0), $hex, $off);
	}

	public function writeObject(PyriteModel $t, string $hex, int $off): string
	{
		return $this->write($t->toHexString(), $hex, $off);
	}
}
