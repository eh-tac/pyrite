<?php

namespace Pyrite;

interface FlightGroupScoring
{
    /**
     * @param string $difficulty difficulty level Easy|Medium|Hard
     * @return bool whether this flight group appears in the given difficulty level
     */
    public function IsInDifficultyLevel($difficulty);

    /**
     * @param [$difficulty] if required by the platform, the applicable difficulty setting for determining point value
     * @return points for destroying this object
     */
    public function pointValue($difficulty = NULL);

    /** @return bool whether the object is able to be destroyed - whether invincible or mission critical*/
    public function destroyable();

    /** @return bool whether the object is invincible */
    public function invincible();

    /** @return bool whether the object is the player craft */
    public function isPlayerCraft();

    /** @return int the maximum number of warheads the craft may carry */
    public function maxWarheads();
}
