<?php

namespace Pyrite\TIE\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\PyriteBase;
use Pyrite\TIE\Constants;

abstract class FileHeaderBase extends PyriteBase implements Byteable
{
    use HexDecoder;

    /** @var integer */
    public const FILEHEADERLENGTH = 458;
    /** @var integer */
    public const PlatformID = -1;
    /** @var integer */
    public $NumFGs;
    /** @var integer */
    public $NumMessages;
    /** @var integer */
    public const NumGGs = 3; //might be # of GlobalGoals
    /** @var integer */
    public $Unknown1;
    /** @var boolean */
    public $Unknown2;
    /** @var integer */
    public $BriefingOfficers;
    /** @var boolean */
    public $CapturedOnEject;
    /** @var string[] */
    public $EndOfMissionMessages;
    /** @var string[] */
    public $OtherIffNames;
    
    public function __construct($hex, $tie = null)
    {
        parent::__construct($hex, $tie);
        $this->beforeConstruct();
        $offset = 0;

        // static SHORT value PlatformID = -1
        $this->NumFGs = $this->getShort($hex, 0x002);
        $this->NumMessages = $this->getShort($hex, 0x004);
        // static SHORT value NumGGs = 3
        $this->Unknown1 = $this->getByte($hex, 0x008);
        $this->Unknown2 = $this->getBool($hex, 0x009);
        $this->BriefingOfficers = $this->getByte($hex, 0x00A);
        $this->CapturedOnEject = $this->getBool($hex, 0x00D);
        $this->EndOfMissionMessages = [];
        $offset = 0x018;
        for ($i = 0; $i < 6; $i++) {
            $t = $this->getChar($hex, $offset, 64);
            $this->EndOfMissionMessages[] = $t;
            $offset += 64;
        }
        $this->OtherIffNames = [];
        $offset = 0x19A;
        for ($i = 0; $i < 4; $i++) {
            $t = $this->getChar($hex, $offset, 12);
            $this->OtherIffNames[] = $t;
            $offset += 12;
        }
        
    }
    
    public function __debugInfo()
    {
        return [
            "NumFGs" => $this->NumFGs,
            "NumMessages" => $this->NumMessages,
            "Unknown1" => $this->Unknown1,
            "Unknown2" => $this->Unknown2,
            "BriefingOfficers" => $this->getBriefingOfficersLabel(),
            "CapturedOnEject" => $this->CapturedOnEject,
            "EndOfMissionMessages" => $this->EndOfMissionMessages,
            "OtherIffNames" => $this->OtherIffNames
        ];
    }
    
    public function toHexString()
    {
        $hex = "";
        $offset = 0;

        $this->writeShort($hex, -1, 0x000);
        $this->writeShort($hex, $this->NumFGs, 0x002);
        $this->writeShort($hex, $this->NumMessages, 0x004);
        $this->writeShort($hex, 3, 0x006);
        $this->writeByte($hex, $this->Unknown1, 0x008);
        $this->writeBool($hex, $this->Unknown2, 0x009);
        $this->writeByte($hex, $this->BriefingOfficers, 0x00A);
        $this->writeBool($hex, $this->CapturedOnEject, 0x00D);
        $offset = 0x018;
        for ($i = 0; $i < 6; $i++) {
            $t = $this->EndOfMissionMessages[$i];
            $this->writeChar($hex, $t, $offset);
            $offset += 64;
        }
        $offset = 0x19A;
        for ($i = 0; $i < 4; $i++) {
            $t = $this->OtherIffNames[$i];
            $this->writeChar($hex, $t, $offset);
            $offset += 12;
        }

        return $hex;
    }
    
    public function getBriefingOfficersLabel() 
    {
        return isset($this->BriefingOfficers) && isset(Constants::$BRIEFINGOFFICERS[$this->BriefingOfficers]) ? Constants::$BRIEFINGOFFICERS[$this->BriefingOfficers] : "Unknown";
    }
    
    public function getLength()
    {
        return self::FILEHEADERLENGTH;
    }
}