<?php

namespace Pyrite\TIE;

class TIEString extends Base\TIEStringBase
{
    protected function afterLoadHex(): void
    {
        $this->TIEStringLength = $this->Length + 2;
    }

    public function __toString()
    {
        return $this->Text;
    }
}
