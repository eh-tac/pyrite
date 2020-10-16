<?php

namespace Pyrite\TIE\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\PyriteBase;
use Pyrite\TIE\Trigger;

abstract class MessageBase extends PyriteBase implements Byteable
{
    use HexDecoder;

    /** @var integer */
    public const MESSAGELENGTH = 90;
    /** @var string */
    public $Message;
    /** @var Trigger[] */
    public $Triggers;
    /** @var string */
    public $EditorNote;
    /** @var integer */
    public $DelaySeconds;
    /** @var boolean */
    public $Trigger1OrTrigger2;
    
    public function __construct($hex, $tie = null)
    {
        parent::__construct($hex, $tie);
        $this->beforeConstruct();
        $offset = 0;

        $this->Message = $this->getString($hex, 0x00);
        $this->Triggers = [];
        $offset = 0x40;
        for ($i = 0; $i < 2; $i++) {
            $t = new Trigger(substr($hex, $offset), $this->TIE);
            $this->Triggers[] = $t;
            $offset += $t->getLength();
        }
        $this->EditorNote = $this->getString($hex, 0x48);
        $this->DelaySeconds = $this->getByte($hex, 0x58);
        $this->Trigger1OrTrigger2 = $this->getBool($hex, 0x59);
        
    }
    
    public function __debugInfo()
    {
        return [
            "Message" => $this->Message,
            "Triggers" => $this->Triggers,
            "EditorNote" => $this->EditorNote,
            "DelaySeconds" => $this->DelaySeconds,
            "Trigger1OrTrigger2" => $this->Trigger1OrTrigger2
        ];
    }
    
    public function toHexString()
    {
        $hex = "";
        $offset = 0;

        $this->writeString($hex, $this->Message, 0x00);
        $offset = 0x40;
        for ($i = 0; $i < 2; $i++) {
            $t = $this->Triggers[$i];
            $this->writeObject($hex, $t, $offset);
            $offset += $t->getLength();
        }
        $this->writeString($hex, $this->EditorNote, 0x48);
        $this->writeByte($hex, $this->DelaySeconds, 0x58);
        $this->writeBool($hex, $this->Trigger1OrTrigger2, 0x59);

        return $hex;
    }
    
    
    public function getLength()
    {
        return self::MESSAGELENGTH;
    }
}