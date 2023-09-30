<?php

namespace Pyrite;

interface GoalScoring
{
    /** @return bool whether this represents a bonus point goal */
    public function isBonus();

    /** @return integer point value of goal */
    public function getPoints();
}
