<?php

namespace Pyrite\XvT\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;
use Pyrite\PyriteModel;
use Pyrite\XvT\Trigger;

abstract class MessageBase extends PyriteBase implements Byteable, PyriteModel
{
    use HexDecoder;
    use HexEncoder;

    /** @var int MESSAGELENGTH INT */
	public const MESSAGELENGTH = 116;
    /** @var int 0x00 MessageIndex SHORT */
	public int $MessageIndex;
    /** @var string 0x02 Message CHAR */
	public string $Message;
    /** @var array<int> 0x42 SentToTeams BYTE */
	public array $SentToTeams;
    /** @var array<Trigger> 0x4C TriggerA Trigger */
	public array $TriggerA;
    /** @var bool 0x56 Trigger1OrTrigger2 BOOL */
	public bool $Trigger1OrTrigger2;
    /** @var array<Trigger> 0x57 TriggerB Trigger */
	public array $TriggerB;
    /** @var bool 0x61 Trigger3OrTrigger4 BOOL */
	public bool $Trigger3OrTrigger4;
    /** @var string 0x62 EditorNote STR */
	public string $EditorNote;
    /** @var int 0x72 DelaySeconds BYTE */
	public int $DelaySeconds;
    /** @var bool 0x73 Trigger12OrTrigger34 BOOL */
	public bool $Trigger12OrTrigger34;
    
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
            $t = (new Trigger(substr($hex, $offset), $this->TIE))->loadHex();
            $this->TriggerA[] = $t;
            $offset += $t->getLength();
        }
        $this->Trigger1OrTrigger2 = $this->getBool($hex, 0x56);
        $this->TriggerB = [];
        $offset = 0x57;
        for ($i = 0; $i < 2; $i++) {
            $t = (new Trigger(substr($hex, $offset), $this->TIE))->loadHex();
            $this->TriggerB[] = $t;
            $offset += $t->getLength();
        }
        $this->Trigger3OrTrigger4 = $this->getBool($hex, 0x61);
        $this->EditorNote = $this->getString($hex, 0x62);
        $this->DelaySeconds = $this->getByte($hex, 0x72);
        $this->Trigger12OrTrigger34 = $this->getBool($hex, 0x73);
        

        $this->hex = substr($this->hex, 0, $this->getLength());
        return $this;
    }
    
    public function __debugInfo(): array
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
    
    public function toHexString($hex = null): string
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $hex = $this->writeShort($this->MessageIndex, $hex, 0x00);
        $hex = $this->writeChar($this->Message, $hex, 0x02);
        $offset = 0x42;
        for ($i = 0; $i < 10; $i++) {
            $t = $this->SentToTeams[$i];
            $hex = $this->writeByte($t, $hex, $offset);
            $offset += 1;
        }
        $offset = 0x4C;
        for ($i = 0; $i < 2; $i++) {
            $t = $this->TriggerA[$i];
            $hex = $this->writeObject($t, $hex, $offset);
            $offset += $t->getLength();
        }
        $hex = $this->writeBool($this->Trigger1OrTrigger2, $hex, 0x56);
        $offset = 0x57;
        for ($i = 0; $i < 2; $i++) {
            $t = $this->TriggerB[$i];
            $hex = $this->writeObject($t, $hex, $offset);
            $offset += $t->getLength();
        }
        $hex = $this->writeBool($this->Trigger3OrTrigger4, $hex, 0x61);
        $hex = $this->writeString($this->EditorNote, $hex, 0x62);
        $hex = $this->writeByte($this->DelaySeconds, $hex, 0x72);
        $hex = $this->writeBool($this->Trigger12OrTrigger34, $hex, 0x73);

        return $hex;
    }
    
    
    public function getLength(): int
    {
        return self::MESSAGELENGTH;
    }
}