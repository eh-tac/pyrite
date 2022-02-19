<?php

namespace Pyrite\TIE\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\PyriteBase;
use Pyrite\TIE\Constants;

abstract class PilotFileBase extends PyriteBase implements Byteable
{
    use HexDecoder;

    /** @var integer */
    public $PilotFileLength;
    /** @var integer */
    public const Start = 0;
    /** @var integer */
    public $PilotStatus;
    /** @var integer */
    public $PilotRank;
    /** @var integer */
    public $PilotDifficulty;
    /** @var integer */
    public $Score;
    /** @var integer */
    public $SkillScore;
    /** @var integer */
    public $SecretOrder;
    /** @var integer[] */
    public $TrainingScores;
    /** @var integer[] */
    public $TrainingLevels;
    /** @var integer[] */
    public $CombatScores;
    /** @var boolean[] */
    public $CombatCompletes;
    /** @var integer[] */
    public $BattleStatuses;
    /** @var integer[] */
    public $BattleLastMissions;
    /** @var integer[] */
    public $Persistence;
    /** @var integer[] */
    public $SecretObjectives;
    /** @var integer[] */
    public $BonusObjectives;
    /** @var integer[] */
    public $BattleScores;
    /** @var integer */
    public $TotalKills;
    /** @var integer */
    public $TotalCaptures;
    /** @var integer[] */
    public $KillsByType;
    /** @var integer */
    public $LasersFired;
    /** @var integer */
    public $LasersHit;
    /** @var integer */
    public $WarheadsFired;
    /** @var integer */
    public $WarheadsHit;
    /** @var integer */
    public $CraftLost;

    public function __construct($hex, $tie = null)
    {
        parent::__construct($hex, $tie);
        $this->beforeConstruct();
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
        $this->WarheadsFired = $this->getShort($hex, 0x780);
        $this->WarheadsHit = $this->getShort($hex, 0x782);
        $this->CraftLost = $this->getShort($hex, 0x786);
        $this->PilotFileLength = $offset;
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

    public function toHexString()
    {
        $hex = "";
        $offset = 0;

        $this->writeByte($hex, 0, 0x00);
        $this->writeByte($hex, $this->PilotStatus, 0x01);
        $this->writeByte($hex, $this->PilotRank, 0x02);
        $this->writeByte($hex, $this->PilotDifficulty, 0x03);
        $this->writeInt($hex, $this->Score, 0x04);
        $this->writeShort($hex, $this->SkillScore, 0x08);
        $this->writeByte($hex, $this->SecretOrder, 0x0A);
        $offset = 0x2A;
        for ($i = 0; $i < 7; $i++) {
            $t = $this->TrainingScores[$i];
            $this->writeInt($hex, $t, $offset);
            $offset += 4;
        }
        $offset = 0x5A;
        for ($i = 0; $i < 7; $i++) {
            $t = $this->TrainingLevels[$i];
            $this->writeByte($hex, $t, $offset);
            $offset += 1;
        }
        $offset = 0x88;
        for ($i = 0; $i < 56; $i++) {
            $t = $this->CombatScores[$i];
            $this->writeInt($hex, $t, $offset);
            $offset += 4;
        }
        $offset = 0x208;
        for ($i = 0; $i < 56; $i++) {
            $t = $this->CombatCompletes[$i];
            $this->writeBool($hex, $t, $offset);
            $offset += 1;
        }
        $offset = 0x269;
        for ($i = 0; $i < 20; $i++) {
            $t = $this->BattleStatuses[$i];
            $this->writeByte($hex, $t, $offset);
            $offset += 1;
        }
        $offset = 0x27D;
        for ($i = 0; $i < 20; $i++) {
            $t = $this->BattleLastMissions[$i];
            $this->writeByte($hex, $t, $offset);
            $offset += 1;
        }
        $offset = 0x291;
        for ($i = 0; $i < 256; $i++) {
            $t = $this->Persistence[$i];
            $this->writeByte($hex, $t, $offset);
            $offset += 1;
        }
        $offset = 0x391;
        for ($i = 0; $i < 20; $i++) {
            $t = $this->SecretObjectives[$i];
            $this->writeByte($hex, $t, $offset);
            $offset += 1;
        }
        $offset = 0x3A5;
        for ($i = 0; $i < 20; $i++) {
            $t = $this->BonusObjectives[$i];
            $this->writeByte($hex, $t, $offset);
            $offset += 1;
        }
        $offset = 0x3DA;
        for ($i = 0; $i < 160; $i++) {
            $t = $this->BattleScores[$i];
            $this->writeInt($hex, $t, $offset);
            $offset += 4;
        }
        $this->writeShort($hex, $this->TotalKills, 0x65A);
        $this->writeShort($hex, $this->TotalCaptures, 0x65C);
        $offset = 0x660;
        for ($i = 0; $i < 69; $i++) {
            $t = $this->KillsByType[$i];
            $this->writeShort($hex, $t, $offset);
            $offset += 2;
        }
        $this->writeInt($hex, $this->LasersFired, 0x774);
        $this->writeInt($hex, $this->LasersHit, 0x778);
        $this->writeShort($hex, $this->WarheadsFired, 0x780);
        $this->writeShort($hex, $this->WarheadsHit, 0x782);
        $this->writeShort($hex, $this->CraftLost, 0x786);

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
