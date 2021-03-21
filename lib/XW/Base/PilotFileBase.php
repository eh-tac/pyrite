<?php

namespace Pyrite\XW\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\PyriteBase;
use Pyrite\XW\Constants;

abstract class PilotFileBase extends PyriteBase implements Byteable
{
    use HexDecoder;

    /** @var integer */
    public const PILOTFILELENGTH = 1704;
    /** @var integer */
    public $PlatformID;
    /** @var integer */
    public $PilotStatus;
    /** @var integer */
    public $PilotRank;
    /** @var integer */
    public $TotalTODScore;
    /** @var integer */
    public $RookieNumber;
    /** @var boolean[] */
    public $TODMedals;
    /** @var integer */
    public $KalidorCrescent;
    /** @var integer[] */
    public $MazeScore; //XW YW AW BW
    /** @var integer[] */
    public $MazeLevel;
    /** @var integer[] */
    public $XWingHistoricalScore;
    /** @var integer[] */
    public $YWingHistoricalScore;
    /** @var integer[] */
    public $AWingHistoricalScore;
    /** @var integer[] */
    public $BWingHistoricalScore;
    /** @var integer[] */
    public $BonusHistoricalScore;
    /** @var boolean[] */
    public $XWingHistoricalComplete;
    /** @var boolean[] */
    public $YWingHistoricalComplete;
    /** @var boolean[] */
    public $AWingHistoricalComplete;
    /** @var boolean[] */
    public $BWingHistoricalComplete;
    /** @var boolean[] */
    public $BonusHistoricalComplete;
    /** @var integer[] */
    public $TourStatus;
    /** @var integer[] */
    public $TourOperationsComplete;
    /** @var integer[] */
    public $Tour1Scores;
    /** @var integer[] */
    public $Tour2Scores;
    /** @var integer[] */
    public $Tour3Scores;
    /** @var integer[] */
    public $Tour4Scores;
    /** @var integer[] */
    public $Tour5Scores;
    /** @var integer */
    public $SurfaceVictories;
    /** @var integer[] */
    public $TODKills;
    /** @var integer[] */
    public $TODCaptures;
    /** @var integer */
    public $LasersFired;
    /** @var integer */
    public $LaserCraftHits;
    /** @var integer */
    public $LaserGroundHits;
    /** @var integer */
    public $MissilesFired;
    /** @var integer */
    public $MissileCraftHits;
    /** @var integer */
    public $MissileGroundHits;
    /** @var integer */
    public $CraftLost;
    
    public function __construct($hex, $tie = null)
    {
        parent::__construct($hex, $tie);
        $this->beforeConstruct();
        $offset = 0;

        $this->PlatformID = $this->getShort($hex, 0x000);
        $this->PilotStatus = $this->getByte($hex, 0x002);
        $this->PilotRank = $this->getByte($hex, 0x003);
        $this->TotalTODScore = $this->getInt($hex, 0x004);
        $this->RookieNumber = $this->getShort($hex, 0x008);
        $this->TODMedals = [];
        $offset = 0x00A;
        for ($i = 0; $i < 5; $i++) {
            $t = $this->getBool($hex, $offset);
            $this->TODMedals[] = $t;
            $offset += 1;
        }
        $this->KalidorCrescent = $this->getByte($hex, 0x011);
        $this->MazeScore = [];
        $offset = 0x026;
        for ($i = 0; $i < 4; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->MazeScore[] = $t;
            $offset += 4;
        }
        $this->MazeLevel = [];
        $offset = 0x086;
        for ($i = 0; $i < 4; $i++) {
            $t = $this->getByte($hex, $offset);
            $this->MazeLevel[] = $t;
            $offset += 1;
        }
        $this->XWingHistoricalScore = [];
        $offset = 0x0A0;
        for ($i = 0; $i < 6; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->XWingHistoricalScore[] = $t;
            $offset += 4;
        }
        $this->YWingHistoricalScore = [];
        $offset = 0x0E0;
        for ($i = 0; $i < 6; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->YWingHistoricalScore[] = $t;
            $offset += 4;
        }
        $this->AWingHistoricalScore = [];
        $offset = 0x120;
        for ($i = 0; $i < 6; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->AWingHistoricalScore[] = $t;
            $offset += 4;
        }
        $this->BWingHistoricalScore = [];
        $offset = 0x160;
        for ($i = 0; $i < 6; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->BWingHistoricalScore[] = $t;
            $offset += 4;
        }
        $this->BonusHistoricalScore = [];
        $offset = 0x1A0;
        for ($i = 0; $i < 6; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->BonusHistoricalScore[] = $t;
            $offset += 4;
        }
        $this->XWingHistoricalComplete = [];
        $offset = 0x220;
        for ($i = 0; $i < 6; $i++) {
            $t = $this->getBool($hex, $offset);
            $this->XWingHistoricalComplete[] = $t;
            $offset += 1;
        }
        $this->YWingHistoricalComplete = [];
        $offset = 0x230;
        for ($i = 0; $i < 6; $i++) {
            $t = $this->getBool($hex, $offset);
            $this->YWingHistoricalComplete[] = $t;
            $offset += 1;
        }
        $this->AWingHistoricalComplete = [];
        $offset = 0x240;
        for ($i = 0; $i < 6; $i++) {
            $t = $this->getBool($hex, $offset);
            $this->AWingHistoricalComplete[] = $t;
            $offset += 1;
        }
        $this->BWingHistoricalComplete = [];
        $offset = 0x250;
        for ($i = 0; $i < 6; $i++) {
            $t = $this->getBool($hex, $offset);
            $this->BWingHistoricalComplete[] = $t;
            $offset += 1;
        }
        $this->BonusHistoricalComplete = [];
        $offset = 0x260;
        for ($i = 0; $i < 6; $i++) {
            $t = $this->getBool($hex, $offset);
            $this->BonusHistoricalComplete[] = $t;
            $offset += 1;
        }
        $this->TourStatus = [];
        $offset = 0x2DF;
        for ($i = 0; $i < 5; $i++) {
            $t = $this->getByte($hex, $offset);
            $this->TourStatus[] = $t;
            $offset += 1;
        }
        $this->TourOperationsComplete = [];
        $offset = 0x2EF;
        for ($i = 0; $i < 5; $i++) {
            $t = $this->getByte($hex, $offset);
            $this->TourOperationsComplete[] = $t;
            $offset += 1;
        }
        $this->Tour1Scores = [];
        $offset = 0x2F7;
        for ($i = 0; $i < 12; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->Tour1Scores[] = $t;
            $offset += 4;
        }
        $this->Tour2Scores = [];
        $offset = 0x35B;
        for ($i = 0; $i < 12; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->Tour2Scores[] = $t;
            $offset += 4;
        }
        $this->Tour3Scores = [];
        $offset = 0x3BF;
        for ($i = 0; $i < 14; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->Tour3Scores[] = $t;
            $offset += 4;
        }
        $this->Tour4Scores = [];
        $offset = 0x423;
        for ($i = 0; $i < 24; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->Tour4Scores[] = $t;
            $offset += 4;
        }
        $this->Tour5Scores = [];
        $offset = 0x487;
        for ($i = 0; $i < 24; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->Tour5Scores[] = $t;
            $offset += 4;
        }
        $this->SurfaceVictories = $this->getShort($hex, 0x633);
        $this->TODKills = [];
        $offset = 0x635;
        for ($i = 0; $i < 24; $i++) {
            $t = $this->getShort($hex, $offset);
            $this->TODKills[] = $t;
            $offset += 2;
        }
        $this->TODCaptures = [];
        $offset = 0x665;
        for ($i = 0; $i < 24; $i++) {
            $t = $this->getShort($hex, $offset);
            $this->TODCaptures[] = $t;
            $offset += 2;
        }
        $this->LasersFired = $this->getInt($hex, 0x695);
        $this->LaserCraftHits = $this->getInt($hex, 0x699);
        $this->LaserGroundHits = $this->getInt($hex, 0x69D);
        $this->MissilesFired = $this->getShort($hex, 0x6A1);
        $this->MissileCraftHits = $this->getShort($hex, 0x6A3);
        $this->MissileGroundHits = $this->getShort($hex, 0x6A5);
        $this->CraftLost = $this->getShort($hex, 0x6A7);
        
    }
    
    public function __debugInfo()
    {
        return [
            "PlatformID" => $this->PlatformID,
            "PilotStatus" => $this->getPilotStatusLabel(),
            "PilotRank" => $this->getPilotRankLabel(),
            "TotalTODScore" => $this->TotalTODScore,
            "RookieNumber" => $this->RookieNumber,
            "TODMedals" => $this->TODMedals,
            "KalidorCrescent" => $this->getKalidorCrescentLabel(),
            "MazeScore" => $this->MazeScore,
            "MazeLevel" => $this->MazeLevel,
            "XWingHistoricalScore" => $this->XWingHistoricalScore,
            "YWingHistoricalScore" => $this->YWingHistoricalScore,
            "AWingHistoricalScore" => $this->AWingHistoricalScore,
            "BWingHistoricalScore" => $this->BWingHistoricalScore,
            "BonusHistoricalScore" => $this->BonusHistoricalScore,
            "XWingHistoricalComplete" => $this->XWingHistoricalComplete,
            "YWingHistoricalComplete" => $this->YWingHistoricalComplete,
            "AWingHistoricalComplete" => $this->AWingHistoricalComplete,
            "BWingHistoricalComplete" => $this->BWingHistoricalComplete,
            "BonusHistoricalComplete" => $this->BonusHistoricalComplete,
            "TourStatus" => $this->TourStatus,
            "TourOperationsComplete" => $this->TourOperationsComplete,
            "Tour1Scores" => $this->Tour1Scores,
            "Tour2Scores" => $this->Tour2Scores,
            "Tour3Scores" => $this->Tour3Scores,
            "Tour4Scores" => $this->Tour4Scores,
            "Tour5Scores" => $this->Tour5Scores,
            "SurfaceVictories" => $this->SurfaceVictories,
            "TODKills" => $this->TODKills,
            "TODCaptures" => $this->TODCaptures,
            "LasersFired" => $this->LasersFired,
            "LaserCraftHits" => $this->LaserCraftHits,
            "LaserGroundHits" => $this->LaserGroundHits,
            "MissilesFired" => $this->MissilesFired,
            "MissileCraftHits" => $this->MissileCraftHits,
            "MissileGroundHits" => $this->MissileGroundHits,
            "CraftLost" => $this->CraftLost
        ];
    }
    
    public function toHexString()
    {
        $hex = "";
        $offset = 0;

        $this->writeShort($hex, $this->PlatformID, 0x000);
        $this->writeByte($hex, $this->PilotStatus, 0x002);
        $this->writeByte($hex, $this->PilotRank, 0x003);
        $this->writeInt($hex, $this->TotalTODScore, 0x004);
        $this->writeShort($hex, $this->RookieNumber, 0x008);
        $offset = 0x00A;
        for ($i = 0; $i < 5; $i++) {
            $t = $this->TODMedals[$i];
            $this->writeBool($hex, $t, $offset);
            $offset += 1;
        }
        $this->writeByte($hex, $this->KalidorCrescent, 0x011);
        $offset = 0x026;
        for ($i = 0; $i < 4; $i++) {
            $t = $this->MazeScore[$i];
            $this->writeInt($hex, $t, $offset);
            $offset += 4;
        }
        $offset = 0x086;
        for ($i = 0; $i < 4; $i++) {
            $t = $this->MazeLevel[$i];
            $this->writeByte($hex, $t, $offset);
            $offset += 1;
        }
        $offset = 0x0A0;
        for ($i = 0; $i < 6; $i++) {
            $t = $this->XWingHistoricalScore[$i];
            $this->writeInt($hex, $t, $offset);
            $offset += 4;
        }
        $offset = 0x0E0;
        for ($i = 0; $i < 6; $i++) {
            $t = $this->YWingHistoricalScore[$i];
            $this->writeInt($hex, $t, $offset);
            $offset += 4;
        }
        $offset = 0x120;
        for ($i = 0; $i < 6; $i++) {
            $t = $this->AWingHistoricalScore[$i];
            $this->writeInt($hex, $t, $offset);
            $offset += 4;
        }
        $offset = 0x160;
        for ($i = 0; $i < 6; $i++) {
            $t = $this->BWingHistoricalScore[$i];
            $this->writeInt($hex, $t, $offset);
            $offset += 4;
        }
        $offset = 0x1A0;
        for ($i = 0; $i < 6; $i++) {
            $t = $this->BonusHistoricalScore[$i];
            $this->writeInt($hex, $t, $offset);
            $offset += 4;
        }
        $offset = 0x220;
        for ($i = 0; $i < 6; $i++) {
            $t = $this->XWingHistoricalComplete[$i];
            $this->writeBool($hex, $t, $offset);
            $offset += 1;
        }
        $offset = 0x230;
        for ($i = 0; $i < 6; $i++) {
            $t = $this->YWingHistoricalComplete[$i];
            $this->writeBool($hex, $t, $offset);
            $offset += 1;
        }
        $offset = 0x240;
        for ($i = 0; $i < 6; $i++) {
            $t = $this->AWingHistoricalComplete[$i];
            $this->writeBool($hex, $t, $offset);
            $offset += 1;
        }
        $offset = 0x250;
        for ($i = 0; $i < 6; $i++) {
            $t = $this->BWingHistoricalComplete[$i];
            $this->writeBool($hex, $t, $offset);
            $offset += 1;
        }
        $offset = 0x260;
        for ($i = 0; $i < 6; $i++) {
            $t = $this->BonusHistoricalComplete[$i];
            $this->writeBool($hex, $t, $offset);
            $offset += 1;
        }
        $offset = 0x2DF;
        for ($i = 0; $i < 5; $i++) {
            $t = $this->TourStatus[$i];
            $this->writeByte($hex, $t, $offset);
            $offset += 1;
        }
        $offset = 0x2EF;
        for ($i = 0; $i < 5; $i++) {
            $t = $this->TourOperationsComplete[$i];
            $this->writeByte($hex, $t, $offset);
            $offset += 1;
        }
        $offset = 0x2F7;
        for ($i = 0; $i < 12; $i++) {
            $t = $this->Tour1Scores[$i];
            $this->writeInt($hex, $t, $offset);
            $offset += 4;
        }
        $offset = 0x35B;
        for ($i = 0; $i < 12; $i++) {
            $t = $this->Tour2Scores[$i];
            $this->writeInt($hex, $t, $offset);
            $offset += 4;
        }
        $offset = 0x3BF;
        for ($i = 0; $i < 14; $i++) {
            $t = $this->Tour3Scores[$i];
            $this->writeInt($hex, $t, $offset);
            $offset += 4;
        }
        $offset = 0x423;
        for ($i = 0; $i < 24; $i++) {
            $t = $this->Tour4Scores[$i];
            $this->writeInt($hex, $t, $offset);
            $offset += 4;
        }
        $offset = 0x487;
        for ($i = 0; $i < 24; $i++) {
            $t = $this->Tour5Scores[$i];
            $this->writeInt($hex, $t, $offset);
            $offset += 4;
        }
        $this->writeShort($hex, $this->SurfaceVictories, 0x633);
        $offset = 0x635;
        for ($i = 0; $i < 24; $i++) {
            $t = $this->TODKills[$i];
            $this->writeShort($hex, $t, $offset);
            $offset += 2;
        }
        $offset = 0x665;
        for ($i = 0; $i < 24; $i++) {
            $t = $this->TODCaptures[$i];
            $this->writeShort($hex, $t, $offset);
            $offset += 2;
        }
        $this->writeInt($hex, $this->LasersFired, 0x695);
        $this->writeInt($hex, $this->LaserCraftHits, 0x699);
        $this->writeInt($hex, $this->LaserGroundHits, 0x69D);
        $this->writeShort($hex, $this->MissilesFired, 0x6A1);
        $this->writeShort($hex, $this->MissileCraftHits, 0x6A3);
        $this->writeShort($hex, $this->MissileGroundHits, 0x6A5);
        $this->writeShort($hex, $this->CraftLost, 0x6A7);

        return $hex;
    }
    
    public function getPilotStatusLabel() {
        return isset($this->PilotStatus) && isset(Constants::$PILOTSTATUS[$this->PilotStatus]) ? Constants::$PILOTSTATUS[$this->PilotStatus] : "Unknown";
    }

    public function getPilotRankLabel() {
        return isset($this->PilotRank) && isset(Constants::$PILOTRANK[$this->PilotRank]) ? Constants::$PILOTRANK[$this->PilotRank] : "Unknown";
    }

    public function getKalidorCrescentLabel() {
        return isset($this->KalidorCrescent) && isset(Constants::$KALIDORCRESCENT[$this->KalidorCrescent]) ? Constants::$KALIDORCRESCENT[$this->KalidorCrescent] : "Unknown";
    }
    
    public function getLength()
    {
        return self::PILOTFILELENGTH;
    }
}