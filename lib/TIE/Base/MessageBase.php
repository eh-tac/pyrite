<?php
namespace Pyrite\TIE\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\PyriteBase;
use Pyrite\TIE\Constants;

abstract class MessageBase extends PyriteBase implements Byteable {
	use HexDecoder;

	const MESSAGE_LENGTH = 0x5A;

	/** @var \Pyrite\TIE\STR<64> */
	public $Message;
	/** @var \Pyrite\TIE\Trigger */
	public $Triggers;
	/** @var \Pyrite\TIE\STR<12> */
	public $EditorNote;
	/** @var \Pyrite\TIE\BYTE */
	public $DelaySeconds;
	/** @var \Pyrite\TIE\BOOL */
	public $Trigger1OrTrigger2;

	public function __construct($hex, $tie){
		$this->hex = $hex;
		$this->TIE = $tie; 
		$offset = 0;
		$this->Message = $this->getString($hex, 0x00, 64);

        $this->Triggers = [];
        $offset = 0x40;
        for ($i = 0; $i < 2; $i++) {
            $t = new \Pyrite\TIE\Trigger(substr($hex, $offset), $this->TIE);
            $this->Triggers[] = $t;
            $offset += 0x4;
        }
		$this->EditorNote = $this->getString($hex, 0x48, 12);
		$this->DelaySeconds = $this->getByte($hex, 0x58);
		$this->Trigger1OrTrigger2 = $this->getBool($hex, 0x59);
		$this->afterConstruct();
	}

	public function __debugInfo() {
		return [
			"Message" => $this->Message,
			"Triggers" => $this->Triggers,
			"EditorNote" => $this->EditorNote,
			"DelaySeconds" => $this->DelaySeconds,
			"Trigger1OrTrigger2" => $this->Trigger1OrTrigger2		];
	}

	protected function toHexString() {

		$hex = "";

		$offset = 0;
		$this->writeString($hex, $this->Message, 0x00, 64);

        $offset = 0x40;
        for ($i = 0; $i < 2; $i++) {
            $t = $this->Triggers[$i];
            $this->writeObject($hex, $this->Triggers[$i], $offset);
            $offset += 0x4;
        }
		$this->writeString($hex, $this->EditorNote, 0x48, 12);
		$this->writeByte($hex, $this->DelaySeconds, 0x58);
		$this->writeBool($hex, $this->Trigger1OrTrigger2, 0x59);
		return $hex;
	}


    public function getLength(){
        return self::MESSAGE_LENGTH;
    }
}