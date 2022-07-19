<?php

namespace Pyrite\XW\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;
use Pyrite\XW\Constants;

abstract class PilotFileBase extends PyriteBase implements Byteable
{
    use HexDecoder;
    use HexEncoder;

    /** @var integer  PILOTFILELENGTH INT */
    public const PILOTFILELENGTH = 1704;
    /** @var integer 0x000 PlatformID SHORT */
    public $PlatformID;
    /** @var integer 0x002 PilotStatus BYTE */
    public $PilotStatus;
    /** @var integer 0x003 PilotRank BYTE */
    public $PilotRank;
    /** @var integer 0x004 TotalTODScore INT */
    public $TotalTODScore;
    /** @var integer 0x008 RookieNumber SHORT */
    public $RookieNumber;
    /** @var boolean[] 0x00A TODMedals BOOL */
    public $TODMedals;
    /** @var integer 0x011 KalidorCrescent BYTE */
    public $KalidorCrescent;
    /** @var integer[] 0x026 MazeScore INT */
    public $MazeScore; //XW YW AW BW
    /** @var integer[] 0x086 MazeLevel BYTE */
    public $MazeLevel;
    /** @var integer[] 0x0A0 XWingHistoricalScore INT */
    public $XWingHistoricalScore;
    /** @var integer[] 0x0E0 YWingHistoricalScore INT */
    public $YWingHistoricalScore;
    /** @var integer[] 0x120 AWingHistoricalScore INT */
    public $AWingHistoricalScore;
    /** @var integer[] 0x160 BWingHistoricalScore INT */
    public $BWingHistoricalScore;
    /** @var integer[] 0x1A0 BonusHistoricalScore INT */
    public $BonusHistoricalScore;
    /** @var boolean[] 0x220 XWingHistoricalComplete BOOL */
    public $XWingHistoricalComplete;
    /** @var boolean[] 0x230 YWingHistoricalComplete BOOL */
    public $YWingHistoricalComplete;
    /** @var boolean[] 0x240 AWingHistoricalComplete BOOL */
    public $AWingHistoricalComplete;
    /** @var boolean[] 0x250 BWingHistoricalComplete BOOL */
    public $BWingHistoricalComplete;
    /** @var boolean[] 0x260 BonusHistoricalComplete BOOL */
    public $BonusHistoricalComplete;
    /** @var integer[] 0x2DF TourStatus BYTE */
    public $TourStatus;
    /** @var integer[] 0x2EF TourOperationsComplete BYTE */
    public $TourOperationsComplete;
    /** @var integer[] 0x2F7 Tour1Scores INT */
    public $Tour1Scores;
    /** @var integer[] 0x35B Tour2Scores INT */
    public $Tour2Scores;
    /** @var integer[] 0x3BF Tour3Scores INT */
    public $Tour3Scores;
    /** @var integer[] 0x423 Tour4Scores INT */
    public $Tour4Scores;
    /** @var integer[] 0x487 Tour5Scores INT */
    public $Tour5Scores;
    /** @var integer 0x633 SurfaceVictories SHORT */
    public $SurfaceVictories;
    /** @var integer[] 0x635 TODKills SHORT */
    public $TODKills;
    /** @var integer[] 0x665 TODCaptures SHORT */
    public $TODCaptures;
    /** @var integer 0x695 LasersFired INT */
    public $LasersFired;
    /** @var integer 0x699 LaserCraftHits INT */
    public $LaserCraftHits;
    /** @var integer 0x69D LaserGroundHits INT */
    public $LaserGroundHits;
    /** @var integer 0x6A1 MissilesFired SHORT */
    public $MissilesFired;
    /** @var integer 0x6A3 MissileCraftHits SHORT */
    public $MissileCraftHits;
    /** @var integer 0x6A5 MissileGroundHits SHORT */
    public $MissileGroundHits;
    /** @var integer 0x6A7 CraftLost SHORT */
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
        

        $this->hex = substr($this->hex, 0, $this->getLength());
        return $this;
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
    
    public function toHexString($hex = null)
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $hex = $this->writeShort($this->PlatformID, $hex, 0x000);
        $hex = $this->writeByte($this->PilotStatus, $hex, 0x002);
        $hex = $this->writeByte($this->PilotRank, $hex, 0x003);
        $hex = $this->writeInt($this->TotalTODScore, $hex, 0x004);
        $hex = $this->writeShort($this->RookieNumber, $hex, 0x008);
        $offset = 0x00A;
        for ($i = 0; $i < 5; $i++) {
            $t = $this->TODMedals[$i];
            $hex = $this->writeBool($t, $hex, $offset);
            $offset += 1;
        }
        $hex = $this->writeByte($this->KalidorCrescent, $hex, 0x011);
        $offset = 0x026;
        for ($i = 0; $i < 4; $i++) {
            $t = $this->MazeScore[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $offset = 0x086;
        for ($i = 0; $i < 4; $i++) {
            $t = $this->MazeLevel[$i];
            $hex = $this->writeByte($t, $hex, $offset);
            $offset += 1;
        }
        $offset = 0x0A0;
        for ($i = 0; $i < 6; $i++) {
            $t = $this->XWingHistoricalScore[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $offset = 0x0E0;
        for ($i = 0; $i < 6; $i++) {
            $t = $this->YWingHistoricalScore[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $offset = 0x120;
        for ($i = 0; $i < 6; $i++) {
            $t = $this->AWingHistoricalScore[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $offset = 0x160;
        for ($i = 0; $i < 6; $i++) {
            $t = $this->BWingHistoricalScore[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $offset = 0x1A0;
        for ($i = 0; $i < 6; $i++) {
            $t = $this->BonusHistoricalScore[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $offset = 0x220;
        for ($i = 0; $i < 6; $i++) {
            $t = $this->XWingHistoricalComplete[$i];
            $hex = $this->writeBool($t, $hex, $offset);
            $offset += 1;
        }
        $offset = 0x230;
        for ($i = 0; $i < 6; $i++) {
            $t = $this->YWingHistoricalComplete[$i];
            $hex = $this->writeBool($t, $hex, $offset);
            $offset += 1;
        }
        $offset = 0x240;
        for ($i = 0; $i < 6; $i++) {
            $t = $this->AWingHistoricalComplete[$i];
            $hex = $this->writeBool($t, $hex, $offset);
            $offset += 1;
        }
        $offset = 0x250;
        for ($i = 0; $i < 6; $i++) {
            $t = $this->BWingHistoricalComplete[$i];
            $hex = $this->writeBool($t, $hex, $offset);
            $offset += 1;
        }
        $offset = 0x260;
        for ($i = 0; $i < 6; $i++) {
            $t = $this->BonusHistoricalComplete[$i];
            $hex = $this->writeBool($t, $hex, $offset);
            $offset += 1;
        }
        $offset = 0x2DF;
        for ($i = 0; $i < 5; $i++) {
            $t = $this->TourStatus[$i];
            $hex = $this->writeByte($t, $hex, $offset);
            $offset += 1;
        }
        $offset = 0x2EF;
        for ($i = 0; $i < 5; $i++) {
            $t = $this->TourOperationsComplete[$i];
            $hex = $this->writeByte($t, $hex, $offset);
            $offset += 1;
        }
        $offset = 0x2F7;
        for ($i = 0; $i < 12; $i++) {
            $t = $this->Tour1Scores[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $offset = 0x35B;
        for ($i = 0; $i < 12; $i++) {
            $t = $this->Tour2Scores[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $offset = 0x3BF;
        for ($i = 0; $i < 14; $i++) {
            $t = $this->Tour3Scores[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $offset = 0x423;
        for ($i = 0; $i < 24; $i++) {
            $t = $this->Tour4Scores[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $offset = 0x487;
        for ($i = 0; $i < 24; $i++) {
            $t = $this->Tour5Scores[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $hex = $this->writeShort($this->SurfaceVictories, $hex, 0x633);
        $offset = 0x635;
        for ($i = 0; $i < 24; $i++) {
            $t = $this->TODKills[$i];
            $hex = $this->writeShort($t, $hex, $offset);
            $offset += 2;
        }
        $offset = 0x665;
        for ($i = 0; $i < 24; $i++) {
            $t = $this->TODCaptures[$i];
            $hex = $this->writeShort($t, $hex, $offset);
            $offset += 2;
        }
        $hex = $this->writeInt($this->LasersFired, $hex, 0x695);
        $hex = $this->writeInt($this->LaserCraftHits, $hex, 0x699);
        $hex = $this->writeInt($this->LaserGroundHits, $hex, 0x69D);
        $hex = $this->writeShort($this->MissilesFired, $hex, 0x6A1);
        $hex = $this->writeShort($this->MissileCraftHits, $hex, 0x6A3);
        $hex = $this->writeShort($this->MissileGroundHits, $hex, 0x6A5);
        $hex = $this->writeShort($this->CraftLost, $hex, 0x6A7);

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

    public function getKalidorCrescentLabel() 
    {
        return isset($this->KalidorCrescent) && isset(Constants::$KALIDORCRESCENT[$this->KalidorCrescent]) ? Constants::$KALIDORCRESCENT[$this->KalidorCrescent] : "Unknown";
    }
    
    public function getLength()
    {
        return self::PILOTFILELENGTH;
    }
}