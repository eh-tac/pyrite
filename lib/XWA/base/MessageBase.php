<?php

namespace Pyrite\XWA\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\PyriteBase;
use Pyrite\XWA\Trigger;

abstract class MessageBase extends PyriteBase implements Byteable
{
    use HexDecoder;

    /** @var integer */
    public const MESSAGELENGTH = 162;
    /** @var integer */
    public $MessageIndex;
    /** @var string */
    public $Message;
    /** @var integer[] */
    public $SetToTeam;
    /** @var Trigger */
    public $Trigger1;
    /** @var Trigger */
    public $Trigger2;
    /** @var integer */
    public $Unknown1;
    /** @var boolean */
    public $Trigger1OrTrigger2;
    /** @var Trigger */
    public $Trigger3;
    /** @var Trigger */
    public $Trigger4;
    /** @var boolean */
    public $Trigger3OrTrigger4;
    /** @var string */
    public $Voice;
    /** @var integer */
    public $OriginatingFG;
    /** @var integer */
    public $DelaySeconds;
    /** @var boolean */
    public $Triggers12OrTriggers34;
    /** @var integer */
    public $Color;
    /** @var integer */
    public $Unknown2;
    /** @var Trigger */
    public $Cancel1;
    /** @var Trigger */
    public $Cancel2;
    /** @var boolean */
    public $Cancel1OrCancel2;
    /** @var boolean */
    public $Unknown3;
    
    public function __construct($hex, $tie = null)
    {
        parent::__construct($hex, $tie);
        $this->beforeConstruct();
        $offset = 0;

        $this->MessageIndex = $this->getShort($hex, 0x00);
        $this->Message = $this->getString($hex, 0x02);
        $this->SetToTeam = [];
        $offset = 0x52;
        for ($i = 0; $i < 10; $i++) {
            $t = $this->getByte($hex, $offset);
            $this->SetToTeam[] = $t;
            $offset += 1;
        }
        $this->Trigger1 = new Trigger(substr($hex, 0x5C), $this->TIE);
        $this->Trigger2 = new Trigger(substr($hex, 0x62), $this->TIE);
        $this->Unknown1 = $this->getByte($hex, 0x68);
        $this->Trigger1OrTrigger2 = $this->getBool($hex, 0x6A);
        $this->Trigger3 = new Trigger(substr($hex, 0x6C), $this->TIE);
        $this->Trigger4 = new Trigger(substr($hex, 0x72), $this->TIE);
        $this->Trigger3OrTrigger4 = $this->getBool($hex, 0x7A);
        $this->Voice = $this->getString($hex, 0x7C);
        $this->OriginatingFG = $this->getByte($hex, 0x84);
        $this->DelaySeconds = $this->getByte($hex, 0x8C);
        $this->Triggers12OrTriggers34 = $this->getBool($hex, 0x8D);
        $this->Color = $this->getByte($hex, 0x8E);
        $this->Unknown2 = $this->getByte($hex, 0x8F);
        $this->Cancel1 = new Trigger(substr($hex, 0x90), $this->TIE);
        $this->Cancel2 = new Trigger(substr($hex, 0x96), $this->TIE);
        $this->Cancel1OrCancel2 = $this->getBool($hex, 0x9E);
        $this->Unknown3 = $this->getBool($hex, 0xA0);
        
    }
    
    public function __debugInfo()
    {
        return [
            "MessageIndex" => $this->MessageIndex,
            "Message" => $this->Message,
            "SetToTeam" => $this->SetToTeam,
            "Trigger1" => $this->Trigger1,
            "Trigger2" => $this->Trigger2,
            "Unknown1" => $this->Unknown1,
            "Trigger1OrTrigger2" => $this->Trigger1OrTrigger2,
            "Trigger3" => $this->Trigger3,
            "Trigger4" => $this->Trigger4,
            "Trigger3OrTrigger4" => $this->Trigger3OrTrigger4,
            "Voice" => $this->Voice,
            "OriginatingFG" => $this->OriginatingFG,
            "DelaySeconds" => $this->DelaySeconds,
            "Triggers12OrTriggers34" => $this->Triggers12OrTriggers34,
            "Color" => $this->Color,
            "Unknown2" => $this->Unknown2,
            "Cancel1" => $this->Cancel1,
            "Cancel2" => $this->Cancel2,
            "Cancel1OrCancel2" => $this->Cancel1OrCancel2,
            "Unknown3" => $this->Unknown3
        ];
    }
    
    public function toHexString()
    {
        $hex = "";
        $offset = 0;

        $this->writeShort($hex, $this->MessageIndex, 0x00);
        $this->writeString($hex, $this->Message, 0x02);
        $offset = 0x52;
        for ($i = 0; $i < 10; $i++) {
            $t = $this->SetToTeam[$i];
            $this->writeByte($hex, $t, $offset);
            $offset += 1;
        }
        $this->writeObject($hex, $this->Trigger1, 0x5C);
        $this->writeObject($hex, $this->Trigger2, 0x62);
        $this->writeByte($hex, $this->Unknown1, 0x68);
        $this->writeBool($hex, $this->Trigger1OrTrigger2, 0x6A);
        $this->writeObject($hex, $this->Trigger3, 0x6C);
        $this->writeObject($hex, $this->Trigger4, 0x72);
        $this->writeBool($hex, $this->Trigger3OrTrigger4, 0x7A);
        $this->writeString($hex, $this->Voice, 0x7C);
        $this->writeByte($hex, $this->OriginatingFG, 0x84);
        $this->writeByte($hex, $this->DelaySeconds, 0x8C);
        $this->writeBool($hex, $this->Triggers12OrTriggers34, 0x8D);
        $this->writeByte($hex, $this->Color, 0x8E);
        $this->writeByte($hex, $this->Unknown2, 0x8F);
        $this->writeObject($hex, $this->Cancel1, 0x90);
        $this->writeObject($hex, $this->Cancel2, 0x96);
        $this->writeBool($hex, $this->Cancel1OrCancel2, 0x9E);
        $this->writeBool($hex, $this->Unknown3, 0xA0);

        return $hex;
    }
    
    
    public function getLength()
    {
        return self::MESSAGELENGTH;
    }
}