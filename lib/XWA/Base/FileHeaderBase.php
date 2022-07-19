<?php

namespace Pyrite\XWA\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;
use Pyrite\XWA\Constants;
use Pyrite\XWA\GlobalCargo;

abstract class FileHeaderBase extends PyriteBase implements Byteable
{
    use HexDecoder;
    use HexEncoder;

    /** @var integer  FILEHEADERLENGTH INT */
    public const FILEHEADERLENGTH = 9200;
    /** @var integer 0x0000 PlatformID SHORT */
    public $PlatformID; //(0x20)
    /** @var integer 0x0002 NumFGs SHORT */
    public $NumFGs;
    /** @var integer 0x0004 NumMessages SHORT */
    public $NumMessages;
    /** @var boolean 0x0008 Unknown1 BOOL */
    public $Unknown1;
    /** @var boolean 0x000B Unknown2 BOOL */
    public $Unknown2;
    /** @var string[] 0x0014 IffNames STR */
    public $IffNames;
    /** @var string[] 0x0064 RegionNames STR */
    public $RegionNames;
    /** @var GlobalCargo[] 0x0274 GlobalCargo GlobalCargo */
    public $GlobalCargo;
    /** @var string[] 0x0B34 GlobalGroupNames STR */
    public $GlobalGroupNames;
    /** @var integer 0x23AC Hangar BYTE */
    public $Hangar;
    /** @var integer 0x23AE TimeLimitMinutes BYTE */
    public $TimeLimitMinutes;
    /** @var boolean 0x23AF EndMissionWhenComplete BOOL */
    public $EndMissionWhenComplete;
    /** @var integer 0x23B0 BriefingOfficer BYTE */
    public $BriefingOfficer;
    /** @var integer 0x23B1 BriefingLogo BYTE */
    public $BriefingLogo;
    /** @var integer 0x23B3 Unknown3 BYTE */
    public $Unknown3;
    /** @var integer 0x23B4 Unknown4 BYTE */
    public $Unknown4;
    /** @var integer 0x23B5 Unknown5 BYTE */
    public $Unknown5;
    
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

        $this->PlatformID = $this->getShort($hex, 0x0000);
        $this->NumFGs = $this->getShort($hex, 0x0002);
        $this->NumMessages = $this->getShort($hex, 0x0004);
        $this->Unknown1 = $this->getBool($hex, 0x0008);
        $this->Unknown2 = $this->getBool($hex, 0x000B);
        $this->IffNames = [];
        $offset = 0x0014;
        for ($i = 0; $i < 4; $i++) {
            $t = $this->getString($hex, $offset);
            $this->IffNames[] = $t;
            $offset += strlen($t);
        }
        $this->RegionNames = [];
        $offset = 0x0064;
        for ($i = 0; $i < 4; $i++) {
            $t = $this->getString($hex, $offset);
            $this->RegionNames[] = $t;
            $offset += strlen($t);
        }
        $this->GlobalCargo = [];
        $offset = 0x0274;
        for ($i = 0; $i < 16; $i++) {
            $t = (new GlobalCargo(substr($hex, $offset), $this->TIE))->loadHex();
            $this->GlobalCargo[] = $t;
            $offset += $t->getLength();
        }
        $this->GlobalGroupNames = [];
        $offset = 0x0B34;
        for ($i = 0; $i < 16; $i++) {
            $t = $this->getString($hex, $offset);
            $this->GlobalGroupNames[] = $t;
            $offset += strlen($t);
        }
        $this->Hangar = $this->getByte($hex, 0x23AC);
        $this->TimeLimitMinutes = $this->getByte($hex, 0x23AE);
        $this->EndMissionWhenComplete = $this->getBool($hex, 0x23AF);
        $this->BriefingOfficer = $this->getByte($hex, 0x23B0);
        $this->BriefingLogo = $this->getByte($hex, 0x23B1);
        $this->Unknown3 = $this->getByte($hex, 0x23B3);
        $this->Unknown4 = $this->getByte($hex, 0x23B4);
        $this->Unknown5 = $this->getByte($hex, 0x23B5);
        

        $this->hex = substr($this->hex, 0, $this->getLength());
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
            "IffNames" => $this->IffNames,
            "RegionNames" => $this->RegionNames,
            "GlobalCargo" => $this->GlobalCargo,
            "GlobalGroupNames" => $this->GlobalGroupNames,
            "Hangar" => $this->getHangarLabel(),
            "TimeLimitMinutes" => $this->TimeLimitMinutes,
            "EndMissionWhenComplete" => $this->EndMissionWhenComplete,
            "BriefingOfficer" => $this->getBriefingOfficerLabel(),
            "BriefingLogo" => $this->getBriefingLogoLabel(),
            "Unknown3" => $this->Unknown3,
            "Unknown4" => $this->Unknown4,
            "Unknown5" => $this->Unknown5
        ];
    }
    
    public function toHexString($hex = null)
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $hex = $this->writeShort($this->PlatformID, $hex, 0x0000);
        $hex = $this->writeShort($this->NumFGs, $hex, 0x0002);
        $hex = $this->writeShort($this->NumMessages, $hex, 0x0004);
        $hex = $this->writeBool($this->Unknown1, $hex, 0x0008);
        $hex = $this->writeBool($this->Unknown2, $hex, 0x000B);
        $offset = 0x0014;
        for ($i = 0; $i < 4; $i++) {
            $t = $this->IffNames[$i];
            $hex = $this->writeString($t, $hex, $offset);
            $offset += strlen($t);
        }
        $offset = 0x0064;
        for ($i = 0; $i < 4; $i++) {
            $t = $this->RegionNames[$i];
            $hex = $this->writeString($t, $hex, $offset);
            $offset += strlen($t);
        }
        $offset = 0x0274;
        for ($i = 0; $i < 16; $i++) {
            $t = $this->GlobalCargo[$i];
            $hex = $this->writeObject($t, $hex, $offset);
            $offset += $t->getLength();
        }
        $offset = 0x0B34;
        for ($i = 0; $i < 16; $i++) {
            $t = $this->GlobalGroupNames[$i];
            $hex = $this->writeString($t, $hex, $offset);
            $offset += strlen($t);
        }
        $hex = $this->writeByte($this->Hangar, $hex, 0x23AC);
        $hex = $this->writeByte($this->TimeLimitMinutes, $hex, 0x23AE);
        $hex = $this->writeBool($this->EndMissionWhenComplete, $hex, 0x23AF);
        $hex = $this->writeByte($this->BriefingOfficer, $hex, 0x23B0);
        $hex = $this->writeByte($this->BriefingLogo, $hex, 0x23B1);
        $hex = $this->writeByte($this->Unknown3, $hex, 0x23B3);
        $hex = $this->writeByte($this->Unknown4, $hex, 0x23B4);
        $hex = $this->writeByte($this->Unknown5, $hex, 0x23B5);

        return $hex;
    }
    
    public function getHangarLabel() 
    {
        return isset($this->Hangar) && isset(Constants::$HANGAR[$this->Hangar]) ? Constants::$HANGAR[$this->Hangar] : "Unknown";
    }

    public function getBriefingOfficerLabel() 
    {
        return isset($this->BriefingOfficer) && isset(Constants::$BRIEFINGOFFICER[$this->BriefingOfficer]) ? Constants::$BRIEFINGOFFICER[$this->BriefingOfficer] : "Unknown";
    }

    public function getBriefingLogoLabel() 
    {
        return isset($this->BriefingLogo) && isset(Constants::$BRIEFINGLOGO[$this->BriefingLogo]) ? Constants::$BRIEFINGLOGO[$this->BriefingLogo] : "Unknown";
    }
    
    public function getLength()
    {
        return self::FILEHEADERLENGTH;
    }
}