<?php

namespace Pyrite\XvT\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\PyriteBase;

abstract class FileHeaderBase extends PyriteBase implements Byteable
{
    use HexDecoder;

    /** @var integer */
    public const FILEHEADERLENGTH = 164;
    /** @var integer */
    public $PlatformID;
    /** @var integer */
    public $NumFGs;
    /** @var integer */
    public $NumMessages;
    /** @var integer */
    public $Unknown1;
    /** @var integer */
    public $Unknown2;
    /** @var boolean */
    public $Unknown3;
    /** @var string */
    public $Unknown4;
    /** @var string */
    public $Unknown5;
    /** @var integer */
    public $MissionType;
    /** @var boolean */
    public $Unknown6;
    /** @var integer */
    public $TimeLimitMinutes;
    /** @var integer */
    public $TimeLimitSeconds;
    
    public function __construct($hex, $tie = null)
    {
        parent::__construct($hex, $tie);
        $this->beforeConstruct();
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
    
    public function toHexString()
    {
        $hex = "";
        $offset = 0;

        $this->writeShort($hex, $this->PlatformID, 0x00);
        $this->writeShort($hex, $this->NumFGs, 0x02);
        $this->writeShort($hex, $this->NumMessages, 0x04);
        $this->writeByte($hex, $this->Unknown1, 0x06);
        $this->writeByte($hex, $this->Unknown2, 0x08);
        $this->writeBool($hex, $this->Unknown3, 0x0B);
        $this->writeChar($hex, $this->Unknown4, 0x28);
        $this->writeChar($hex, $this->Unknown5, 0x50);
        $this->writeByte($hex, $this->MissionType, 0x64);
        $this->writeBool($hex, $this->Unknown6, 0x65);
        $this->writeByte($hex, $this->TimeLimitMinutes, 0x66);
        $this->writeByte($hex, $this->TimeLimitSeconds, 0x67);

        return $hex;
    }
    
    
    public function getLength()
    {
        return self::FILEHEADERLENGTH;
    }
}