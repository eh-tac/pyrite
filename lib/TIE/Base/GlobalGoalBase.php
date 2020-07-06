<?php
namespace Pyrite\TIE\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\PyriteBase;
use Pyrite\TIE\Constants;

abstract class GlobalGoalBase extends PyriteBase implements Byteable {
	use HexDecoder;

	const GLOBALGOAL_LENGTH = 0x1C;

	/** @var \Pyrite\TIE\Trigger */
	public $Triggers;
	/** @var \Pyrite\TIE\BOOL */
	public $Trigger1OrTrigger2;

	public function __construct($hex, $tie){
		$this->hex = $hex;
		$this->TIE = $tie; 
		$offset = 0;

        $this->Triggers = [];
        $offset = 0x00;
        for ($i = 0; $i < 2; $i++) {
            $t = new \Pyrite\TIE\Trigger(substr($hex, $offset), $this->TIE);
            $this->Triggers[] = $t;
            $offset += 0x4;
        }
		$this->Trigger1OrTrigger2 = $this->getBool($hex, 0x19);
		$this->afterConstruct();
	}

	public function __debugInfo() {
		return [
			"Triggers" => $this->Triggers,
			"Trigger1OrTrigger2" => $this->Trigger1OrTrigger2		];
	}

	protected function toHexString() {

		$hex = "";

		$offset = 0;

        $offset = 0x00;
        for ($i = 0; $i < 2; $i++) {
            $t = $this->Triggers[$i];
            $this->writeObject($hex, $this->Triggers[$i], $offset);
            $offset += 0x4;
        }
		$this->writeBool($hex, $this->Trigger1OrTrigger2, 0x19);
		return $hex;
	}


    public function getLength(){
        return self::GLOBALGOAL_LENGTH;
    }
}