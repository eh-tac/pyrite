<?php

namespace Pyrite;

use PDO;

trait HexEncoder
{
	public function writeBool($value)
	{
		return $value ? chr(1) : chr(0);
	}

	public function writeByte($byte)
	{
		return pack('C', $byte);
	}

	public function writeSByte($byte)
	{
		return pack('c', $byte);
	}

	public function writeChar($chr, $length = 0, $filler = NULL)
	{
		if (!$filler) {
			$filler = chr(0);
		}
		if ($length) {
			$chr = str_pad($chr, $length, $filler);
		}
		return $chr;
	}

	public function writeShort($short)
	{
		return pack('s', $short);
	}

	public function writeUShort($short)
	{
		return pack('S', $short);
	}

	public function writeInt($int)
	{
		return pack('l', $int);
	}

	public function writeString($chr, $length = 0, $filler = NULL)
	{
		if (!$filler) {
			$filler = chr(0);
		}
		if ($length) {
			$chr = str_pad($chr, $length, $filler);
		}
		return $chr . chr(0);
	}
}
