<?php

namespace Pyrite\XW;

class ObjectGroup extends Base\ObjectGroupBase
{

    public function beforeConstruct() {}

    public function __toString()
    {
        $c = $this->NumberOfCraft;

        $t = 'Object ' . $this->getCraftTypeLabel();
        $n = $this->Name;

        return "$c $t $n";
    }
}
