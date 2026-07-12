<?php

namespace Pyrite\XW;

class Mission extends Base\MissionBase
{
    protected function afterLoadHex(): void
    {
        $this->TIE = $this;
    }

    public function __toString()
    {
        return '';
    }

    public function getFG(int $id)
    {
        return $this->FlightGroups[$id];
    }
}
