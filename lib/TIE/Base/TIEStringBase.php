<?php
namespace Pyrite\TIE\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\PyriteBase;
use Pyrite\TIE\Constants;

abstract class TIEStringBase extends PyriteBase implements Byteable {
	use HexDecoder;

	public $TIEStringLength = 0;

	/** @var \Pyrite\TIE\SHORT */
	public $Length;
	/** @var \Pyrite\TIE\CHAR<Length> */
	public $Text;

	public function __construct($hex, $tie){
		$this->hex = $hex;
		$this->TIE = $tie; 
		$offset = 0;
		$this->Length = $this->getShort($hex, 0x0);
		if ($this->Length === 0) {
			$this->afterConstruct();
			return;
		}
		$this->Text = $this->getChar($hex, 0x2, $this->Length);
		$this->TIEStringLength = $offset;
		$this->afterConstruct();
	}

	public function __debugInfo() {
		return [
			"Length" => $this->Length,
			"Text" => $this->Text		];
	}

	protected function toHexString() {

		$hex = "";

		$offset = 0;
		$this->writeShort($hex, $this->Length, 0x0);
		if ($this->Length === 0) {
			return;
		}
		$this->writeChar($hex, $this->Text, 0x2, $this->Length);
		return $hex;
	}


    public function getLength(){
        return $this->TIEStringLength;
    }
}