<?php

namespace Pyrite\XWA\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\PyriteBase;
use Pyrite\XWA\Constants;
use Pyrite\XWA\GlobalCargo;

abstract class FileHeaderBase extends PyriteBase implements Byteable
{
    use HexDecoder;

    /** @var integer */
    public const FILEHEADERLENGTH = 9200;
    /** @var integer */
    public $PlatformID; //(0x20)
    /** @var integer */
    public $NumFGs;
    /** @var integer */
    public $NumMessages;
    /** @var boolean */
    public $Unknown1;
    /** @var boolean */
    public $Unknown2;
    /** @var string[] */
    public $IffNames;
    /** @var string[] */
    public $RegionNames;
    /** @var GlobalCargo[] */
    public $Unnamed;
    /** @var string[] */
    public $GlobalGroupNames;
    /** @var integer */
    public $Hangar;
    /** @var integer */
    public $TimeLimitMinutes;
    /** @var boolean */
    public $EndMissionWhenComplete;
    /** @var integer */
    public $BriefingOfficer;
    /** @var integer */
    public $BriefingLogo;
    /** @var integer */
    public $Unknown3;
    /** @var integer */
    public $Unknown4;
    /** @var integer */
    public $Unknown5;
    
    public function __construct($hex, $tie = null)
    {
        parent::__construct($hex, $tie);
        $this->beforeConstruct();
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
        $this->Unnamed = [];
        $offset = 0x0274;
        for ($i = 0; $i < 16; $i++) {
            $t = new GlobalCargo(substr($hex, $offset), $this->TIE);
            $this->Unnamed[] = $t;
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
            "Unnamed" => $this->Unnamed,
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
    
    public function toHexString()
    {
        $hex = "";
        $offset = 0;

        $this->writeShort($hex, $this->PlatformID, 0x0000);
        $this->writeShort($hex, $this->NumFGs, 0x0002);
        $this->writeShort($hex, $this->NumMessages, 0x0004);
        $this->writeBool($hex, $this->Unknown1, 0x0008);
        $this->writeBool($hex, $this->Unknown2, 0x000B);
        $offset = 0x0014;
        for ($i = 0; $i < 4; $i++) {
            $t = $this->IffNames[$i];
            $this->writeString($hex, $t, $offset);
            $offset += strlen($t);
        }
        $offset = 0x0064;
        for ($i = 0; $i < 4; $i++) {
            $t = $this->RegionNames[$i];
            $this->writeString($hex, $t, $offset);
            $offset += strlen($t);
        }
        $offset = 0x0274;
        for ($i = 0; $i < 16; $i++) {
            $t = $this->Unnamed[$i];
            $this->writeObject($hex, $t, $offset);
            $offset += $t->getLength();
        }
        $offset = 0x0B34;
        for ($i = 0; $i < 16; $i++) {
            $t = $this->GlobalGroupNames[$i];
            $this->writeString($hex, $t, $offset);
            $offset += strlen($t);
        }
        $this->writeByte($hex, $this->Hangar, 0x23AC);
        $this->writeByte($hex, $this->TimeLimitMinutes, 0x23AE);
        $this->writeBool($hex, $this->EndMissionWhenComplete, 0x23AF);
        $this->writeByte($hex, $this->BriefingOfficer, 0x23B0);
        $this->writeByte($hex, $this->BriefingLogo, 0x23B1);
        $this->writeByte($hex, $this->Unknown3, 0x23B3);
        $this->writeByte($hex, $this->Unknown4, 0x23B4);
        $this->writeByte($hex, $this->Unknown5, 0x23B5);

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