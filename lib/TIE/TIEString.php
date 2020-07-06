<?php
namespace Pyrite\TIE;

class TIEString extends Base\TIEStringBase
{
    protected function afterConstruct()
    {
        $this->TIEStringLength = $this->Length + 2;
    }

    public function __toString(){
    	return $this->Text;
	}
}
