<?php

namespace Pyrite\XW;

class Mission extends Base\MissionBase
{

    public function beforeConstruct()
    {
        $this->TIE = $this;
    }

    public function __toString()
    {
        return '';
    }

    public function getFG($id)
    {
        return $this->FlightGroups[$id];
    }


}
