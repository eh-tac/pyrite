<?php

namespace Pyrite;

trait HexDecoder
{
	// TODO remove all early returns and replace with checks to see why they're not being decoded properly
	public function getBool(string $chr, int $startPos = NULL): bool
	{
		if ($startPos !== NULL) {
			$chr = substr($chr, $startPos, 1);
		}
		return ord($chr) ? TRUE : FALSE;
	}

	public function getByte(string $str, int $startPos = NULL): int
	{
		if ($startPos === NULL || $startPos >= strlen($str)) {
			return 0;
		}
		$chr = $str[$startPos];
		return unpack('Cbyte', $chr)['byte'];
	}

	public function getSByte(string $chr, int $startPos = NULL): int
	{
		if ($startPos !== NULL) {
			$chr = substr($chr, $startPos, 1);
		}
		if (!$chr) return 0;
		return unpack('csbyte', $chr)['sbyte'];
	}

	public function getChar(string $chr, int $startPos = 0, int $length = 1): string
	{
		$chr = substr($chr, $startPos, $length);
		return $this->printChar($chr);
		//        $chr = substr($chr, $startPos ? $startPos : 0, $length);
		//        return unpack('cchar', $chr)['char'];
	}

	public function printChar(string $char): string
	{
		$bits = explode(chr(0), $char);
		return $bits[0];
	}

	public function getShort(string $str, int $startPos = NULL): int
	{
		if ($startPos !== NULL) {
			$str = substr($str, $startPos, 2);
		}
		if (!$str || strlen($str) !== 2) {
			return 0;
		}
		return unpack('sshort', $str)['short'];
	}

	public function getUShort(string $str, int $startPos = NULL): int
	{
		if ($startPos !== NULL) {
			$str = substr($str, $startPos, 2);
		}
		if (!$str || strlen($str) !== 2) {
			return 0;
		}
		return unpack('Sshort', $str)['short'];
	}

	public function getInt(string $str, int $startPos = NULL): int
	{
		if ($startPos !== NULL) {
			$str = substr($str, $startPos, 4);
		}
		if (!$str) return 0;
		return unpack('lint', $str)['int'];
	}

	/**
	 * Get a string from the provided hex string. Terminate the string at the first null/chr(0) character
	 * @param string $str
	 * @param int $start  If set, perform a substr from this position before looking for the null characters
	 * @param int $length If set, perform a substr to this length from the start position
	 * @return string
	 */
	public function getString(string $str, int $start = 0, int $length = PHP_INT_MAX): string
	{
		if ($start || $length) {
			$str = substr($str, $start, $length);
		}
		$bits = explode(chr(0), $str, 2);
		return utf8_encode(trim($bits[0]));
	}

	public function lookup(array $array, string $chr, int $startPos = NULL): string
	{
		$key = $this->getByte($chr, $startPos);
		if (!isset($array[$key])) {
			return "Unknown lookup $key";
		}
		return $array[$key];
	}

	public function getByteString(int $byte): string
	{
		return str_pad(decbin($byte), 8, '0', STR_PAD_LEFT);
	}
}
