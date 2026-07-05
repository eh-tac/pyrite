<?php

namespace Pyrite\TIE;

use Pyrite\PyriteModel;

class TIEString extends Base\TIEStringBase
{
    public function __construct(string $hex = null, ?PyriteModel $TIE = NULL)
    {
        parent::__construct($hex, $TIE);
        // if ($this->Length === 0) {
        //     $this->PostMissionQuestionsLength = 2;
        // }

        $this->TIEStringLength = $this->Length + 2;
    }

    public function __toString()
    {
        return $this->Text;
    }
}
