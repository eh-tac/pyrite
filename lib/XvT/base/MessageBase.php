<?php

namespace Pyrite\XvT\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\PyriteBase;
use Pyrite\XvT\Trigger;

abstract class MessageBase extends PyriteBase implements Byteable
{
    use HexDecoder;

    /** @var integer */
    public const MESSAGELENGTH = 116;
    /** @var integer */
    public $MessageIndex;
    /** @var string */
    public $Message;
    /** @var integer[] */
    public $SentToTeams;
    /** @var Trigger[] */
    public $TriggerA;
    /** @var boolean */
    public $Trigger1OrTrigger2;
    /** @var Trigger[] */
    public $TriggerB;
    /** @var boolean */
    public $Trigger3OrTrigger4;
    /** @var string */
    public $EditorNote;
    /** @var integer */
    public $DelaySeconds;
    /** @var boolean */
    public $Trigger12OrTrigger34;
    
    public function __construct($hex, $tie = null)
    {
        parent::__construct($hex, $tie);
        $this->beforeConstruct();
        $offset = 0;

        $this->MessageIndex = $this->getShort($hex, 0x00);
        $this->Message = $this->getChar($hex, 0x02, 64);
        $this->SentToTeams = [];
        $offset = 0x42;
        for ($i = 0; $i < 10; $i++) {
            $t = $this->getByte($hex, $offset);
            $this->SentToTeams[] = $t;
            $offset += 1;
        }
        $this->TriggerA = [];
        $offset = 0x4C;
        for ($i = 0; $i < 2; $i++) {
            $t = new Trigger(substr($hex, $offset), $this->TIE);
            $this->TriggerA[] = $t;
            $offset += $t->getLength();
        }
        $this->Trigger1OrTrigger2 = $this->getBool($hex, 0x56);
        $this->TriggerB = [];
        $offset = 0x57;
        for ($i = 0; $i < 2; $i++) {
            $t = new Trigger(substr($hex, $offset), $this->TIE);
            $this->TriggerB[] = $t;
            $offset += $t->getLength();
        }
        $this->Trigger3OrTrigger4 = $this->getBool($hex, 0x61);
        $this->EditorNote = $this->getString($hex, 0x62);
        $this->DelaySeconds = $this->getByte($hex, 0x72);
        $this->Trigger12OrTrigger34 = $this->getBool($hex, 0x73);
        
    }
    
    public function __debugInfo()
    {
        return [
            "MessageIndex" => $this->MessageIndex,
            "Message" => $this->Message,
            "SentToTeams" => $this->SentToTeams,
            "TriggerA" => $this->TriggerA,
            "Trigger1OrTrigger2" => $this->Trigger1OrTrigger2,
            "TriggerB" => $this->TriggerB,
            "Trigger3OrTrigger4" => $this->Trigger3OrTrigger4,
            "EditorNote" => $this->EditorNote,
            "DelaySeconds" => $this->DelaySeconds,
            "Trigger12OrTrigger34" => $this->Trigger12OrTrigger34
        ];
    }
    
    public function toHexString()
    {
        $hex = "";
        $offset = 0;

        $this->writeShort($hex, $this->MessageIndex, 0x00);
        $this->writeChar($hex, $this->Message, 0x02);
        $offset = 0x42;
        for ($i = 0; $i < 10; $i++) {
            $t = $this->SentToTeams[$i];
            $this->writeByte($hex, $t, $offset);
            $offset += 1;
        }
        $offset = 0x4C;
        for ($i = 0; $i < 2; $i++) {
            $t = $this->TriggerA[$i];
            $this->writeObject($hex, $t, $offset);
            $offset += $t->getLength();
        }
        $this->writeBool($hex, $this->Trigger1OrTrigger2, 0x56);
        $offset = 0x57;
        for ($i = 0; $i < 2; $i++) {
            $t = $this->TriggerB[$i];
            $this->writeObject($hex, $t, $offset);
            $offset += $t->getLength();
        }
        $this->writeBool($hex, $this->Trigger3OrTrigger4, 0x61);
        $this->writeString($hex, $this->EditorNote, 0x62);
        $this->writeByte($hex, $this->DelaySeconds, 0x72);
        $this->writeBool($hex, $this->Trigger12OrTrigger34, 0x73);

        return $hex;
    }
    
    
    public function getLength()
    {
        return self::MESSAGELENGTH;
    }
}