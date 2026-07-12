<?php

namespace Pyrite\XWA\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;
use Pyrite\PyriteModel;
use Pyrite\XWA\MissionData;

abstract class PilotFileBase extends PyriteBase implements Byteable, PyriteModel
{
    use HexDecoder;
    use HexEncoder;

    /** @var int PILOTFILELENGTH INT */
	public const PILOTFILELENGTH = 152076;
    /** @var string 0x00 Name CHAR */
	public string $Name;
    /** @var int 0x0E TotalScore INT */
	public int $TotalScore;
    /** @var string 0x4A MPName CHAR */
	public string $MPName;
    /** @var string 0x6A MPGameName CHAR */
	public string $MPGameName;
    /** @var int 0x9A ToNextRanking INT */
	public int $ToNextRanking;
    /** @var int 0x9E TourOfDutyScore INT */
	public int $TourOfDutyScore;
    /** @var int 0xA2 AzzameenScore INT */
	public int $AzzameenScore;
    /** @var int 0xA6 SimulatorScore INT */
	public int $SimulatorScore;
    /** @var array<int> 0xD2 TourOfDutyKills INT */
	public array $TourOfDutyKills;
    /** @var array<int> 0x8CE AzzameenKills INT */
	public array $AzzameenKills;
    /** @var array<int> 0x10d2 SimulatorKills INT */
	public array $SimulatorKills;
    /** @var array<int> 0x18d2 TourOfDutyPartials INT */
	public array $TourOfDutyPartials;
    /** @var array<int> 0x20ce AzzameenPartials INT */
	public array $AzzameenPartials;
    /** @var array<int> 0x28d2 SimulatorPartials INT */
	public array $SimulatorPartials;
    /** @var int 0x4d36 LasersHit INT */
	public int $LasersHit;
    /** @var int 0x4d42 LasersFired INT */
	public int $LasersFired;
    /** @var int 0x4d4e WarheadsHit INT */
	public int $WarheadsHit;
    /** @var int 0x4d5a WarheadsFired INT */
	public int $WarheadsFired;
    /** @var int 0x4d66 CraftLosses INT */
	public int $CraftLosses;
    /** @var array<MissionData> 0xACFA MissionData MissionData */
	public array $MissionData;
    /** @var int 0x10EA2 CurrentRank INT */
	public int $CurrentRank;
    /** @var int 0x10EA6 CurrentMedal INT */
	public int $CurrentMedal;
    /** @var int 0x1144E BonusTen INT */
	public int $BonusTen;
    
    public function __construct(string $hex = null, ?PyriteModel $TIE = null)
    {
        parent::__construct($hex, $TIE);
    }

    /**
     * Process the $hex string provided in the constructor.
     * Separating the constructor and loading allows for the objects to be made from scratch.
     * @return $this 
     */
    public function loadHex(): static
    {
        $hex = $this->hex;
        $offset = 0;

        $this->Name = $this->getChar($hex, 0x00, 14);
        $this->TotalScore = $this->getInt($hex, 0x0E);
        $this->MPName = $this->getChar($hex, 0x4A, 32);
        $this->MPGameName = $this->getChar($hex, 0x6A, 32);
        $this->ToNextRanking = $this->getInt($hex, 0x9A);
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
        $this->CraftLosses = $this->getInt($hex, 0x4d66);
        $this->MissionData = [];
        $offset = 0xACFA;
        for ($i = 0; $i < 200; $i++) {
            $t = (new MissionData(substr($hex, $offset), $this->TIE))->loadHex();
            $this->MissionData[] = $t;
            $offset += $t->getLength();
        }
        $this->CurrentRank = $this->getInt($hex, 0x10EA2);
        $this->CurrentMedal = $this->getInt($hex, 0x10EA6);
        $this->BonusTen = $this->getInt($hex, 0x1144E);
        

        $this->hex = substr($this->hex, 0, $this->getLength());
        $this->afterLoadHex();
        return $this;
    }
    
    public function __debugInfo(): array
    {
        return [
            "Name" => $this->Name,
            "TotalScore" => $this->TotalScore,
            "MPName" => $this->MPName,
            "MPGameName" => $this->MPGameName,
            "ToNextRanking" => $this->ToNextRanking,
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
    
    public function toHexString($hex = null): string
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $hex = $this->writeChar($this->Name, $hex, 0x00);
        $hex = $this->writeInt($this->TotalScore, $hex, 0x0E);
        $hex = $this->writeChar($this->MPName, $hex, 0x4A);
        $hex = $this->writeChar($this->MPGameName, $hex, 0x6A);
        $hex = $this->writeInt($this->ToNextRanking, $hex, 0x9A);
        $hex = $this->writeInt($this->TourOfDutyScore, $hex, 0x9E);
        $hex = $this->writeInt($this->AzzameenScore, $hex, 0xA2);
        $hex = $this->writeInt($this->SimulatorScore, $hex, 0xA6);
        $offset = 0xD2;
        for ($i = 0; $i < 256; $i++) {
            $t = $this->TourOfDutyKills[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $offset = 0x8CE;
        for ($i = 0; $i < 256; $i++) {
            $t = $this->AzzameenKills[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $offset = 0x10d2;
        for ($i = 0; $i < 256; $i++) {
            $t = $this->SimulatorKills[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $offset = 0x18d2;
        for ($i = 0; $i < 256; $i++) {
            $t = $this->TourOfDutyPartials[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $offset = 0x20ce;
        for ($i = 0; $i < 256; $i++) {
            $t = $this->AzzameenPartials[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $offset = 0x28d2;
        for ($i = 0; $i < 256; $i++) {
            $t = $this->SimulatorPartials[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $hex = $this->writeInt($this->LasersHit, $hex, 0x4d36);
        $hex = $this->writeInt($this->LasersFired, $hex, 0x4d42);
        $hex = $this->writeInt($this->WarheadsHit, $hex, 0x4d4e);
        $hex = $this->writeInt($this->WarheadsFired, $hex, 0x4d5a);
        $hex = $this->writeInt($this->CraftLosses, $hex, 0x4d66);
        $offset = 0xACFA;
        for ($i = 0; $i < 200; $i++) {
            $t = $this->MissionData[$i];
            $hex = $this->writeObject($t, $hex, $offset);
            $offset += $t->getLength();
        }
        $hex = $this->writeInt($this->CurrentRank, $hex, 0x10EA2);
        $hex = $this->writeInt($this->CurrentMedal, $hex, 0x10EA6);
        $hex = $this->writeInt($this->BonusTen, $hex, 0x1144E);

        return $hex;
    }
    
    
    public function getLength(): int
    {
        return self::PILOTFILELENGTH;
    }
}