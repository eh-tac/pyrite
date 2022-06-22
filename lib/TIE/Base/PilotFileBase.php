<?php

namespace Pyrite\TIE\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;
use Pyrite\TIE\Constants;

abstract class PilotFileBase extends PyriteBase implements Byteable
{
    use HexDecoder;
    use HexEncoder;

    /** @var integer  PilotFileLength INT */
    public $PilotFileLength;
    /** @var integer 0x00 Start BYTE */
    public const Start = 0;
    /** @var integer 0x01 PilotStatus BYTE */
    public $PilotStatus;
    /** @var integer 0x02 PilotRank BYTE */
    public $PilotRank;
    /** @var integer 0x03 PilotDifficulty BYTE */
    public $PilotDifficulty;
    /** @var integer 0x04 Score INT */
    public $Score;
    /** @var integer 0x08 SkillScore USHORT */
    public $SkillScore;
    /** @var integer 0x0A SecretOrder BYTE */
    public $SecretOrder;
    /** @var integer[] 0x2A TrainingScores INT */
    public $TrainingScores;
    /** @var integer[] 0x5A TrainingLevels BYTE */
    public $TrainingLevels;
    /** @var integer[] 0x88 CombatScores INT */
    public $CombatScores;
    /** @var boolean[] 0x208 CombatCompletes BOOL */
    public $CombatCompletes;
    /** @var integer[] 0x269 BattleStatuses BYTE */
    public $BattleStatuses;
    /** @var integer[] 0x27D BattleLastMissions BYTE */
    public $BattleLastMissions;
    /** @var integer[] 0x291 Persistence BYTE */
    public $Persistence;
    /** @var integer[] 0x391 SecretObjectives BYTE */
    public $SecretObjectives;
    /** @var integer[] 0x3A5 BonusObjectives BYTE */
    public $BonusObjectives;
    /** @var integer[] 0x3DA BattleScores INT */
    public $BattleScores;
    /** @var integer 0x65A TotalKills SHORT */
    public $TotalKills;
    /** @var integer 0x65C TotalCaptures SHORT */
    public $TotalCaptures;
    /** @var integer[] 0x660 KillsByType SHORT */
    public $KillsByType;
    /** @var integer 0x774 LasersFired INT */
    public $LasersFired;
    /** @var integer 0x778 LasersHit INT */
    public $LasersHit;
    /** @var integer 0x780 WarheadsFired USHORT */
    public $WarheadsFired;
    /** @var integer 0x782 WarheadsHit USHORT */
    public $WarheadsHit;
    /** @var integer 0x786 CraftLost SHORT */
    public $CraftLost;
    
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
        return $this;
    }
    
    public function __debugInfo()
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
    
    public function toHexString($hex = null)
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
    
    public function getPilotStatusLabel() 
    {
        return isset($this->PilotStatus) && isset(Constants::$PILOTSTATUS[$this->PilotStatus]) ? Constants::$PILOTSTATUS[$this->PilotStatus] : "Unknown";
    }

    public function getPilotRankLabel() 
    {
        return isset($this->PilotRank) && isset(Constants::$PILOTRANK[$this->PilotRank]) ? Constants::$PILOTRANK[$this->PilotRank] : "Unknown";
    }

    public function getPilotDifficultyLabel() 
    {
        return isset($this->PilotDifficulty) && isset(Constants::$PILOTDIFFICULTY[$this->PilotDifficulty]) ? Constants::$PILOTDIFFICULTY[$this->PilotDifficulty] : "Unknown";
    }

    public function getSecretOrderLabel() 
    {
        return isset($this->SecretOrder) && isset(Constants::$SECRETORDER[$this->SecretOrder]) ? Constants::$SECRETORDER[$this->SecretOrder] : "Unknown";
    }
    
    public function getLength()
    {
        return $this->PilotFileLength;
    }
}