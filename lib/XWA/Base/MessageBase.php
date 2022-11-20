<?php

namespace Pyrite\XWA\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;
use Pyrite\XWA\Trigger;

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
    /** @var integer[] 0x52 SetToTeam BYTE */
    public $SetToTeam;
    /** @var Trigger 0x5C Trigger1 Trigger */
    public $Trigger1;
    /** @var Trigger 0x62 Trigger2 Trigger */
    public $Trigger2;
    /** @var integer 0x68 Unknown1 BYTE */
    public $Unknown1;
    /** @var boolean 0x6A Trigger1OrTrigger2 BOOL */
    public $Trigger1OrTrigger2;
    /** @var Trigger 0x6C Trigger3 Trigger */
    public $Trigger3;
    /** @var Trigger 0x72 Trigger4 Trigger */
    public $Trigger4;
    /** @var boolean 0x7A Trigger3OrTrigger4 BOOL */
    public $Trigger3OrTrigger4;
    /** @var string 0x7C Voice STR */
    public $Voice;
    /** @var integer 0x84 OriginatingFG BYTE */
    public $OriginatingFG;
    /** @var integer 0x8C DelaySeconds BYTE */
    public $DelaySeconds;
    /** @var boolean 0x8D Triggers12OrTriggers34 BOOL */
    public $Triggers12OrTriggers34;
    /** @var integer 0x8E Color BYTE */
    public $Color;
    /** @var integer 0x8F Unknown2 BYTE */
    public $Unknown2;
    /** @var Trigger 0x90 Cancel1 Trigger */
    public $Cancel1;
    /** @var Trigger 0x96 Cancel2 Trigger */
    public $Cancel2;
    /** @var boolean 0x9E Cancel1OrCancel2 BOOL */
    public $Cancel1OrCancel2;
    /** @var boolean 0xA0 Unknown3 BOOL */
    public $Unknown3;
    
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
        $this->SetToTeam = [];
        $offset = 0x52;
        for ($i = 0; $i < 10; $i++) {
            $t = $this->getByte($hex, $offset);
            $this->SetToTeam[] = $t;
            $offset += 1;
        }
        $this->Trigger1 = (new Trigger(substr($hex, 0x5C), $this->TIE))->loadHex();
        $this->Trigger2 = (new Trigger(substr($hex, 0x62), $this->TIE))->loadHex();
        $this->Unknown1 = $this->getByte($hex, 0x68);
        $this->Trigger1OrTrigger2 = $this->getBool($hex, 0x6A);
        $this->Trigger3 = (new Trigger(substr($hex, 0x6C), $this->TIE))->loadHex();
        $this->Trigger4 = (new Trigger(substr($hex, 0x72), $this->TIE))->loadHex();
        $this->Trigger3OrTrigger4 = $this->getBool($hex, 0x7A);
        $this->Voice = $this->getString($hex, 0x7C);
        $this->OriginatingFG = $this->getByte($hex, 0x84);
        $this->DelaySeconds = $this->getByte($hex, 0x8C);
        $this->Triggers12OrTriggers34 = $this->getBool($hex, 0x8D);
        $this->Color = $this->getByte($hex, 0x8E);
        $this->Unknown2 = $this->getByte($hex, 0x8F);
        $this->Cancel1 = (new Trigger(substr($hex, 0x90), $this->TIE))->loadHex();
        $this->Cancel2 = (new Trigger(substr($hex, 0x96), $this->TIE))->loadHex();
        $this->Cancel1OrCancel2 = $this->getBool($hex, 0x9E);
        $this->Unknown3 = $this->getBool($hex, 0xA0);
        
        return $this;
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
    
    public function toHexString($hex = null)
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        [$hex, $offset] = $this->writeShort($this->MessageIndex, $hex, 0x00);
        [$hex, $offset] = $this->writeString($this->Message, $hex, 0x02);
        $offset = 0x52;
        for ($i = 0; $i < 10; $i++) {
            $t = $this->SetToTeam[$i];
            [$hex, $offset] = $this->writeByte($t, $hex, $offset);
        }
        [$hex, $offset] = $this->writeObject($this->Trigger1, $hex, 0x5C);
        [$hex, $offset] = $this->writeObject($this->Trigger2, $hex, 0x62);
        [$hex, $offset] = $this->writeByte($this->Unknown1, $hex, 0x68);
        [$hex, $offset] = $this->writeBool($this->Trigger1OrTrigger2, $hex, 0x6A);
        [$hex, $offset] = $this->writeObject($this->Trigger3, $hex, 0x6C);
        [$hex, $offset] = $this->writeObject($this->Trigger4, $hex, 0x72);
        [$hex, $offset] = $this->writeBool($this->Trigger3OrTrigger4, $hex, 0x7A);
        [$hex, $offset] = $this->writeString($this->Voice, $hex, 0x7C);
        [$hex, $offset] = $this->writeByte($this->OriginatingFG, $hex, 0x84);
        [$hex, $offset] = $this->writeByte($this->DelaySeconds, $hex, 0x8C);
        [$hex, $offset] = $this->writeBool($this->Triggers12OrTriggers34, $hex, 0x8D);
        [$hex, $offset] = $this->writeByte($this->Color, $hex, 0x8E);
        [$hex, $offset] = $this->writeByte($this->Unknown2, $hex, 0x8F);
        [$hex, $offset] = $this->writeObject($this->Cancel1, $hex, 0x90);
        [$hex, $offset] = $this->writeObject($this->Cancel2, $hex, 0x96);
        [$hex, $offset] = $this->writeBool($this->Cancel1OrCancel2, $hex, 0x9E);
        [$hex, $offset] = $this->writeBool($this->Unknown3, $hex, 0xA0);

        return $hex;
    }
    
    
    public function getLength()
    {
        return self::MESSAGELENGTH;
    }
}