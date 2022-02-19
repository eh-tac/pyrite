<?php

namespace Pyrite\XWA\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\PyriteBase;

abstract class TeamBase extends PyriteBase implements Byteable
{
    use HexDecoder;

    /** @var integer */
    public const TEAMLENGTH = 487;
    /** @var integer */
    public $Reserved; //(1)
    /** @var string */
    public $Name;
    /** @var integer[] */
    public $Allegiances;
    /** @var string[] */
    public $EndOfMissionMessages;
    /** @var integer[] */
    public $Unknowns;
    /** @var string[] */
    public $EomVoiceIDs;
    
    public function __construct($hex, $tie = null)
    {
        parent::__construct($hex, $tie);
        $this->beforeConstruct();
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
    
    public function toHexString()
    {
        $hex = "";
        $offset = 0;

        $this->writeShort($hex, $this->Reserved, 0x000);
        $this->writeString($hex, $this->Name, 0x002);
        $offset = 0x01A;
        for ($i = 0; $i < 10; $i++) {
            $t = $this->Allegiances[$i];
            $this->writeByte($hex, $t, $offset);
            $offset += 1;
        }
        $offset = 0x024;
        for ($i = 0; $i < 6; $i++) {
            $t = $this->EndOfMissionMessages[$i];
            $this->writeChar($hex, $t, $offset);
            $offset += 64;
        }
        $offset = 0x1A4;
        for ($i = 0; $i < 6; $i++) {
            $t = $this->Unknowns[$i];
            $this->writeByte($hex, $t, $offset);
            $offset += 1;
        }
        $offset = 0x1AA;
        for ($i = 0; $i < 3; $i++) {
            $t = $this->EomVoiceIDs[$i];
            $this->writeChar($hex, $t, $offset);
            $offset += 20;
        }

        return $hex;
    }
    
    
    public function getLength()
    {
        return self::TEAMLENGTH;
    }
}