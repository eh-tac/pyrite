<?php

namespace Pyrite\XvT\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;
use Pyrite\PyriteModel;

abstract class PLTBattleProgressStateBase extends PyriteBase implements Byteable, PyriteModel
{
    use HexDecoder;
    use HexEncoder;

    /** @var int PLTBATTLEPROGRESSSTATELENGTH INT */
	public const PLTBATTLEPROGRESSSTATELENGTH = 140;
    /** @var int 0x0000 MissionsFlown INT */
	public int $MissionsFlown;
    /** @var int 0x0004 CombatMissionID INT */
	public int $CombatMissionID;
    /** @var int 0x0008 totalMissionCount INT */
	public int $totalMissionCount;
    /** @var array<int> 0x000C Outcome INT */
	public array $Outcome;
    /** @var array<int> 0x0034 BattleListIndex INT */
	public array $BattleListIndex;
    /** @var array<int> 0x005C CombatMissionListIndex INT */
	public array $CombatMissionListIndex;
    /** @var int 0x0084 NumPlayers INT */
	public int $NumPlayers;
    /** @var int 0x0088 totalScore INT */
	public int $totalScore;
    
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
        $this->afterLoadHex();
        return $this;
    }
    
    public function __debugInfo(): array
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
    
    public function toHexString($hex = null): string
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
    
    
    public function getLength(): int
    {
        return self::PLTBATTLEPROGRESSSTATELENGTH;
    }
}