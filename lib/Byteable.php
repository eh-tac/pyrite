<?php

namespace Pyrite;

interface Byteable
{
    /** @return int length of this object in bytes */
    public function getLength();
}
