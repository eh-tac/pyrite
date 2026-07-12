<?php

namespace Pyrite\TIE;

use Pyrite\PyriteModel;

class Tag extends Base\TagBase
{
    protected function afterLoadHex(): void
    {
        $this->TagLength = $this->Length + 2;
    }

    public function __toString(): string
    {
        return $this->Text;
    }
}
