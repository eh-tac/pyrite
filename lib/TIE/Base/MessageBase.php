<?php

namespace Pyrite\TIE\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;
use Pyrite\PyriteModel;
use Pyrite\TIE\Trigger;

abstract class MessageBase extends PyriteBase implements Byteable, PyriteModel
{
    use HexDecoder;
    use HexEncoder;

    /** @var int MESSAGELENGTH INT */
	public const MESSAGELENGTH = 90;
    /** @var string 0x00 Message STR */
	public string $Message;
    /** @var array<Trigger> 0x40 Triggers Trigger */
	public array $Triggers;
    /** @var string 0x48 EditorNote STR */
	public string $EditorNote;
    /** @var int 0x58 DelaySeconds BYTE */
	public int $DelaySeconds;
    /** @var bool 0x59 Trigger1OrTrigger2 BOOL */
	public bool $Trigger1OrTrigger2;
    
    public function __construct(string $hex = null, ?PyriteModel $TIE = null)
    {
        parent::__construct($hex, $TIE);
    }

    /**
     * Process the $hex string provided in the constructor.
     * Separating the constructor and loading allows for the objects to be made from scratch.
     * @return $this 
     */
    public function loadHex(): static
    {
        $hex = $this->hex;
        $offset = 0;

        $this->Message = $this->getString($hex, 0x00);
        $this->Triggers = [];
        $offset = 0x40;
        for ($i = 0; $i < 2; $i++) {
            $t = (new Trigger(substr($hex, $offset), $this->TIE))->loadHex();
            $this->Triggers[] = $t;
            $offset += $t->getLength();
        }
        $this->EditorNote = $this->getString($hex, 0x48);
        $this->DelaySeconds = $this->getByte($hex, 0x58);
        $this->Trigger1OrTrigger2 = $this->getBool($hex, 0x59);
        

        $this->hex = substr($this->hex, 0, $this->getLength());
        $this->afterLoadHex();
        return $this;
    }
    
    public function __debugInfo(): array
    {
        return [
            "Message" => $this->Message,
            "Triggers" => $this->Triggers,
            "EditorNote" => $this->EditorNote,
            "DelaySeconds" => $this->DelaySeconds,
            "Trigger1OrTrigger2" => $this->Trigger1OrTrigger2
        ];
    }
    
    public function toHexString($hex = null): string
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $hex = $this->writeString($this->Message, $hex, 0x00);
        $offset = 0x40;
        for ($i = 0; $i < 2; $i++) {
            $t = $this->Triggers[$i];
            $hex = $this->writeObject($t, $hex, $offset);
            $offset += $t->getLength();
        }
        $hex = $this->writeString($this->EditorNote, $hex, 0x48);
        $hex = $this->writeByte($this->DelaySeconds, $hex, 0x58);
        $hex = $this->writeBool($this->Trigger1OrTrigger2, $hex, 0x59);

        return $hex;
    }
    
    
    public function getLength(): int
    {
        return self::MESSAGELENGTH;
    }
}