<?php
namespace Pyrite\TIE;

class Tag extends Base\TagBase
{
    protected function afterConstruct()
    {
        $this->TagLength = $this->Length + 2;
    }

	public function __toString(){
		return $this->Text;
	}
}
