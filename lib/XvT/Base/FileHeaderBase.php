<?php

namespace Pyrite\XvT\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;

abstract class FileHeaderBase extends PyriteBase implements Byteable
{
    use HexDecoder;
    use HexEncoder;

    /** @var integer  FILEHEADERLENGTH INT */
    public const FILEHEADERLENGTH = 164;
    /** @var integer 0x00 PlatformID SHORT */
    public $PlatformID;
    /** @var integer 0x02 NumFGs SHORT */
    public $NumFGs;
    /** @var integer 0x04 NumMessages SHORT */
    public $NumMessages;
    /** @var integer 0x06 Unknown1 BYTE */
    public $Unknown1;
    /** @var integer 0x08 Unknown2 BYTE */
    public $Unknown2;
    /** @var boolean 0x0B Unknown3 BOOL */
    public $Unknown3;
    /** @var string 0x28 Unknown4 CHAR */
    public $Unknown4;
    /** @var string 0x50 Unknown5 CHAR */
    public $Unknown5;
    /** @var integer 0x64 MissionType BYTE */
    public $MissionType;
    /** @var boolean 0x65 Unknown6 BOOL */
    public $Unknown6;
    /** @var integer 0x66 TimeLimitMinutes BYTE */
    public $TimeLimitMinutes;
    /** @var integer 0x67 TimeLimitSeconds BYTE */
    public $TimeLimitSeconds;
    
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

        $this->PlatformID = $this->getShort($hex, 0x00);
        $this->NumFGs = $this->getShort($hex, 0x02);
        $this->NumMessages = $this->getShort($hex, 0x04);
        $this->Unknown1 = $this->getByte($hex, 0x06);
        $this->Unknown2 = $this->getByte($hex, 0x08);
        $this->Unknown3 = $this->getBool($hex, 0x0B);
        $this->Unknown4 = $this->getChar($hex, 0x28, 16);
        $this->Unknown5 = $this->getChar($hex, 0x50, 16);
        $this->MissionType = $this->getByte($hex, 0x64);
        $this->Unknown6 = $this->getBool($hex, 0x65);
        $this->TimeLimitMinutes = $this->getByte($hex, 0x66);
        $this->TimeLimitSeconds = $this->getByte($hex, 0x67);
        
        return $this;
    }
    
    public function __debugInfo()
    {
        return [
            "PlatformID" => $this->PlatformID,
            "NumFGs" => $this->NumFGs,
            "NumMessages" => $this->NumMessages,
            "Unknown1" => $this->Unknown1,
            "Unknown2" => $this->Unknown2,
            "Unknown3" => $this->Unknown3,
            "Unknown4" => $this->Unknown4,
            "Unknown5" => $this->Unknown5,
            "MissionType" => $this->MissionType,
            "Unknown6" => $this->Unknown6,
            "TimeLimitMinutes" => $this->TimeLimitMinutes,
            "TimeLimitSeconds" => $this->TimeLimitSeconds
        ];
    }
    
    public function toHexString($hex = null)
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        [$hex, $offset] = $this->writeShort($this->PlatformID, $hex, 0x00);
        [$hex, $offset] = $this->writeShort($this->NumFGs, $hex, 0x02);
        [$hex, $offset] = $this->writeShort($this->NumMessages, $hex, 0x04);
        [$hex, $offset] = $this->writeByte($this->Unknown1, $hex, 0x06);
        [$hex, $offset] = $this->writeByte($this->Unknown2, $hex, 0x08);
        [$hex, $offset] = $this->writeBool($this->Unknown3, $hex, 0x0B);
        [$hex, $offset] = $this->writeChar($this->Unknown4, $hex, 0x28);
        [$hex, $offset] = $this->writeChar($this->Unknown5, $hex, 0x50);
        [$hex, $offset] = $this->writeByte($this->MissionType, $hex, 0x64);
        [$hex, $offset] = $this->writeBool($this->Unknown6, $hex, 0x65);
        [$hex, $offset] = $this->writeByte($this->TimeLimitMinutes, $hex, 0x66);
        [$hex, $offset] = $this->writeByte($this->TimeLimitSeconds, $hex, 0x67);

        return $hex;
    }
    
    
    public function getLength()
    {
        return self::FILEHEADERLENGTH;
    }
}