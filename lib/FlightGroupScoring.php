<?php

namespace Pyrite;

interface FlightGroupScoring
{
    /**
     * @param string $difficulty difficulty level Easy|Medium|Hard
     * @return bool whether this flight group appears in the given difficulty level
     */
    public function isInDifficultyLevel(string $difficulty): bool;

    /**
     * @param string|null $difficulty if required by the platform, the applicable difficulty setting for determining point value
     * @return int points for destroying this object
     */
    public function killPointValue(string $difficulty = NULL): int;

    /** @return bool whether the object is able to be destroyed - whether invincible or mission critical*/
    public function destroyable(): bool;

    /** @return bool whether the object is invincible */
    public function isInvincible(): bool;

    /** @return bool whether the object is the player craft */
    public function isPlayerCraft(): bool;

    /** @return int the maximum number of warheads the craft may carry */
    public function maxWarheads(): int;
}
