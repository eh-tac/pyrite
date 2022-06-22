<?php

namespace Pyrite;

use PDO;

trait HexEncoder
{
	public function write($value, $hex, $off)
	{
		return substr_replace(
			$hex,
			$value,
			$off,
			strlen($value)
		);
	}

	public function writeBool($value, $hex, $off)
	{
		return $this->write($value ? chr(1) : chr(0), $hex, $off);
	}

	public function writeByte($byte, $hex, $off)
	{
		return $this->write(pack('C', $byte), $hex, $off);
	}

	public function writeSByte($byte, $hex, $off)
	{
		return $this->write(pack('c', $byte), $hex, $off);
	}

	public function writeChar($chr, $hex, $off)
	{
		return $this->write($chr, $hex, $off);
	}

	public function writeShort($short, $hex, $off)
	{
		return $this->write(pack('s', $short), $hex, $off);
	}

	public function writeUShort($short, $hex, $off)
	{
		return $this->write(pack('S', $short), $hex, $off);
	}

	public function writeInt($int, $hex, $off)
	{
		return $this->write(pack('l', $int), $hex, $off);
	}

	public function writeString($chr, $hex, $off)
	{
		return $this->write($chr . chr(0), $hex, $off);
	}

	public function writeObject($t, $hex, $off)
	{
		return $this->write($t->toHexString(), $hex, $off);
	}
}
