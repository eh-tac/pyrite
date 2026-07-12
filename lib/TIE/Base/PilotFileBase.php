<?php

namespace Pyrite\TIE\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;
use Pyrite\PyriteModel;
use Pyrite\TIE\Constants;

abstract class PilotFileBase extends PyriteBase implements Byteable, PyriteModel
{
    use HexDecoder;
    use HexEncoder;

    /** @var int PilotFileLength INT */
	public int $PilotFileLength;
    /** @var int 0x00 Start BYTE */
	public const Start = 0;
    /** @var int 0x01 PilotStatus BYTE */
	public int $PilotStatus;
    /** @var int 0x02 PilotRank BYTE */
	public int $PilotRank;
    /** @var int 0x03 PilotDifficulty BYTE */
	public int $PilotDifficulty;
    /** @var int 0x04 Score INT */
	public int $Score;
    /** @var int 0x08 SkillScore USHORT */
	public int $SkillScore;
    /** @var int 0x0A SecretOrder BYTE */
	public int $SecretOrder;
    /** @var array<int> 0x2A TrainingScores INT */
	public array $TrainingScores;
    /** @var array<int> 0x5A TrainingLevels BYTE */
	public array $TrainingLevels;
    /** @var array<int> 0x88 CombatScores INT */
	public array $CombatScores;
    /** @var array<bool> 0x208 CombatCompletes BOOL */
	public array $CombatCompletes;
    /** @var array<int> 0x269 BattleStatuses BYTE */
	public array $BattleStatuses;
    /** @var array<int> 0x27D BattleLastMissions BYTE */
	public array $BattleLastMissions;
    /** @var array<int> 0x291 Persistence BYTE */
	public array $Persistence;
    /** @var array<int> 0x391 SecretObjectives BYTE */
	public array $SecretObjectives;
    /** @var array<int> 0x3A5 BonusObjectives BYTE */
	public array $BonusObjectives;
    /** @var array<int> 0x3DA BattleScores INT */
	public array $BattleScores;
    /** @var int 0x65A TotalKills SHORT */
	public int $TotalKills;
    /** @var int 0x65C TotalCaptures SHORT */
	public int $TotalCaptures;
    /** @var array<int> 0x660 KillsByType SHORT */
	public array $KillsByType;
    /** @var int 0x774 LasersFired INT */
	public int $LasersFired;
    /** @var int 0x778 LasersHit INT */
	public int $LasersHit;
    /** @var int 0x780 WarheadsFired USHORT */
	public int $WarheadsFired;
    /** @var int 0x782 WarheadsHit USHORT */
	public int $WarheadsHit;
    /** @var int 0x786 CraftLost SHORT */
	public int $CraftLost;
    
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

        // static BYTE value Start = 0
        $this->PilotStatus = $this->getByte($hex, 0x01);
        $this->PilotRank = $this->getByte($hex, 0x02);
        $this->PilotDifficulty = $this->getByte($hex, 0x03);
        $this->Score = $this->getInt($hex, 0x04);
        $this->SkillScore = $this->getUShort($hex, 0x08);
        $this->SecretOrder = $this->getByte($hex, 0x0A);
        $this->TrainingScores = [];
        $offset = 0x2A;
        for ($i = 0; $i < 7; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->TrainingScores[] = $t;
            $offset += 4;
        }
        $this->TrainingLevels = [];
        $offset = 0x5A;
        for ($i = 0; $i < 7; $i++) {
            $t = $this->getByte($hex, $offset);
            $this->TrainingLevels[] = $t;
            $offset += 1;
        }
        $this->CombatScores = [];
        $offset = 0x88;
        for ($i = 0; $i < 56; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->CombatScores[] = $t;
            $offset += 4;
        }
        $this->CombatCompletes = [];
        $offset = 0x208;
        for ($i = 0; $i < 56; $i++) {
            $t = $this->getBool($hex, $offset);
            $this->CombatCompletes[] = $t;
            $offset += 1;
        }
        $this->BattleStatuses = [];
        $offset = 0x269;
        for ($i = 0; $i < 20; $i++) {
            $t = $this->getByte($hex, $offset);
            $this->BattleStatuses[] = $t;
            $offset += 1;
        }
        $this->BattleLastMissions = [];
        $offset = 0x27D;
        for ($i = 0; $i < 20; $i++) {
            $t = $this->getByte($hex, $offset);
            $this->BattleLastMissions[] = $t;
            $offset += 1;
        }
        $this->Persistence = [];
        $offset = 0x291;
        for ($i = 0; $i < 256; $i++) {
            $t = $this->getByte($hex, $offset);
            $this->Persistence[] = $t;
            $offset += 1;
        }
        $this->SecretObjectives = [];
        $offset = 0x391;
        for ($i = 0; $i < 20; $i++) {
            $t = $this->getByte($hex, $offset);
            $this->SecretObjectives[] = $t;
            $offset += 1;
        }
        $this->BonusObjectives = [];
        $offset = 0x3A5;
        for ($i = 0; $i < 20; $i++) {
            $t = $this->getByte($hex, $offset);
            $this->BonusObjectives[] = $t;
            $offset += 1;
        }
        $this->BattleScores = [];
        $offset = 0x3DA;
        for ($i = 0; $i < 160; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->BattleScores[] = $t;
            $offset += 4;
        }
        $this->TotalKills = $this->getShort($hex, 0x65A);
        $this->TotalCaptures = $this->getShort($hex, 0x65C);
        $this->KillsByType = [];
        $offset = 0x660;
        for ($i = 0; $i < 69; $i++) {
            $t = $this->getShort($hex, $offset);
            $this->KillsByType[] = $t;
            $offset += 2;
        }
        $this->LasersFired = $this->getInt($hex, 0x774);
        $this->LasersHit = $this->getInt($hex, 0x778);
        $this->WarheadsFired = $this->getUShort($hex, 0x780);
        $this->WarheadsHit = $this->getUShort($hex, 0x782);
        $this->CraftLost = $this->getShort($hex, 0x786);
        $this->PilotFileLength = $offset;

        $this->hex = substr($this->hex, 0, $this->getLength());
        $this->afterLoadHex();
        return $this;
    }
    
    public function __debugInfo(): array
    {
        return [
            "PilotStatus" => $this->getPilotStatusLabel(),
            "PilotRank" => $this->getPilotRankLabel(),
            "PilotDifficulty" => $this->getPilotDifficultyLabel(),
            "Score" => $this->Score,
            "SkillScore" => $this->SkillScore,
            "SecretOrder" => $this->getSecretOrderLabel(),
            "TrainingScores" => $this->TrainingScores,
            "TrainingLevels" => $this->TrainingLevels,
            "CombatScores" => $this->CombatScores,
            "CombatCompletes" => $this->CombatCompletes,
            "BattleStatuses" => $this->BattleStatuses,
            "BattleLastMissions" => $this->BattleLastMissions,
            "Persistence" => $this->Persistence,
            "SecretObjectives" => $this->SecretObjectives,
            "BonusObjectives" => $this->BonusObjectives,
            "BattleScores" => $this->BattleScores,
            "TotalKills" => $this->TotalKills,
            "TotalCaptures" => $this->TotalCaptures,
            "KillsByType" => $this->KillsByType,
            "LasersFired" => $this->LasersFired,
            "LasersHit" => $this->LasersHit,
            "WarheadsFired" => $this->WarheadsFired,
            "WarheadsHit" => $this->WarheadsHit,
            "CraftLost" => $this->CraftLost
        ];
    }
    
    public function toHexString($hex = null): string
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $hex = $this->writeByte(0, $hex, 0x00);
        $hex = $this->writeByte($this->PilotStatus, $hex, 0x01);
        $hex = $this->writeByte($this->PilotRank, $hex, 0x02);
        $hex = $this->writeByte($this->PilotDifficulty, $hex, 0x03);
        $hex = $this->writeInt($this->Score, $hex, 0x04);
        $hex = $this->writeUShort($this->SkillScore, $hex, 0x08);
        $hex = $this->writeByte($this->SecretOrder, $hex, 0x0A);
        $offset = 0x2A;
        for ($i = 0; $i < 7; $i++) {
            $t = $this->TrainingScores[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $offset = 0x5A;
        for ($i = 0; $i < 7; $i++) {
            $t = $this->TrainingLevels[$i];
            $hex = $this->writeByte($t, $hex, $offset);
            $offset += 1;
        }
        $offset = 0x88;
        for ($i = 0; $i < 56; $i++) {
            $t = $this->CombatScores[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $offset = 0x208;
        for ($i = 0; $i < 56; $i++) {
            $t = $this->CombatCompletes[$i];
            $hex = $this->writeBool($t, $hex, $offset);
            $offset += 1;
        }
        $offset = 0x269;
        for ($i = 0; $i < 20; $i++) {
            $t = $this->BattleStatuses[$i];
            $hex = $this->writeByte($t, $hex, $offset);
            $offset += 1;
        }
        $offset = 0x27D;
        for ($i = 0; $i < 20; $i++) {
            $t = $this->BattleLastMissions[$i];
            $hex = $this->writeByte($t, $hex, $offset);
            $offset += 1;
        }
        $offset = 0x291;
        for ($i = 0; $i < 256; $i++) {
            $t = $this->Persistence[$i];
            $hex = $this->writeByte($t, $hex, $offset);
            $offset += 1;
        }
        $offset = 0x391;
        for ($i = 0; $i < 20; $i++) {
            $t = $this->SecretObjectives[$i];
            $hex = $this->writeByte($t, $hex, $offset);
            $offset += 1;
        }
        $offset = 0x3A5;
        for ($i = 0; $i < 20; $i++) {
            $t = $this->BonusObjectives[$i];
            $hex = $this->writeByte($t, $hex, $offset);
            $offset += 1;
        }
        $offset = 0x3DA;
        for ($i = 0; $i < 160; $i++) {
            $t = $this->BattleScores[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $hex = $this->writeShort($this->TotalKills, $hex, 0x65A);
        $hex = $this->writeShort($this->TotalCaptures, $hex, 0x65C);
        $offset = 0x660;
        for ($i = 0; $i < 69; $i++) {
            $t = $this->KillsByType[$i];
            $hex = $this->writeShort($t, $hex, $offset);
            $offset += 2;
        }
        $hex = $this->writeInt($this->LasersFired, $hex, 0x774);
        $hex = $this->writeInt($this->LasersHit, $hex, 0x778);
        $hex = $this->writeUShort($this->WarheadsFired, $hex, 0x780);
        $hex = $this->writeUShort($this->WarheadsHit, $hex, 0x782);
        $hex = $this->writeShort($this->CraftLost, $hex, 0x786);

        return $hex;
    }
    
    public function getPilotStatusLabel(): string 
    {
        return isset($this->PilotStatus) && isset(Constants::$PILOTSTATUS[$this->PilotStatus]) ? Constants::$PILOTSTATUS[$this->PilotStatus] : "Unknown";
    }

    public function getPilotRankLabel(): string 
    {
        return isset($this->PilotRank) && isset(Constants::$PILOTRANK[$this->PilotRank]) ? Constants::$PILOTRANK[$this->PilotRank] : "Unknown";
    }

    public function getPilotDifficultyLabel(): string 
    {
        return isset($this->PilotDifficulty) && isset(Constants::$PILOTDIFFICULTY[$this->PilotDifficulty]) ? Constants::$PILOTDIFFICULTY[$this->PilotDifficulty] : "Unknown";
    }

    public function getSecretOrderLabel(): string 
    {
        return isset($this->SecretOrder) && isset(Constants::$SECRETORDER[$this->SecretOrder]) ? Constants::$SECRETORDER[$this->SecretOrder] : "Unknown";
    }
    
    public function getLength(): int
    {
        return $this->PilotFileLength;
    }
}