<?php

namespace Pyrite\XvT\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;

abstract class PLTBattleProgressStateBase extends PyriteBase implements Byteable
{
    use HexDecoder;
    use HexEncoder;

    /** @var integer  PLTBATTLEPROGRESSSTATELENGTH INT */
    public const PLTBATTLEPROGRESSSTATELENGTH = 140;
    /** @var integer 0x0000 MissionsFlown INT */
    public $MissionsFlown;
    /** @var integer 0x0004 CombatMissionID INT */
    public $CombatMissionID;
    /** @var integer 0x0008 totalMissionCount INT */
    public $totalMissionCount;
    /** @var integer[] 0x000C Outcome INT */
    public $Outcome;
    /** @var integer[] 0x0034 BattleListIndex INT */
    public $BattleListIndex;
    /** @var integer[] 0x005C CombatMissionListIndex INT */
    public $CombatMissionListIndex;
    /** @var integer 0x0084 NumPlayers INT */
    public $NumPlayers;
    /** @var integer 0x0088 totalScore INT */
    public $totalScore;
    
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

        $this->MissionsFlown = $this->getInt($hex, 0x0000);
        $this->CombatMissionID = $this->getInt($hex, 0x0004);
        $this->totalMissionCount = $this->getInt($hex, 0x0008);
        $this->Outcome = [];
        $offset = 0x000C;
        for ($i = 0; $i < 10; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->Outcome[] = $t;
            $offset += 4;
        }
        $this->BattleListIndex = [];
        $offset = 0x0034;
        for ($i = 0; $i < 10; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->BattleListIndex[] = $t;
            $offset += 4;
        }
        $this->CombatMissionListIndex = [];
        $offset = 0x005C;
        for ($i = 0; $i < 10; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->CombatMissionListIndex[] = $t;
            $offset += 4;
        }
        $this->NumPlayers = $this->getInt($hex, 0x0084);
        $this->totalScore = $this->getInt($hex, 0x0088);
        

        $this->hex = substr($this->hex, 0, $this->getLength());
        return $this;
    }
    
    public function __debugInfo()
    {
        return [
            "MissionsFlown" => $this->MissionsFlown,
            "CombatMissionID" => $this->CombatMissionID,
            "totalMissionCount" => $this->totalMissionCount,
            "Outcome" => $this->Outcome,
            "BattleListIndex" => $this->BattleListIndex,
            "CombatMissionListIndex" => $this->CombatMissionListIndex,
            "NumPlayers" => $this->NumPlayers,
            "totalScore" => $this->totalScore
        ];
    }
    
    public function toHexString($hex = null)
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $hex = $this->writeInt($this->MissionsFlown, $hex, 0x0000);
        $hex = $this->writeInt($this->CombatMissionID, $hex, 0x0004);
        $hex = $this->writeInt($this->totalMissionCount, $hex, 0x0008);
        $offset = 0x000C;
        for ($i = 0; $i < 10; $i++) {
            $t = $this->Outcome[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $offset = 0x0034;
        for ($i = 0; $i < 10; $i++) {
            $t = $this->BattleListIndex[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $offset = 0x005C;
        for ($i = 0; $i < 10; $i++) {
            $t = $this->CombatMissionListIndex[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $hex = $this->writeInt($this->NumPlayers, $hex, 0x0084);
        $hex = $this->writeInt($this->totalScore, $hex, 0x0088);

        return $hex;
    }
    
    
    public function getLength()
    {
        return self::PLTBATTLEPROGRESSSTATELENGTH;
    }
}