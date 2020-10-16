<?php

namespace Pyrite\TIE;

class Tag extends Base\TagBase
{
    public function __construct($hex, $tie)
    {
        parent::__construct($hex, $tie);

        $this->TagLength = $this->Length + 2;
    }

    public function __toString()
    {
        return $this->Text;
    }
}
