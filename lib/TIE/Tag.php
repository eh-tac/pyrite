<?php

namespace Pyrite\TIE;

use Pyrite\PyriteModel;

class Tag extends Base\TagBase
{
    public function __construct(string $hex = null, ?PyriteModel $TIE = null)
    {
        parent::__construct($hex, $TIE);

        $this->TagLength = $this->Length + 2;
    }

    public function __toString(): string
    {
        return $this->Text;
    }
}
