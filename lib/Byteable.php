<?php

namespace Pyrite;

interface Byteable
{
    // hex encoding functions
    public function write(string $value, string $hex, int $off): string;
    public function writeBool(bool $value, string $hex, int $off): string;
    public function writeByte(int $byte, string $hex, int $off): string;
    public function writeSByte(int $byte, string $hex, int $off): string;
    public function writeChar(string $chr, string $hex, int $off): string;
    public function writeShort(int $short, string $hex, int $off): string;
    public function writeUShort(int $short, string $hex, int $off): string;
    public function writeInt(int $int, string $hex, int $off): string;
    public function writeString(string $chr, string $hex, int $off): string;
    public function writeObject(PyriteModel $t, string $hex, int $off): string;

    // hex decoding functions
    public function getBool(string $str, int $startPos = NULL): bool;
    public function getByte(string $str, int $startPos = NULL): int;
    public function getSByte(string $str, int $startPos = NULL): int;
    public function getChar(string $str, int $startPos = 0, int $length = 1): string;
    public function getShort(string $str, int $startPos = NULL): int;
    public function getUShort(string $str, int $startPos = NULL): int;
    public function getInt(string $str, int $startPos = NULL): int;
    public function getString(string $str, int $startPos = 0, int $length = PHP_INT_MAX): string;
    public function lookup(array $array, string $chr, int $startPos = NULL): string;
    public function getByteString(int $byte): string;
}
