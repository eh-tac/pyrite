<?php

namespace Pyrite\XWA\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;

abstract class TeamBase extends PyriteBase implements Byteable
{
    use HexDecoder;
    use HexEncoder;

    /** @var integer  TEAMLENGTH INT */
    public const TEAMLENGTH = 487;
    /** @var integer 0x000 Reserved SHORT */
    public $Reserved; //(1)
    /** @var string 0x002 Name STR */
    public $Name;
    /** @var integer[] 0x01A Allegiances BYTE */
    public $Allegiances;
    /** @var string[] 0x024 EndOfMissionMessages CHAR */
    public $EndOfMissionMessages;
    /** @var integer[] 0x1A4 Unknowns BYTE */
    public $Unknowns;
    /** @var string[] 0x1AA EomVoiceIDs CHAR */
    public $EomVoiceIDs;
    
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

        $this->Reserved = $this->getShort($hex, 0x000);
        $this->Name = $this->getString($hex, 0x002);
        $this->Allegiances = [];
        $offset = 0x01A;
        for ($i = 0; $i < 10; $i++) {
            $t = $this->getByte($hex, $offset);
            $this->Allegiances[] = $t;
            $offset += 1;
        }
        $this->EndOfMissionMessages = [];
        $offset = 0x024;
        for ($i = 0; $i < 6; $i++) {
            $t = $this->getChar($hex, $offset, 64);
            $this->EndOfMissionMessages[] = $t;
            $offset += 64;
        }
        $this->Unknowns = [];
        $offset = 0x1A4;
        for ($i = 0; $i < 6; $i++) {
            $t = $this->getByte($hex, $offset);
            $this->Unknowns[] = $t;
            $offset += 1;
        }
        $this->EomVoiceIDs = [];
        $offset = 0x1AA;
        for ($i = 0; $i < 3; $i++) {
            $t = $this->getChar($hex, $offset, 20);
            $this->EomVoiceIDs[] = $t;
            $offset += 20;
        }
        

        $this->hex = substr($this->hex, 0, $this->getLength());
        return $this;
    }
    
    public function __debugInfo()
    {
        return [
            "Reserved" => $this->Reserved,
            "Name" => $this->Name,
            "Allegiances" => $this->Allegiances,
            "EndOfMissionMessages" => $this->EndOfMissionMessages,
            "Unknowns" => $this->Unknowns,
            "EomVoiceIDs" => $this->EomVoiceIDs
        ];
    }
    
    public function toHexString($hex = null)
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $hex = $this->writeShort($this->Reserved, $hex, 0x000);
        $hex = $this->writeString($this->Name, $hex, 0x002);
        $offset = 0x01A;
        for ($i = 0; $i < 10; $i++) {
            $t = $this->Allegiances[$i];
            $hex = $this->writeByte($t, $hex, $offset);
            $offset += 1;
        }
        $offset = 0x024;
        for ($i = 0; $i < 6; $i++) {
            $t = $this->EndOfMissionMessages[$i];
            $hex = $this->writeChar($t, $hex, $offset);
            $offset += 64;
        }
        $offset = 0x1A4;
        for ($i = 0; $i < 6; $i++) {
            $t = $this->Unknowns[$i];
            $hex = $this->writeByte($t, $hex, $offset);
            $offset += 1;
        }
        $offset = 0x1AA;
        for ($i = 0; $i < 3; $i++) {
            $t = $this->EomVoiceIDs[$i];
            $hex = $this->writeChar($t, $hex, $offset);
            $offset += 20;
        }

        return $hex;
    }
    
    
    public function getLength()
    {
        return self::TEAMLENGTH;
    }
}