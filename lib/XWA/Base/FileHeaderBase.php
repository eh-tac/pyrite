<?php

namespace Pyrite\XWA\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;
use Pyrite\XWA\Constants;
use Pyrite\XWA\GlobalCargo;
use Pyrite\XWA\GlobalUnit;
use Pyrite\XWA\Region;

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
    /** @var integer 0x0006 TimeLimitMin BYTE */
    public $TimeLimitMin;
    /** @var integer 0x0007 TimeLimitSec BYTE */
    public $TimeLimitSec;
    /** @var integer 0x0008 WinType BYTE */
    public $WinType; //(was Unknown1, default 1)
    /** @var integer 0x0009 Backdrop BYTE */
    public $Backdrop;
    /** @var integer 0x000A Rescue BYTE */
    public $Rescue;
    /** @var integer 0x000B AllWayShown BYTE */
    public $AllWayShown; //(was Unknown2, probably editor only)
    /** @var integer[] 0x000C Vars BYTE */
    public $Vars;
    /** @var string[] 0x0014 IffNames STR */
    public $IffNames;
    /** @var Region[] 0x0064 Regions Region */
    public $Regions;
    /** @var GlobalCargo[] 0x0274 GlobalCargo GlobalCargo */
    public $GlobalCargo;
    /** @var GlobalUnit[] 0x0B34 GlobalGroups GlobalUnit */
    public $GlobalGroups;
    /** @var GlobalUnit[] 0x1614 GlobalUnits GlobalUnit */
    public $GlobalUnits;
    /** @var integer 0x23AC Hangar BYTE */
    public $Hangar;
    /** @var boolean 0x23AD GoalsUnimportant BOOL */
    public $GoalsUnimportant;
    /** @var integer 0x23AE TimeLimitMinutes BYTE */
    public $TimeLimitMinutes;
    /** @var boolean 0x23AF EndMissionWhenComplete BOOL */
    public $EndMissionWhenComplete;
    /** @var integer 0x23B0 BriefingOfficer BYTE */
    public $BriefingOfficer;
    /** @var integer 0x23B1 BriefingLogo BYTE */
    public $BriefingLogo; //(also known as CommandOfficer)
    /** @var integer 0x23B2 BriefingOfficerEntryLine BYTE */
    public $BriefingOfficerEntryLine;
    /** @var integer 0x23B3 SecondaryVersion BYTE */
    public $SecondaryVersion; //(0x62 'b', was Unknown3, might be editor only)
    /** @var integer 0x23B4 WinOfficer BYTE */
    public $WinOfficer; //(was Unknown4)
    /** @var integer 0x23B5 FailOfficer BYTE */
    public $FailOfficer; //(was Unknown5)
    
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
        $this->TimeLimitMin = $this->getByte($hex, 0x0006);
        $this->TimeLimitSec = $this->getByte($hex, 0x0007);
        $this->WinType = $this->getByte($hex, 0x0008);
        $this->Backdrop = $this->getByte($hex, 0x0009);
        $this->Rescue = $this->getByte($hex, 0x000A);
        $this->AllWayShown = $this->getByte($hex, 0x000B);
        $this->Vars = [];
        $offset = 0x000C;
        for ($i = 0; $i < 8; $i++) {
            $t = $this->getByte($hex, $offset);
            $this->Vars[] = $t;
            $offset += 1;
        }
        $this->IffNames = [];
        $offset = 0x0014;
        for ($i = 0; $i < 4; $i++) {
            $t = $this->getString($hex, $offset);
            $this->IffNames[] = $t;
            $offset += strlen($t);
        }
        $this->Regions = [];
        $offset = 0x0064;
        for ($i = 0; $i < 4; $i++) {
            $t = (new Region(substr($hex, $offset), $this->TIE))->loadHex();
            $this->Regions[] = $t;
            $offset += $t->getLength();
        }
        $this->GlobalCargo = [];
        $offset = 0x0274;
        for ($i = 0; $i < 16; $i++) {
            $t = (new GlobalCargo(substr($hex, $offset), $this->TIE))->loadHex();
            $this->GlobalCargo[] = $t;
            $offset += $t->getLength();
        }
        $this->GlobalGroups = [];
        $offset = 0x0B34;
        for ($i = 0; $i < 32; $i++) {
            $t = (new GlobalUnit(substr($hex, $offset), $this->TIE))->loadHex();
            $this->GlobalGroups[] = $t;
            $offset += $t->getLength();
        }
        $this->GlobalUnits = [];
        $offset = 0x1614;
        for ($i = 0; $i < 40; $i++) {
            $t = (new GlobalUnit(substr($hex, $offset), $this->TIE))->loadHex();
            $this->GlobalUnits[] = $t;
            $offset += $t->getLength();
        }
        $this->Hangar = $this->getByte($hex, 0x23AC);
        $this->GoalsUnimportant = $this->getBool($hex, 0x23AD);
        $this->TimeLimitMinutes = $this->getByte($hex, 0x23AE);
        $this->EndMissionWhenComplete = $this->getBool($hex, 0x23AF);
        $this->BriefingOfficer = $this->getByte($hex, 0x23B0);
        $this->BriefingLogo = $this->getByte($hex, 0x23B1);
        $this->BriefingOfficerEntryLine = $this->getByte($hex, 0x23B2);
        $this->SecondaryVersion = $this->getByte($hex, 0x23B3);
        $this->WinOfficer = $this->getByte($hex, 0x23B4);
        $this->FailOfficer = $this->getByte($hex, 0x23B5);
        

        $this->hex = substr($this->hex, 0, $this->getLength());
        return $this;
    }
    
    public function __debugInfo()
    {
        return [
            "PlatformID" => $this->PlatformID,
            "NumFGs" => $this->NumFGs,
            "NumMessages" => $this->NumMessages,
            "TimeLimitMin" => $this->TimeLimitMin,
            "TimeLimitSec" => $this->TimeLimitSec,
            "WinType" => $this->WinType,
            "Backdrop" => $this->Backdrop,
            "Rescue" => $this->Rescue,
            "AllWayShown" => $this->AllWayShown,
            "Vars" => $this->Vars,
            "IffNames" => $this->IffNames,
            "Regions" => $this->Regions,
            "GlobalCargo" => $this->GlobalCargo,
            "GlobalGroups" => $this->GlobalGroups,
            "GlobalUnits" => $this->GlobalUnits,
            "Hangar" => $this->getHangarLabel(),
            "GoalsUnimportant" => $this->GoalsUnimportant,
            "TimeLimitMinutes" => $this->TimeLimitMinutes,
            "EndMissionWhenComplete" => $this->EndMissionWhenComplete,
            "BriefingOfficer" => $this->getBriefingOfficerLabel(),
            "BriefingLogo" => $this->getBriefingLogoLabel(),
            "BriefingOfficerEntryLine" => $this->BriefingOfficerEntryLine,
            "SecondaryVersion" => $this->SecondaryVersion,
            "WinOfficer" => $this->getWinOfficerLabel(),
            "FailOfficer" => $this->getFailOfficerLabel()
        ];
    }
    
    public function toHexString($hex = null)
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $hex = $this->writeShort($this->PlatformID, $hex, 0x0000);
        $hex = $this->writeShort($this->NumFGs, $hex, 0x0002);
        $hex = $this->writeShort($this->NumMessages, $hex, 0x0004);
        $hex = $this->writeByte($this->TimeLimitMin, $hex, 0x0006);
        $hex = $this->writeByte($this->TimeLimitSec, $hex, 0x0007);
        $hex = $this->writeByte($this->WinType, $hex, 0x0008);
        $hex = $this->writeByte($this->Backdrop, $hex, 0x0009);
        $hex = $this->writeByte($this->Rescue, $hex, 0x000A);
        $hex = $this->writeByte($this->AllWayShown, $hex, 0x000B);
        $offset = 0x000C;
        for ($i = 0; $i < 8; $i++) {
            $t = $this->Vars[$i];
            $hex = $this->writeByte($t, $hex, $offset);
            $offset += 1;
        }
        $offset = 0x0014;
        for ($i = 0; $i < 4; $i++) {
            $t = $this->IffNames[$i];
            $hex = $this->writeString($t, $hex, $offset);
            $offset += strlen($t);
        }
        $offset = 0x0064;
        for ($i = 0; $i < 4; $i++) {
            $t = $this->Regions[$i];
            $hex = $this->writeObject($t, $hex, $offset);
            $offset += $t->getLength();
        }
        $offset = 0x0274;
        for ($i = 0; $i < 16; $i++) {
            $t = $this->GlobalCargo[$i];
            $hex = $this->writeObject($t, $hex, $offset);
            $offset += $t->getLength();
        }
        $offset = 0x0B34;
        for ($i = 0; $i < 32; $i++) {
            $t = $this->GlobalGroups[$i];
            $hex = $this->writeObject($t, $hex, $offset);
            $offset += $t->getLength();
        }
        $offset = 0x1614;
        for ($i = 0; $i < 40; $i++) {
            $t = $this->GlobalUnits[$i];
            $hex = $this->writeObject($t, $hex, $offset);
            $offset += $t->getLength();
        }
        $hex = $this->writeByte($this->Hangar, $hex, 0x23AC);
        $hex = $this->writeBool($this->GoalsUnimportant, $hex, 0x23AD);
        $hex = $this->writeByte($this->TimeLimitMinutes, $hex, 0x23AE);
        $hex = $this->writeBool($this->EndMissionWhenComplete, $hex, 0x23AF);
        $hex = $this->writeByte($this->BriefingOfficer, $hex, 0x23B0);
        $hex = $this->writeByte($this->BriefingLogo, $hex, 0x23B1);
        $hex = $this->writeByte($this->BriefingOfficerEntryLine, $hex, 0x23B2);
        $hex = $this->writeByte($this->SecondaryVersion, $hex, 0x23B3);
        $hex = $this->writeByte($this->WinOfficer, $hex, 0x23B4);
        $hex = $this->writeByte($this->FailOfficer, $hex, 0x23B5);

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

    public function getWinOfficerLabel() 
    {
        return isset($this->WinOfficer) && isset(Constants::$BRIEFINGOFFICER[$this->WinOfficer]) ? Constants::$BRIEFINGOFFICER[$this->WinOfficer] : "Unknown";
    }

    public function getFailOfficerLabel() 
    {
        return isset($this->FailOfficer) && isset(Constants::$BRIEFINGOFFICER[$this->FailOfficer]) ? Constants::$BRIEFINGOFFICER[$this->FailOfficer] : "Unknown";
    }
    
    public function getLength()
    {
        return self::FILEHEADERLENGTH;
    }
}