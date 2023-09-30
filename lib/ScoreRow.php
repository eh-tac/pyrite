<?php

namespace Pyrite;

class ScoreRow
{
    public string $label;
    public int $number;
    public int $maximumQuantity;
    public int $points;
    public bool $isHeader;

    public function __construct(string $label, int $number, int $points, bool $isHeader = false)
    {
        $this->label = $label;
        $this->number = $this->maximumQuantity = $number;
        $this->points = $points;
        $this->isHeader = $isHeader;
    }

    public function disable(): self
    {
        $this->number = 0;
        return $this;
    }

    public function isCheckbox(): bool
    {
        return $this->maximumQuantity === 1;
    }

    public static function create(string $label, int $number, int $points)
    {
        return new ScoreRow($label, $number, $points);
    }

    public static function header(string $label)
    {
        return new ScoreRow($label, 0, 0, TRUE);
    }
}
