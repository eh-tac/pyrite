<?php

namespace Pyrite\XWA\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\PyriteBase;
use Pyrite\XWA\MissionData;

abstract class PilotFileBase extends PyriteBase implements Byteable
{
    use HexDecoder;

    /** @var integer */
    public $PilotFileLength;
    /** @var string */
    public $Name;
    /** @var integer */
    public $TotalScore;
    /** @var integer */
    public $TourOfDutyScore;
    /** @var integer */
    public $AzzameenScore;
    /** @var integer */
    public $SimulatorScore;
    /** @var integer[] */
    public $TourOfDutyKills;
    /** @var integer[] */
    public $AzzameenKills;
    /** @var integer[] */
    public $SimulatorKills;
    /** @var integer[] */
    public $TourOfDutyPartials;
    /** @var integer[] */
    public $AzzameenPartials;
    /** @var integer[] */
    public $SimulatorPartials;
    /** @var integer */
    public $LasersHit;
    /** @var integer */
    public $LasersFired;
    /** @var integer */
    public $WarheadsHit;
    /** @var integer */
    public $WarheadsFired;
    /** @var integer */
    public $CraftLosses;
    /** @var MissionData[] */
    public $MissionData;
    /** @var integer */
    public $CurrentRank;
    /** @var integer */
    public $CurrentMedal;
    /** @var integer */
    public $BonusTen;
    
    public function __construct($hex, $tie = null)
    {
        parent::__construct($hex, $tie);
        $this->beforeConstruct();
        $offset = 0;

        $this->Name = $this->getChar($hex, 0x000, 14);
        $this->TotalScore = $this->getInt($hex, 0x0E);
        $this->TourOfDutyScore = $this->getInt($hex, 0x9E);
        $this->AzzameenScore = $this->getInt($hex, 0xA2);
        $this->SimulatorScore = $this->getInt($hex, 0xA6);
        $this->TourOfDutyKills = [];
        $offset = 0xD2;
        for ($i = 0; $i < 256; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->TourOfDutyKills[] = $t;
            $offset += 4;
        }
        $this->AzzameenKills = [];
        $offset = 0x8CE;
        for ($i = 0; $i < 256; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->AzzameenKills[] = $t;
            $offset += 4;
        }
        $this->SimulatorKills = [];
        $offset = 0x10d2;
        for ($i = 0; $i < 256; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->SimulatorKills[] = $t;
            $offset += 4;
        }
        $this->TourOfDutyPartials = [];
        $offset = 0x18d2;
        for ($i = 0; $i < 256; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->TourOfDutyPartials[] = $t;
            $offset += 4;
        }
        $this->AzzameenPartials = [];
        $offset = 0x20ce;
        for ($i = 0; $i < 256; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->AzzameenPartials[] = $t;
            $offset += 4;
        }
        $this->SimulatorPartials = [];
        $offset = 0x28d2;
        for ($i = 0; $i < 256; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->SimulatorPartials[] = $t;
            $offset += 4;
        }
        $this->LasersHit = $this->getInt($hex, 0x4d36);
        $this->LasersFired = $this->getInt($hex, 0x4d42);
        $this->WarheadsHit = $this->getInt($hex, 0x4d4e);
        $this->WarheadsFired = $this->getInt($hex, 0x4d5a);
        $this->CraftLosses = $this->getInt($hex, 0x4d6e);
        $this->MissionData = [];
        $offset = 0xacfa;
        for ($i = 0; $i < 100; $i++) {
            $t = new MissionData(substr($hex, $offset), $this->TIE);
            $this->MissionData[] = $t;
            $offset += $t->getLength();
        }
        $this->CurrentRank = $this->getInt($hex, 0x10EA2);
        $this->CurrentMedal = $this->getInt($hex, 0x10EA6);
        $this->BonusTen = $this->getInt($hex, 0x1144E);
        $this->PilotFileLength = $offset;
    }
    
    public function __debugInfo()
    {
        return [
            "Name" => $this->Name,
            "TotalScore" => $this->TotalScore,
            "TourOfDutyScore" => $this->TourOfDutyScore,
            "AzzameenScore" => $this->AzzameenScore,
            "SimulatorScore" => $this->SimulatorScore,
            "TourOfDutyKills" => $this->TourOfDutyKills,
            "AzzameenKills" => $this->AzzameenKills,
            "SimulatorKills" => $this->SimulatorKills,
            "TourOfDutyPartials" => $this->TourOfDutyPartials,
            "AzzameenPartials" => $this->AzzameenPartials,
            "SimulatorPartials" => $this->SimulatorPartials,
            "LasersHit" => $this->LasersHit,
            "LasersFired" => $this->LasersFired,
            "WarheadsHit" => $this->WarheadsHit,
            "WarheadsFired" => $this->WarheadsFired,
            "CraftLosses" => $this->CraftLosses,
            "MissionData" => $this->MissionData,
            "CurrentRank" => $this->CurrentRank,
            "CurrentMedal" => $this->CurrentMedal,
            "BonusTen" => $this->BonusTen
        ];
    }
    
    public function toHexString()
    {
        $hex = "";
        $offset = 0;

        $this->writeChar($hex, $this->Name, 0x000);
        $this->writeInt($hex, $this->TotalScore, 0x0E);
        $this->writeInt($hex, $this->TourOfDutyScore, 0x9E);
        $this->writeInt($hex, $this->AzzameenScore, 0xA2);
        $this->writeInt($hex, $this->SimulatorScore, 0xA6);
        $offset = 0xD2;
        for ($i = 0; $i < 256; $i++) {
            $t = $this->TourOfDutyKills[$i];
            $this->writeInt($hex, $t, $offset);
            $offset += 4;
        }
        $offset = 0x8CE;
        for ($i = 0; $i < 256; $i++) {
            $t = $this->AzzameenKills[$i];
            $this->writeInt($hex, $t, $offset);
            $offset += 4;
        }
        $offset = 0x10d2;
        for ($i = 0; $i < 256; $i++) {
            $t = $this->SimulatorKills[$i];
            $this->writeInt($hex, $t, $offset);
            $offset += 4;
        }
        $offset = 0x18d2;
        for ($i = 0; $i < 256; $i++) {
            $t = $this->TourOfDutyPartials[$i];
            $this->writeInt($hex, $t, $offset);
            $offset += 4;
        }
        $offset = 0x20ce;
        for ($i = 0; $i < 256; $i++) {
            $t = $this->AzzameenPartials[$i];
            $this->writeInt($hex, $t, $offset);
            $offset += 4;
        }
        $offset = 0x28d2;
        for ($i = 0; $i < 256; $i++) {
            $t = $this->SimulatorPartials[$i];
            $this->writeInt($hex, $t, $offset);
            $offset += 4;
        }
        $this->writeInt($hex, $this->LasersHit, 0x4d36);
        $this->writeInt($hex, $this->LasersFired, 0x4d42);
        $this->writeInt($hex, $this->WarheadsHit, 0x4d4e);
        $this->writeInt($hex, $this->WarheadsFired, 0x4d5a);
        $this->writeInt($hex, $this->CraftLosses, 0x4d6e);
        $offset = 0xacfa;
        for ($i = 0; $i < 100; $i++) {
            $t = $this->MissionData[$i];
            $this->writeObject($hex, $t, $offset);
            $offset += $t->getLength();
        }
        $this->writeInt($hex, $this->CurrentRank, 0x10EA2);
        $this->writeInt($hex, $this->CurrentMedal, 0x10EA6);
        $this->writeInt($hex, $this->BonusTen, 0x1144E);

        return $hex;
    }
    
    
    public function getLength()
    {
        return $this->PilotFileLength;
    }
}