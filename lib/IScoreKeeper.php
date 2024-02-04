<?php

namespace Pyrite;

interface IScoreKeeper
{
    public function getData(): array;

    public function getTotal(): int;
}
