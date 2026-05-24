<?php

namespace Pyrite\XWA\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;
use Pyrite\XWA\TriggerPair;

abstract class MessageBase extends PyriteBase implements Byteable
{
    use HexDecoder;
    use HexEncoder;

    /** @var integer  MESSAGELENGTH INT */
    public const MESSAGELENGTH = 162;
    /** @var integer 0x00 MessageIndex SHORT */
    public $MessageIndex;
    /** @var string 0x02 Message STR */
    public $Message;
    /** @var integer[] 0x52 SentToTeam BYTE */
    public $SentToTeam;
    /** @var TriggerPair[] 0x5C Triggers TriggerPair */
    public $Triggers; //(contained Unknown1)
    /** @var string 0x7C Voice STR */
    public $Voice;
    /** @var integer 0x84 OriginatingFG INT */
    public $OriginatingFG;
    /** @var integer 0x88 Type INT */
    public $Type;
    /** @var integer 0x8C Delay BYTE */
    public $Delay;
    /** @var boolean 0x8D Triggers12OrTriggers34 BOOL */
    public $Triggers12OrTriggers34;
    /** @var integer 0x8E Color BYTE */
    public $Color;
    /** @var boolean 0x8F SpeakerHeader BOOL */
    public $SpeakerHeader; //(was Unknown2)
    /** @var TriggerPair 0x90 Special TriggerPair */
    public $Special;
    /** @var integer 0xA0 SpecialMeaning BYTE */
    public $SpecialMeaning; //(was Unknown3) {Ignore, Stop, Finished, Both}
    
    public function __construct($hex = null, $tie = null)
    {
        parent::__construct($hex, $tie);
    }

    /**
     * Process the $hex string provided in the constructor.
     * Separating the constructor and loading allows for the objects to be made from scratch.
     * @return $this 
     */
    public function loadHex()
    {
        $hex = $this->hex;
        $offset = 0;

        $this->MessageIndex = $this->getShort($hex, 0x00);
        $this->Message = $this->getString($hex, 0x02);
        $this->SentToTeam = [];
        $offset = 0x52;
        for ($i = 0; $i < 10; $i++) {
            $t = $this->getByte($hex, $offset);
            $this->SentToTeam[] = $t;
            $offset += 1;
        }
        $this->Triggers = [];
        $offset = 0x5C;
        for ($i = 0; $i < 2; $i++) {
            $t = (new TriggerPair(substr($hex, $offset), $this->TIE))->loadHex();
            $this->Triggers[] = $t;
            $offset += $t->getLength();
        }
        $this->Voice = $this->getString($hex, 0x7C);
        $this->OriginatingFG = $this->getInt($hex, 0x84);
        $this->Type = $this->getInt($hex, 0x88);
        $this->Delay = $this->getByte($hex, 0x8C);
        $this->Triggers12OrTriggers34 = $this->getBool($hex, 0x8D);
        $this->Color = $this->getByte($hex, 0x8E);
        $this->SpeakerHeader = $this->getBool($hex, 0x8F);
        $this->Special = (new TriggerPair(substr($hex, 0x90), $this->TIE))->loadHex();
        $this->SpecialMeaning = $this->getByte($hex, 0xA0);
        

        $this->hex = substr($this->hex, 0, $this->getLength());
        return $this;
    }
    
    public function __debugInfo()
    {
        return [
            "MessageIndex" => $this->MessageIndex,
            "Message" => $this->Message,
            "SentToTeam" => $this->SentToTeam,
            "Triggers" => $this->Triggers,
            "Voice" => $this->Voice,
            "OriginatingFG" => $this->OriginatingFG,
            "Type" => $this->Type,
            "Delay" => $this->Delay,
            "Triggers12OrTriggers34" => $this->Triggers12OrTriggers34,
            "Color" => $this->Color,
            "SpeakerHeader" => $this->SpeakerHeader,
            "Special" => $this->Special,
            "SpecialMeaning" => $this->SpecialMeaning
        ];
    }
    
    public function toHexString($hex = null)
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $hex = $this->writeShort($this->MessageIndex, $hex, 0x00);
        $hex = $this->writeString($this->Message, $hex, 0x02);
        $offset = 0x52;
        for ($i = 0; $i < 10; $i++) {
            $t = $this->SentToTeam[$i];
            $hex = $this->writeByte($t, $hex, $offset);
            $offset += 1;
        }
        $offset = 0x5C;
        for ($i = 0; $i < 2; $i++) {
            $t = $this->Triggers[$i];
            $hex = $this->writeObject($t, $hex, $offset);
            $offset += $t->getLength();
        }
        $hex = $this->writeString($this->Voice, $hex, 0x7C);
        $hex = $this->writeInt($this->OriginatingFG, $hex, 0x84);
        $hex = $this->writeInt($this->Type, $hex, 0x88);
        $hex = $this->writeByte($this->Delay, $hex, 0x8C);
        $hex = $this->writeBool($this->Triggers12OrTriggers34, $hex, 0x8D);
        $hex = $this->writeByte($this->Color, $hex, 0x8E);
        $hex = $this->writeBool($this->SpeakerHeader, $hex, 0x8F);
        $hex = $this->writeObject($this->Special, $hex, 0x90);
        $hex = $this->writeByte($this->SpecialMeaning, $hex, 0xA0);

        return $hex;
    }
    
    
    public function getLength()
    {
        return self::MESSAGELENGTH;
    }
}