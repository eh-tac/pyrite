<?php

namespace Pyrite\TIE;

class TIEString extends Base\TIEStringBase
{
    public function __construct($hex, $tie)
    {
        parent::__construct($hex, $tie);
        if ($this->Length === 0) {
            $this->PostMissionQuestionsLength = 2;
        }

        $this->TIEStringLength = $this->Length + 2;
    }

    public function __toString()
    {
        return $this->Text;
    }
}
