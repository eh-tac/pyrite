<?php

namespace Pyrite;

interface PyriteModel extends \JsonSerializable
{
    public function __construct(string $hex, ?PyriteBase $TIE);

    public function loadHex(): static;
    public function toHexString(): string;
    public function getLength(): int;
}
