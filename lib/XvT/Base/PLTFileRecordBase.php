<?php

namespace Pyrite\XvT\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;
use Pyrite\PyriteModel;
use Pyrite\XvT\PLTAIRankCountRecord;
use Pyrite\XvT\PLTCategoryTypeRecord;
use Pyrite\XvT\PLTConnectedPlayerData;
use Pyrite\XvT\PLTFactionRecord;
use Pyrite\XvT\PLTPlayerRankCountRecord;
use Pyrite\XvT\PLTTeamResultRecord;
use Pyrite\XvT\PLTTournTeamRecord;

abstract class PLTFileRecordBase extends PyriteBase implements Byteable, PyriteModel
{
    use HexDecoder;
    use HexEncoder;

    /** @var int PLTFILERECORDLENGTH INT */
	public const PLTFILERECORDLENGTH = 253754;
    /** @var string 0x0000 PilotName CHAR */
	public string $PilotName;
    /** @var int 0x000E totalScore INT */
	public int $totalScore;
    /** @var int 0x0012 PlayerID INT */
	public int $PlayerID;
    /** @var int 0x0016 continuedOrReflownMission INT */
	public int $continuedOrReflownMission;
    /** @var int 0x001A isHosting INT */
	public int $isHosting;
    /** @var int 0x001E numHumanPlayersInMission INT */
	public int $numHumanPlayersInMission;
    /** @var int 0x0022 frontFlyMode INT */
	public int $frontFlyMode;
    /** @var array<int> 0x0026 unknown0x26 INT */
	public array $unknown0x26;
    /** @var array<int> 0x0166 unknown0x166 INT */
	public array $unknown0x166;
    /** @var array<int> 0x0186 unknown0x186 INT */
	public array $unknown0x186;
    /** @var int 0x02C6 lastTeamNumber INT */
	public int $lastTeamNumber;
    /** @var int 0x02CA lastSelectedMissionType INT */
	public int $lastSelectedMissionType;
    /** @var int 0x02CE lastSelectedTraining INT */
	public int $lastSelectedTraining;
    /** @var int 0x02D2 lastSelectedMelee INT */
	public int $lastSelectedMelee;
    /** @var int 0x02D6 lastSelectedTournament INT */
	public int $lastSelectedTournament;
    /** @var int 0x02DA lastSelectedCombat INT */
	public int $lastSelectedCombat;
    /** @var int 0x02DE lastSelectedBattle INT */
	public int $lastSelectedBattle;
    /** @var string 0x02E2 GameNameString CHAR */
	public string $GameNameString;
    /** @var array<int> 0x02F8 unknown0x2F8 BYTE */
	public array $unknown0x2F8;
    /** @var string 0x0302 GameNameString2 CHAR */
	public string $GameNameString2;
    /** @var array<int> 0x0318 unknown0x318 BYTE */
	public array $unknown0x318;
    /** @var int 0x0322 lastMissionWasNonSpecific INT */
	public int $lastMissionWasNonSpecific;
    /** @var int 0x0326 unknown0x326 INT */
	public int $unknown0x326;
    /** @var int 0x032A PromoPoints INT */
	public int $PromoPoints;
    /** @var int 0x032E WorsePromoPoints INT */
	public int $WorsePromoPoints;
    /** @var int 0x0332 RankAdjustmentApplied INT */
	public int $RankAdjustmentApplied;
    /** @var int 0x0336 PercentToNextRank INT */
	public int $PercentToNextRank;
    /** @var PLTCategoryTypeRecord 0x033A totalCategoryScore PLTCategoryTypeRecord */
	public PLTCategoryTypeRecord $totalCategoryScore;
    /** @var PLTCategoryTypeRecord 0x0346 numFlownNonSeries PLTCategoryTypeRecord */
	public PLTCategoryTypeRecord $numFlownNonSeries;
    /** @var PLTCategoryTypeRecord 0x0352 numFlownSeries PLTCategoryTypeRecord */
	public PLTCategoryTypeRecord $numFlownSeries;
    /** @var PLTCategoryTypeRecord 0x035E totalKillCount PLTCategoryTypeRecord */
	public PLTCategoryTypeRecord $totalKillCount;
    /** @var PLTCategoryTypeRecord 0x036A numVanillaFriendlyKills PLTCategoryTypeRecord */
	public PLTCategoryTypeRecord $numVanillaFriendlyKills;
    /** @var array<int> 0x0376 totalCraftFullKillsExercise INT */
	public array $totalCraftFullKillsExercise;
    /** @var array<int> 0x04D6 totalCraftFullKillsMelee INT */
	public array $totalCraftFullKillsMelee;
    /** @var array<int> 0x0636 totalCraftFullKillsCombat INT */
	public array $totalCraftFullKillsCombat;
    /** @var array<int> 0x0796 totalCraftSharedKillsExercise INT */
	public array $totalCraftSharedKillsExercise;
    /** @var array<int> 0x08F6 totalCraftSharedKillsMelee INT */
	public array $totalCraftSharedKillsMelee;
    /** @var array<int> 0x0A56 totalCraftSharedKillsCombat INT */
	public array $totalCraftSharedKillsCombat;
    /** @var array<int> 0x0BB6 totalCraftAssistKillsExercise INT */
	public array $totalCraftAssistKillsExercise;
    /** @var array<int> 0x0D16 totalCraftAssistKillsMelee INT */
	public array $totalCraftAssistKillsMelee;
    /** @var array<int> 0x0E76 totalCraftAssistKillsCombat INT */
	public array $totalCraftAssistKillsCombat;
    /** @var PLTPlayerRankCountRecord 0x0FD6 totalFullKillsOnPlayerRank PLTPlayerRankCountRecord */
	public PLTPlayerRankCountRecord $totalFullKillsOnPlayerRank;
    /** @var PLTPlayerRankCountRecord 0x1102 totalSharedKillsOnPlayerRank PLTPlayerRankCountRecord */
	public PLTPlayerRankCountRecord $totalSharedKillsOnPlayerRank;
    /** @var PLTPlayerRankCountRecord 0x122E totalAssistKillsOnPlayerRank PLTPlayerRankCountRecord */
	public PLTPlayerRankCountRecord $totalAssistKillsOnPlayerRank;
    /** @var PLTAIRankCountRecord 0x135A totalFullKillsOnAIRank PLTAIRankCountRecord */
	public PLTAIRankCountRecord $totalFullKillsOnAIRank;
    /** @var PLTAIRankCountRecord 0x13A2 totalSharedKillsOnAIRank PLTAIRankCountRecord */
	public PLTAIRankCountRecord $totalSharedKillsOnAIRank;
    /** @var PLTAIRankCountRecord 0x13EA totalAssistKillsOnAIRank PLTAIRankCountRecord */
	public PLTAIRankCountRecord $totalAssistKillsOnAIRank;
    /** @var PLTCategoryTypeRecord 0x1432 totalHiddenCargoFound PLTCategoryTypeRecord */
	public PLTCategoryTypeRecord $totalHiddenCargoFound;
    /** @var PLTCategoryTypeRecord 0x143E totalLaserHit PLTCategoryTypeRecord */
	public PLTCategoryTypeRecord $totalLaserHit;
    /** @var PLTCategoryTypeRecord 0x144A totalLaserFired PLTCategoryTypeRecord */
	public PLTCategoryTypeRecord $totalLaserFired;
    /** @var PLTCategoryTypeRecord 0x1456 totalWarheadHit PLTCategoryTypeRecord */
	public PLTCategoryTypeRecord $totalWarheadHit;
    /** @var PLTCategoryTypeRecord 0x1462 totalWarheadFired PLTCategoryTypeRecord */
	public PLTCategoryTypeRecord $totalWarheadFired;
    /** @var PLTCategoryTypeRecord 0x146E totalCraftLosses PLTCategoryTypeRecord */
	public PLTCategoryTypeRecord $totalCraftLosses;
    /** @var PLTCategoryTypeRecord 0x147A totalLossesFromCollision PLTCategoryTypeRecord */
	public PLTCategoryTypeRecord $totalLossesFromCollision;
    /** @var PLTCategoryTypeRecord 0x1486 totalLossesFromStarships PLTCategoryTypeRecord */
	public PLTCategoryTypeRecord $totalLossesFromStarships;
    /** @var PLTCategoryTypeRecord 0x1492 totalLossesFromMines PLTCategoryTypeRecord */
	public PLTCategoryTypeRecord $totalLossesFromMines;
    /** @var PLTPlayerRankCountRecord 0x149E totalLossesFromPlayerRank PLTPlayerRankCountRecord */
	public PLTPlayerRankCountRecord $totalLossesFromPlayerRank;
    /** @var PLTAIRankCountRecord 0x15CA totalLossesFromAIRank PLTAIRankCountRecord */
	public PLTAIRankCountRecord $totalLossesFromAIRank;
    /** @var array<int> 0x1612 unknown0x1612 BYTE */
	public array $unknown0x1612;
    /** @var int 0x163A unknownPlaqueWon INT */
	public int $unknownPlaqueWon;
    /** @var array<PLTTournTeamRecord> 0x163E TournTeamRecords PLTTournTeamRecord */
	public array $TournTeamRecords;
    /** @var int 0x1706 numHumanPlayersUNK INT */
	public int $numHumanPlayersUNK;
    /** @var int 0x170A numTeamsUNK INT */
	public int $numTeamsUNK;
    /** @var int 0x170E unknown0x170E INT */
	public int $unknown0x170E;
    /** @var int 0x1712 unknown0x1712 INT */
	public int $unknown0x1712;
    /** @var int 0x1716 numCombatFlownInLastBattle INT */
	public int $numCombatFlownInLastBattle;
    /** @var array<int> 0x171A unknown0x171A BYTE */
	public array $unknown0x171A;
    /** @var array<int> 0x1F1E battleCombatMissionID INT */
	public array $battleCombatMissionID;
    /** @var array<int> 0x1F2E unknown0x1F2E BYTE */
	public array $unknown0x1F2E;
    /** @var int 0x2322 totalScoreForCurrentBattleUNK INT */
	public int $totalScoreForCurrentBattleUNK;
    /** @var int 0x2326 CurrentRank INT */
	public int $CurrentRank;
    /** @var int 0x232A totalCountMissionsFlown INT */
	public int $totalCountMissionsFlown;
    /** @var array<int> 0x232E RankAchievedOnMissionCount INT */
	public array $RankAchievedOnMissionCount;
    /** @var string 0x2392 RankString CHAR */
	public string $RankString;
    /** @var int 0x23B2 debriefMissionScore INT */
	public int $debriefMissionScore;
    /** @var array<int> 0x23B6 debriefFullKillsOnPlayer INT */
	public array $debriefFullKillsOnPlayer;
    /** @var array<int> 0x23D6 debriefSharedKillsOnPlayer INT */
	public array $debriefSharedKillsOnPlayer;
    /** @var array<int> 0x23F6 debriefFullKillsOnFG INT */
	public array $debriefFullKillsOnFG;
    /** @var array<int> 0x24B6 debriefSharedKillsOnFG INT */
	public array $debriefSharedKillsOnFG;
    /** @var array<int> 0x2576 debriefFullKillsByPlayer INT */
	public array $debriefFullKillsByPlayer;
    /** @var array<int> 0x2596 debriefSharedKillsByPlayer INT */
	public array $debriefSharedKillsByPlayer;
    /** @var array<int> 0x25B6 debriefFullKillsByFG INT */
	public array $debriefFullKillsByFG;
    /** @var array<int> 0x2676 debriefSharedKillsByFG INT */
	public array $debriefSharedKillsByFG;
    /** @var array<int> 0x2736 debriefMeleeAIRankFG INT */
	public array $debriefMeleeAIRankFG;
    /** @var PLTCategoryTypeRecord 0x27F6 UnknownRecord1 PLTCategoryTypeRecord */
	public PLTCategoryTypeRecord $UnknownRecord1;
    /** @var PLTCategoryTypeRecord 0x2802 UnknownRecord2 PLTCategoryTypeRecord */
	public PLTCategoryTypeRecord $UnknownRecord2;
    /** @var PLTCategoryTypeRecord 0x280E UnknownRecord3 PLTCategoryTypeRecord */
	public PLTCategoryTypeRecord $UnknownRecord3;
    /** @var PLTCategoryTypeRecord 0x281A debriefEnemyKills PLTCategoryTypeRecord */
	public PLTCategoryTypeRecord $debriefEnemyKills;
    /** @var PLTCategoryTypeRecord 0x2826 debriefFriendlyKills PLTCategoryTypeRecord */
	public PLTCategoryTypeRecord $debriefFriendlyKills;
    /** @var array<int> 0x2832 debriefFullKillsByShipTypeA INT */
	public array $debriefFullKillsByShipTypeA;
    /** @var array<int> 0x2992 debriefFullKillsByShipTypeB INT */
	public array $debriefFullKillsByShipTypeB;
    /** @var array<int> 0x2AF2 debriefFullKillsByShipTypeC INT */
	public array $debriefFullKillsByShipTypeC;
    /** @var array<int> 0x2C52 debriefSharedKillsByShipTypeA INT */
	public array $debriefSharedKillsByShipTypeA;
    /** @var array<int> 0x2DB2 debriefSharedKillsByShipTypeB INT */
	public array $debriefSharedKillsByShipTypeB;
    /** @var array<int> 0x2F12 debriefSharedKillsByShipTypeC INT */
	public array $debriefSharedKillsByShipTypeC;
    /** @var array<int> 0x3072 debriefAssistKillsByShipTypeA INT */
	public array $debriefAssistKillsByShipTypeA;
    /** @var array<int> 0x31D2 debriefAssistKillsByShipTypeB INT */
	public array $debriefAssistKillsByShipTypeB;
    /** @var array<int> 0x3332 debriefAssistKillsByShipTypeC INT */
	public array $debriefAssistKillsByShipTypeC;
    /** @var PLTPlayerRankCountRecord 0x3492 debriefFullKillsOnPlayerRank PLTPlayerRankCountRecord */
	public PLTPlayerRankCountRecord $debriefFullKillsOnPlayerRank;
    /** @var PLTPlayerRankCountRecord 0x35BE debriefSharedKillsOnPlayerRank PLTPlayerRankCountRecord */
	public PLTPlayerRankCountRecord $debriefSharedKillsOnPlayerRank;
    /** @var PLTPlayerRankCountRecord 0x36EA debriefAssistKillsOnPlayerRank PLTPlayerRankCountRecord */
	public PLTPlayerRankCountRecord $debriefAssistKillsOnPlayerRank;
    /** @var PLTAIRankCountRecord 0x3816 debriefFullKillsOnAIRank PLTAIRankCountRecord */
	public PLTAIRankCountRecord $debriefFullKillsOnAIRank;
    /** @var PLTAIRankCountRecord 0x385E debriefSharedKillsOnAIRank PLTAIRankCountRecord */
	public PLTAIRankCountRecord $debriefSharedKillsOnAIRank;
    /** @var PLTAIRankCountRecord 0x38A6 debriefAssistKillsOnAIRank PLTAIRankCountRecord */
	public PLTAIRankCountRecord $debriefAssistKillsOnAIRank;
    /** @var PLTCategoryTypeRecord 0x38EE debriefNumHiddenCargoFound PLTCategoryTypeRecord */
	public PLTCategoryTypeRecord $debriefNumHiddenCargoFound;
    /** @var PLTCategoryTypeRecord 0x38FA debriefNumCannonHits PLTCategoryTypeRecord */
	public PLTCategoryTypeRecord $debriefNumCannonHits;
    /** @var PLTCategoryTypeRecord 0x3906 debriefNumCannonFired PLTCategoryTypeRecord */
	public PLTCategoryTypeRecord $debriefNumCannonFired;
    /** @var PLTCategoryTypeRecord 0x3912 debriefNumWarheadHits PLTCategoryTypeRecord */
	public PLTCategoryTypeRecord $debriefNumWarheadHits;
    /** @var PLTCategoryTypeRecord 0x391E debriefNumWarheadFired PLTCategoryTypeRecord */
	public PLTCategoryTypeRecord $debriefNumWarheadFired;
    /** @var PLTCategoryTypeRecord 0x392A debriefNumCraftLosses PLTCategoryTypeRecord */
	public PLTCategoryTypeRecord $debriefNumCraftLosses;
    /** @var PLTCategoryTypeRecord 0x3936 debriefCraftLossesFromCollision PLTCategoryTypeRecord */
	public PLTCategoryTypeRecord $debriefCraftLossesFromCollision;
    /** @var PLTCategoryTypeRecord 0x3942 debriefCraftLossesFromStarship PLTCategoryTypeRecord */
	public PLTCategoryTypeRecord $debriefCraftLossesFromStarship;
    /** @var PLTCategoryTypeRecord 0x394E debriefCraftLossesFromMine PLTCategoryTypeRecord */
	public PLTCategoryTypeRecord $debriefCraftLossesFromMine;
    /** @var PLTPlayerRankCountRecord 0x395A debriefLossesFromPlayerRank PLTPlayerRankCountRecord */
	public PLTPlayerRankCountRecord $debriefLossesFromPlayerRank;
    /** @var PLTAIRankCountRecord 0x3A86 debriefLossesFromAIRank PLTAIRankCountRecord */
	public PLTAIRankCountRecord $debriefLossesFromAIRank;
    /** @var array<PLTConnectedPlayerData> 0x3ACE connectedPlayerData PLTConnectedPlayerData */
	public array $connectedPlayerData;
    /** @var array<PLTTeamResultRecord> 0x3D8E debriefTeamResult PLTTeamResultRecord */
	public array $debriefTeamResult;
    /** @var int 0x3EA6 lastSelectedFaction INT */
	public int $lastSelectedFaction;
    /** @var PLTFactionRecord 0x3EAA rebelSingleplayerData PLTFactionRecord */
	public PLTFactionRecord $rebelSingleplayerData;
    /** @var PLTFactionRecord 0x126CE imperialSingleplayerData PLTFactionRecord */
	public PLTFactionRecord $imperialSingleplayerData;
    /** @var PLTFactionRecord 0x20EF2 rebelMultiplayerData PLTFactionRecord */
	public PLTFactionRecord $rebelMultiplayerData;
    /** @var PLTFactionRecord 0x2F716 imperialMultiplayerData PLTFactionRecord */
	public PLTFactionRecord $imperialMultiplayerData;
    
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

        $this->PilotName = $this->getChar($hex, 0x0000, 14);
        $this->totalScore = $this->getInt($hex, 0x000E);
        $this->PlayerID = $this->getInt($hex, 0x0012);
        $this->continuedOrReflownMission = $this->getInt($hex, 0x0016);
        $this->isHosting = $this->getInt($hex, 0x001A);
        $this->numHumanPlayersInMission = $this->getInt($hex, 0x001E);
        $this->frontFlyMode = $this->getInt($hex, 0x0022);
        $this->unknown0x26 = [];
        $offset = 0x0026;
        for ($i = 0; $i < 80; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->unknown0x26[] = $t;
            $offset += 4;
        }
        $this->unknown0x166 = [];
        $offset = 0x0166;
        for ($i = 0; $i < 8; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->unknown0x166[] = $t;
            $offset += 4;
        }
        $this->unknown0x186 = [];
        $offset = 0x0186;
        for ($i = 0; $i < 80; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->unknown0x186[] = $t;
            $offset += 4;
        }
        $this->lastTeamNumber = $this->getInt($hex, 0x02C6);
        $this->lastSelectedMissionType = $this->getInt($hex, 0x02CA);
        $this->lastSelectedTraining = $this->getInt($hex, 0x02CE);
        $this->lastSelectedMelee = $this->getInt($hex, 0x02D2);
        $this->lastSelectedTournament = $this->getInt($hex, 0x02D6);
        $this->lastSelectedCombat = $this->getInt($hex, 0x02DA);
        $this->lastSelectedBattle = $this->getInt($hex, 0x02DE);
        $this->GameNameString = $this->getChar($hex, 0x02E2, 22);
        $this->unknown0x2F8 = [];
        $offset = 0x02F8;
        for ($i = 0; $i < 10; $i++) {
            $t = $this->getByte($hex, $offset);
            $this->unknown0x2F8[] = $t;
            $offset += 1;
        }
        $this->GameNameString2 = $this->getChar($hex, 0x0302, 22);
        $this->unknown0x318 = [];
        $offset = 0x0318;
        for ($i = 0; $i < 10; $i++) {
            $t = $this->getByte($hex, $offset);
            $this->unknown0x318[] = $t;
            $offset += 1;
        }
        $this->lastMissionWasNonSpecific = $this->getInt($hex, 0x0322);
        $this->unknown0x326 = $this->getInt($hex, 0x0326);
        $this->PromoPoints = $this->getInt($hex, 0x032A);
        $this->WorsePromoPoints = $this->getInt($hex, 0x032E);
        $this->RankAdjustmentApplied = $this->getInt($hex, 0x0332);
        $this->PercentToNextRank = $this->getInt($hex, 0x0336);
        $this->totalCategoryScore = (new PLTCategoryTypeRecord(substr($hex, 0x033A), $this->TIE))->loadHex();
        $this->numFlownNonSeries = (new PLTCategoryTypeRecord(substr($hex, 0x0346), $this->TIE))->loadHex();
        $this->numFlownSeries = (new PLTCategoryTypeRecord(substr($hex, 0x0352), $this->TIE))->loadHex();
        $this->totalKillCount = (new PLTCategoryTypeRecord(substr($hex, 0x035E), $this->TIE))->loadHex();
        $this->numVanillaFriendlyKills = (new PLTCategoryTypeRecord(substr($hex, 0x036A), $this->TIE))->loadHex();
        $this->totalCraftFullKillsExercise = [];
        $offset = 0x0376;
        for ($i = 0; $i < 88; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->totalCraftFullKillsExercise[] = $t;
            $offset += 4;
        }
        $this->totalCraftFullKillsMelee = [];
        $offset = 0x04D6;
        for ($i = 0; $i < 88; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->totalCraftFullKillsMelee[] = $t;
            $offset += 4;
        }
        $this->totalCraftFullKillsCombat = [];
        $offset = 0x0636;
        for ($i = 0; $i < 88; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->totalCraftFullKillsCombat[] = $t;
            $offset += 4;
        }
        $this->totalCraftSharedKillsExercise = [];
        $offset = 0x0796;
        for ($i = 0; $i < 88; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->totalCraftSharedKillsExercise[] = $t;
            $offset += 4;
        }
        $this->totalCraftSharedKillsMelee = [];
        $offset = 0x08F6;
        for ($i = 0; $i < 88; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->totalCraftSharedKillsMelee[] = $t;
            $offset += 4;
        }
        $this->totalCraftSharedKillsCombat = [];
        $offset = 0x0A56;
        for ($i = 0; $i < 88; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->totalCraftSharedKillsCombat[] = $t;
            $offset += 4;
        }
        $this->totalCraftAssistKillsExercise = [];
        $offset = 0x0BB6;
        for ($i = 0; $i < 88; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->totalCraftAssistKillsExercise[] = $t;
            $offset += 4;
        }
        $this->totalCraftAssistKillsMelee = [];
        $offset = 0x0D16;
        for ($i = 0; $i < 88; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->totalCraftAssistKillsMelee[] = $t;
            $offset += 4;
        }
        $this->totalCraftAssistKillsCombat = [];
        $offset = 0x0E76;
        for ($i = 0; $i < 88; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->totalCraftAssistKillsCombat[] = $t;
            $offset += 4;
        }
        $this->totalFullKillsOnPlayerRank = (new PLTPlayerRankCountRecord(substr($hex, 0x0FD6), $this->TIE))->loadHex();
        $this->totalSharedKillsOnPlayerRank = (new PLTPlayerRankCountRecord(substr($hex, 0x1102), $this->TIE))->loadHex();
        $this->totalAssistKillsOnPlayerRank = (new PLTPlayerRankCountRecord(substr($hex, 0x122E), $this->TIE))->loadHex();
        $this->totalFullKillsOnAIRank = (new PLTAIRankCountRecord(substr($hex, 0x135A), $this->TIE))->loadHex();
        $this->totalSharedKillsOnAIRank = (new PLTAIRankCountRecord(substr($hex, 0x13A2), $this->TIE))->loadHex();
        $this->totalAssistKillsOnAIRank = (new PLTAIRankCountRecord(substr($hex, 0x13EA), $this->TIE))->loadHex();
        $this->totalHiddenCargoFound = (new PLTCategoryTypeRecord(substr($hex, 0x1432), $this->TIE))->loadHex();
        $this->totalLaserHit = (new PLTCategoryTypeRecord(substr($hex, 0x143E), $this->TIE))->loadHex();
        $this->totalLaserFired = (new PLTCategoryTypeRecord(substr($hex, 0x144A), $this->TIE))->loadHex();
        $this->totalWarheadHit = (new PLTCategoryTypeRecord(substr($hex, 0x1456), $this->TIE))->loadHex();
        $this->totalWarheadFired = (new PLTCategoryTypeRecord(substr($hex, 0x1462), $this->TIE))->loadHex();
        $this->totalCraftLosses = (new PLTCategoryTypeRecord(substr($hex, 0x146E), $this->TIE))->loadHex();
        $this->totalLossesFromCollision = (new PLTCategoryTypeRecord(substr($hex, 0x147A), $this->TIE))->loadHex();
        $this->totalLossesFromStarships = (new PLTCategoryTypeRecord(substr($hex, 0x1486), $this->TIE))->loadHex();
        $this->totalLossesFromMines = (new PLTCategoryTypeRecord(substr($hex, 0x1492), $this->TIE))->loadHex();
        $this->totalLossesFromPlayerRank = (new PLTPlayerRankCountRecord(substr($hex, 0x149E), $this->TIE))->loadHex();
        $this->totalLossesFromAIRank = (new PLTAIRankCountRecord(substr($hex, 0x15CA), $this->TIE))->loadHex();
        $this->unknown0x1612 = [];
        $offset = 0x1612;
        for ($i = 0; $i < 40; $i++) {
            $t = $this->getByte($hex, $offset);
            $this->unknown0x1612[] = $t;
            $offset += 1;
        }
        $this->unknownPlaqueWon = $this->getInt($hex, 0x163A);
        $this->TournTeamRecords = [];
        $offset = 0x163E;
        for ($i = 0; $i < 10; $i++) {
            $t = (new PLTTournTeamRecord(substr($hex, $offset), $this->TIE))->loadHex();
            $this->TournTeamRecords[] = $t;
            $offset += $t->getLength();
        }
        $this->numHumanPlayersUNK = $this->getInt($hex, 0x1706);
        $this->numTeamsUNK = $this->getInt($hex, 0x170A);
        $this->unknown0x170E = $this->getInt($hex, 0x170E);
        $this->unknown0x1712 = $this->getInt($hex, 0x1712);
        $this->numCombatFlownInLastBattle = $this->getInt($hex, 0x1716);
        $this->unknown0x171A = [];
        $offset = 0x171A;
        for ($i = 0; $i < 2052; $i++) {
            $t = $this->getByte($hex, $offset);
            $this->unknown0x171A[] = $t;
            $offset += 1;
        }
        $this->battleCombatMissionID = [];
        $offset = 0x1F1E;
        for ($i = 0; $i < 4; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->battleCombatMissionID[] = $t;
            $offset += 4;
        }
        $this->unknown0x1F2E = [];
        $offset = 0x1F2E;
        for ($i = 0; $i < 1012; $i++) {
            $t = $this->getByte($hex, $offset);
            $this->unknown0x1F2E[] = $t;
            $offset += 1;
        }
        $this->totalScoreForCurrentBattleUNK = $this->getInt($hex, 0x2322);
        $this->CurrentRank = $this->getInt($hex, 0x2326);
        $this->totalCountMissionsFlown = $this->getInt($hex, 0x232A);
        $this->RankAchievedOnMissionCount = [];
        $offset = 0x232E;
        for ($i = 0; $i < 25; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->RankAchievedOnMissionCount[] = $t;
            $offset += 4;
        }
        $this->RankString = $this->getChar($hex, 0x2392, 32);
        $this->debriefMissionScore = $this->getInt($hex, 0x23B2);
        $this->debriefFullKillsOnPlayer = [];
        $offset = 0x23B6;
        for ($i = 0; $i < 8; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->debriefFullKillsOnPlayer[] = $t;
            $offset += 4;
        }
        $this->debriefSharedKillsOnPlayer = [];
        $offset = 0x23D6;
        for ($i = 0; $i < 8; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->debriefSharedKillsOnPlayer[] = $t;
            $offset += 4;
        }
        $this->debriefFullKillsOnFG = [];
        $offset = 0x23F6;
        for ($i = 0; $i < 48; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->debriefFullKillsOnFG[] = $t;
            $offset += 4;
        }
        $this->debriefSharedKillsOnFG = [];
        $offset = 0x24B6;
        for ($i = 0; $i < 48; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->debriefSharedKillsOnFG[] = $t;
            $offset += 4;
        }
        $this->debriefFullKillsByPlayer = [];
        $offset = 0x2576;
        for ($i = 0; $i < 8; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->debriefFullKillsByPlayer[] = $t;
            $offset += 4;
        }
        $this->debriefSharedKillsByPlayer = [];
        $offset = 0x2596;
        for ($i = 0; $i < 8; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->debriefSharedKillsByPlayer[] = $t;
            $offset += 4;
        }
        $this->debriefFullKillsByFG = [];
        $offset = 0x25B6;
        for ($i = 0; $i < 48; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->debriefFullKillsByFG[] = $t;
            $offset += 4;
        }
        $this->debriefSharedKillsByFG = [];
        $offset = 0x2676;
        for ($i = 0; $i < 48; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->debriefSharedKillsByFG[] = $t;
            $offset += 4;
        }
        $this->debriefMeleeAIRankFG = [];
        $offset = 0x2736;
        for ($i = 0; $i < 48; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->debriefMeleeAIRankFG[] = $t;
            $offset += 4;
        }
        $this->UnknownRecord1 = (new PLTCategoryTypeRecord(substr($hex, 0x27F6), $this->TIE))->loadHex();
        $this->UnknownRecord2 = (new PLTCategoryTypeRecord(substr($hex, 0x2802), $this->TIE))->loadHex();
        $this->UnknownRecord3 = (new PLTCategoryTypeRecord(substr($hex, 0x280E), $this->TIE))->loadHex();
        $this->debriefEnemyKills = (new PLTCategoryTypeRecord(substr($hex, 0x281A), $this->TIE))->loadHex();
        $this->debriefFriendlyKills = (new PLTCategoryTypeRecord(substr($hex, 0x2826), $this->TIE))->loadHex();
        $this->debriefFullKillsByShipTypeA = [];
        $offset = 0x2832;
        for ($i = 0; $i < 88; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->debriefFullKillsByShipTypeA[] = $t;
            $offset += 4;
        }
        $this->debriefFullKillsByShipTypeB = [];
        $offset = 0x2992;
        for ($i = 0; $i < 88; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->debriefFullKillsByShipTypeB[] = $t;
            $offset += 4;
        }
        $this->debriefFullKillsByShipTypeC = [];
        $offset = 0x2AF2;
        for ($i = 0; $i < 88; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->debriefFullKillsByShipTypeC[] = $t;
            $offset += 4;
        }
        $this->debriefSharedKillsByShipTypeA = [];
        $offset = 0x2C52;
        for ($i = 0; $i < 88; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->debriefSharedKillsByShipTypeA[] = $t;
            $offset += 4;
        }
        $this->debriefSharedKillsByShipTypeB = [];
        $offset = 0x2DB2;
        for ($i = 0; $i < 88; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->debriefSharedKillsByShipTypeB[] = $t;
            $offset += 4;
        }
        $this->debriefSharedKillsByShipTypeC = [];
        $offset = 0x2F12;
        for ($i = 0; $i < 88; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->debriefSharedKillsByShipTypeC[] = $t;
            $offset += 4;
        }
        $this->debriefAssistKillsByShipTypeA = [];
        $offset = 0x3072;
        for ($i = 0; $i < 88; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->debriefAssistKillsByShipTypeA[] = $t;
            $offset += 4;
        }
        $this->debriefAssistKillsByShipTypeB = [];
        $offset = 0x31D2;
        for ($i = 0; $i < 88; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->debriefAssistKillsByShipTypeB[] = $t;
            $offset += 4;
        }
        $this->debriefAssistKillsByShipTypeC = [];
        $offset = 0x3332;
        for ($i = 0; $i < 88; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->debriefAssistKillsByShipTypeC[] = $t;
            $offset += 4;
        }
        $this->debriefFullKillsOnPlayerRank = (new PLTPlayerRankCountRecord(substr($hex, 0x3492), $this->TIE))->loadHex();
        $this->debriefSharedKillsOnPlayerRank = (new PLTPlayerRankCountRecord(substr($hex, 0x35BE), $this->TIE))->loadHex();
        $this->debriefAssistKillsOnPlayerRank = (new PLTPlayerRankCountRecord(substr($hex, 0x36EA), $this->TIE))->loadHex();
        $this->debriefFullKillsOnAIRank = (new PLTAIRankCountRecord(substr($hex, 0x3816), $this->TIE))->loadHex();
        $this->debriefSharedKillsOnAIRank = (new PLTAIRankCountRecord(substr($hex, 0x385E), $this->TIE))->loadHex();
        $this->debriefAssistKillsOnAIRank = (new PLTAIRankCountRecord(substr($hex, 0x38A6), $this->TIE))->loadHex();
        $this->debriefNumHiddenCargoFound = (new PLTCategoryTypeRecord(substr($hex, 0x38EE), $this->TIE))->loadHex();
        $this->debriefNumCannonHits = (new PLTCategoryTypeRecord(substr($hex, 0x38FA), $this->TIE))->loadHex();
        $this->debriefNumCannonFired = (new PLTCategoryTypeRecord(substr($hex, 0x3906), $this->TIE))->loadHex();
        $this->debriefNumWarheadHits = (new PLTCategoryTypeRecord(substr($hex, 0x3912), $this->TIE))->loadHex();
        $this->debriefNumWarheadFired = (new PLTCategoryTypeRecord(substr($hex, 0x391E), $this->TIE))->loadHex();
        $this->debriefNumCraftLosses = (new PLTCategoryTypeRecord(substr($hex, 0x392A), $this->TIE))->loadHex();
        $this->debriefCraftLossesFromCollision = (new PLTCategoryTypeRecord(substr($hex, 0x3936), $this->TIE))->loadHex();
        $this->debriefCraftLossesFromStarship = (new PLTCategoryTypeRecord(substr($hex, 0x3942), $this->TIE))->loadHex();
        $this->debriefCraftLossesFromMine = (new PLTCategoryTypeRecord(substr($hex, 0x394E), $this->TIE))->loadHex();
        $this->debriefLossesFromPlayerRank = (new PLTPlayerRankCountRecord(substr($hex, 0x395A), $this->TIE))->loadHex();
        $this->debriefLossesFromAIRank = (new PLTAIRankCountRecord(substr($hex, 0x3A86), $this->TIE))->loadHex();
        $this->connectedPlayerData = [];
        $offset = 0x3ACE;
        for ($i = 0; $i < 8; $i++) {
            $t = (new PLTConnectedPlayerData(substr($hex, $offset), $this->TIE))->loadHex();
            $this->connectedPlayerData[] = $t;
            $offset += $t->getLength();
        }
        $this->debriefTeamResult = [];
        $offset = 0x3D8E;
        for ($i = 0; $i < 10; $i++) {
            $t = (new PLTTeamResultRecord(substr($hex, $offset), $this->TIE))->loadHex();
            $this->debriefTeamResult[] = $t;
            $offset += $t->getLength();
        }
        $this->lastSelectedFaction = $this->getInt($hex, 0x3EA6);
        $this->rebelSingleplayerData = (new PLTFactionRecord(substr($hex, 0x3EAA), $this->TIE))->loadHex();
        $this->imperialSingleplayerData = (new PLTFactionRecord(substr($hex, 0x126CE), $this->TIE))->loadHex();
        $this->rebelMultiplayerData = (new PLTFactionRecord(substr($hex, 0x20EF2), $this->TIE))->loadHex();
        $this->imperialMultiplayerData = (new PLTFactionRecord(substr($hex, 0x2F716), $this->TIE))->loadHex();
        

        $this->hex = substr($this->hex, 0, $this->getLength());
        $this->afterLoadHex();
        return $this;
    }
    
    public function __debugInfo(): array
    {
        return [
            "PilotName" => $this->PilotName,
            "totalScore" => $this->totalScore,
            "PlayerID" => $this->PlayerID,
            "continuedOrReflownMission" => $this->continuedOrReflownMission,
            "isHosting" => $this->isHosting,
            "numHumanPlayersInMission" => $this->numHumanPlayersInMission,
            "frontFlyMode" => $this->frontFlyMode,
            "unknown0x26" => $this->unknown0x26,
            "unknown0x166" => $this->unknown0x166,
            "unknown0x186" => $this->unknown0x186,
            "lastTeamNumber" => $this->lastTeamNumber,
            "lastSelectedMissionType" => $this->lastSelectedMissionType,
            "lastSelectedTraining" => $this->lastSelectedTraining,
            "lastSelectedMelee" => $this->lastSelectedMelee,
            "lastSelectedTournament" => $this->lastSelectedTournament,
            "lastSelectedCombat" => $this->lastSelectedCombat,
            "lastSelectedBattle" => $this->lastSelectedBattle,
            "GameNameString" => $this->GameNameString,
            "unknown0x2F8" => $this->unknown0x2F8,
            "GameNameString2" => $this->GameNameString2,
            "unknown0x318" => $this->unknown0x318,
            "lastMissionWasNonSpecific" => $this->lastMissionWasNonSpecific,
            "unknown0x326" => $this->unknown0x326,
            "PromoPoints" => $this->PromoPoints,
            "WorsePromoPoints" => $this->WorsePromoPoints,
            "RankAdjustmentApplied" => $this->RankAdjustmentApplied,
            "PercentToNextRank" => $this->PercentToNextRank,
            "totalCategoryScore" => $this->totalCategoryScore,
            "numFlownNonSeries" => $this->numFlownNonSeries,
            "numFlownSeries" => $this->numFlownSeries,
            "totalKillCount" => $this->totalKillCount,
            "numVanillaFriendlyKills" => $this->numVanillaFriendlyKills,
            "totalCraftFullKillsExercise" => $this->totalCraftFullKillsExercise,
            "totalCraftFullKillsMelee" => $this->totalCraftFullKillsMelee,
            "totalCraftFullKillsCombat" => $this->totalCraftFullKillsCombat,
            "totalCraftSharedKillsExercise" => $this->totalCraftSharedKillsExercise,
            "totalCraftSharedKillsMelee" => $this->totalCraftSharedKillsMelee,
            "totalCraftSharedKillsCombat" => $this->totalCraftSharedKillsCombat,
            "totalCraftAssistKillsExercise" => $this->totalCraftAssistKillsExercise,
            "totalCraftAssistKillsMelee" => $this->totalCraftAssistKillsMelee,
            "totalCraftAssistKillsCombat" => $this->totalCraftAssistKillsCombat,
            "totalFullKillsOnPlayerRank" => $this->totalFullKillsOnPlayerRank,
            "totalSharedKillsOnPlayerRank" => $this->totalSharedKillsOnPlayerRank,
            "totalAssistKillsOnPlayerRank" => $this->totalAssistKillsOnPlayerRank,
            "totalFullKillsOnAIRank" => $this->totalFullKillsOnAIRank,
            "totalSharedKillsOnAIRank" => $this->totalSharedKillsOnAIRank,
            "totalAssistKillsOnAIRank" => $this->totalAssistKillsOnAIRank,
            "totalHiddenCargoFound" => $this->totalHiddenCargoFound,
            "totalLaserHit" => $this->totalLaserHit,
            "totalLaserFired" => $this->totalLaserFired,
            "totalWarheadHit" => $this->totalWarheadHit,
            "totalWarheadFired" => $this->totalWarheadFired,
            "totalCraftLosses" => $this->totalCraftLosses,
            "totalLossesFromCollision" => $this->totalLossesFromCollision,
            "totalLossesFromStarships" => $this->totalLossesFromStarships,
            "totalLossesFromMines" => $this->totalLossesFromMines,
            "totalLossesFromPlayerRank" => $this->totalLossesFromPlayerRank,
            "totalLossesFromAIRank" => $this->totalLossesFromAIRank,
            "unknown0x1612" => $this->unknown0x1612,
            "unknownPlaqueWon" => $this->unknownPlaqueWon,
            "TournTeamRecords" => $this->TournTeamRecords,
            "numHumanPlayersUNK" => $this->numHumanPlayersUNK,
            "numTeamsUNK" => $this->numTeamsUNK,
            "unknown0x170E" => $this->unknown0x170E,
            "unknown0x1712" => $this->unknown0x1712,
            "numCombatFlownInLastBattle" => $this->numCombatFlownInLastBattle,
            "unknown0x171A" => $this->unknown0x171A,
            "battleCombatMissionID" => $this->battleCombatMissionID,
            "unknown0x1F2E" => $this->unknown0x1F2E,
            "totalScoreForCurrentBattleUNK" => $this->totalScoreForCurrentBattleUNK,
            "CurrentRank" => $this->CurrentRank,
            "totalCountMissionsFlown" => $this->totalCountMissionsFlown,
            "RankAchievedOnMissionCount" => $this->RankAchievedOnMissionCount,
            "RankString" => $this->RankString,
            "debriefMissionScore" => $this->debriefMissionScore,
            "debriefFullKillsOnPlayer" => $this->debriefFullKillsOnPlayer,
            "debriefSharedKillsOnPlayer" => $this->debriefSharedKillsOnPlayer,
            "debriefFullKillsOnFG" => $this->debriefFullKillsOnFG,
            "debriefSharedKillsOnFG" => $this->debriefSharedKillsOnFG,
            "debriefFullKillsByPlayer" => $this->debriefFullKillsByPlayer,
            "debriefSharedKillsByPlayer" => $this->debriefSharedKillsByPlayer,
            "debriefFullKillsByFG" => $this->debriefFullKillsByFG,
            "debriefSharedKillsByFG" => $this->debriefSharedKillsByFG,
            "debriefMeleeAIRankFG" => $this->debriefMeleeAIRankFG,
            "UnknownRecord1" => $this->UnknownRecord1,
            "UnknownRecord2" => $this->UnknownRecord2,
            "UnknownRecord3" => $this->UnknownRecord3,
            "debriefEnemyKills" => $this->debriefEnemyKills,
            "debriefFriendlyKills" => $this->debriefFriendlyKills,
            "debriefFullKillsByShipTypeA" => $this->debriefFullKillsByShipTypeA,
            "debriefFullKillsByShipTypeB" => $this->debriefFullKillsByShipTypeB,
            "debriefFullKillsByShipTypeC" => $this->debriefFullKillsByShipTypeC,
            "debriefSharedKillsByShipTypeA" => $this->debriefSharedKillsByShipTypeA,
            "debriefSharedKillsByShipTypeB" => $this->debriefSharedKillsByShipTypeB,
            "debriefSharedKillsByShipTypeC" => $this->debriefSharedKillsByShipTypeC,
            "debriefAssistKillsByShipTypeA" => $this->debriefAssistKillsByShipTypeA,
            "debriefAssistKillsByShipTypeB" => $this->debriefAssistKillsByShipTypeB,
            "debriefAssistKillsByShipTypeC" => $this->debriefAssistKillsByShipTypeC,
            "debriefFullKillsOnPlayerRank" => $this->debriefFullKillsOnPlayerRank,
            "debriefSharedKillsOnPlayerRank" => $this->debriefSharedKillsOnPlayerRank,
            "debriefAssistKillsOnPlayerRank" => $this->debriefAssistKillsOnPlayerRank,
            "debriefFullKillsOnAIRank" => $this->debriefFullKillsOnAIRank,
            "debriefSharedKillsOnAIRank" => $this->debriefSharedKillsOnAIRank,
            "debriefAssistKillsOnAIRank" => $this->debriefAssistKillsOnAIRank,
            "debriefNumHiddenCargoFound" => $this->debriefNumHiddenCargoFound,
            "debriefNumCannonHits" => $this->debriefNumCannonHits,
            "debriefNumCannonFired" => $this->debriefNumCannonFired,
            "debriefNumWarheadHits" => $this->debriefNumWarheadHits,
            "debriefNumWarheadFired" => $this->debriefNumWarheadFired,
            "debriefNumCraftLosses" => $this->debriefNumCraftLosses,
            "debriefCraftLossesFromCollision" => $this->debriefCraftLossesFromCollision,
            "debriefCraftLossesFromStarship" => $this->debriefCraftLossesFromStarship,
            "debriefCraftLossesFromMine" => $this->debriefCraftLossesFromMine,
            "debriefLossesFromPlayerRank" => $this->debriefLossesFromPlayerRank,
            "debriefLossesFromAIRank" => $this->debriefLossesFromAIRank,
            "connectedPlayerData" => $this->connectedPlayerData,
            "debriefTeamResult" => $this->debriefTeamResult,
            "lastSelectedFaction" => $this->lastSelectedFaction,
            "rebelSingleplayerData" => $this->rebelSingleplayerData,
            "imperialSingleplayerData" => $this->imperialSingleplayerData,
            "rebelMultiplayerData" => $this->rebelMultiplayerData,
            "imperialMultiplayerData" => $this->imperialMultiplayerData
        ];
    }
    
    public function toHexString($hex = null): string
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $hex = $this->writeChar($this->PilotName, $hex, 0x0000);
        $hex = $this->writeInt($this->totalScore, $hex, 0x000E);
        $hex = $this->writeInt($this->PlayerID, $hex, 0x0012);
        $hex = $this->writeInt($this->continuedOrReflownMission, $hex, 0x0016);
        $hex = $this->writeInt($this->isHosting, $hex, 0x001A);
        $hex = $this->writeInt($this->numHumanPlayersInMission, $hex, 0x001E);
        $hex = $this->writeInt($this->frontFlyMode, $hex, 0x0022);
        $offset = 0x0026;
        for ($i = 0; $i < 80; $i++) {
            $t = $this->unknown0x26[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $offset = 0x0166;
        for ($i = 0; $i < 8; $i++) {
            $t = $this->unknown0x166[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $offset = 0x0186;
        for ($i = 0; $i < 80; $i++) {
            $t = $this->unknown0x186[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $hex = $this->writeInt($this->lastTeamNumber, $hex, 0x02C6);
        $hex = $this->writeInt($this->lastSelectedMissionType, $hex, 0x02CA);
        $hex = $this->writeInt($this->lastSelectedTraining, $hex, 0x02CE);
        $hex = $this->writeInt($this->lastSelectedMelee, $hex, 0x02D2);
        $hex = $this->writeInt($this->lastSelectedTournament, $hex, 0x02D6);
        $hex = $this->writeInt($this->lastSelectedCombat, $hex, 0x02DA);
        $hex = $this->writeInt($this->lastSelectedBattle, $hex, 0x02DE);
        $hex = $this->writeChar($this->GameNameString, $hex, 0x02E2);
        $offset = 0x02F8;
        for ($i = 0; $i < 10; $i++) {
            $t = $this->unknown0x2F8[$i];
            $hex = $this->writeByte($t, $hex, $offset);
            $offset += 1;
        }
        $hex = $this->writeChar($this->GameNameString2, $hex, 0x0302);
        $offset = 0x0318;
        for ($i = 0; $i < 10; $i++) {
            $t = $this->unknown0x318[$i];
            $hex = $this->writeByte($t, $hex, $offset);
            $offset += 1;
        }
        $hex = $this->writeInt($this->lastMissionWasNonSpecific, $hex, 0x0322);
        $hex = $this->writeInt($this->unknown0x326, $hex, 0x0326);
        $hex = $this->writeInt($this->PromoPoints, $hex, 0x032A);
        $hex = $this->writeInt($this->WorsePromoPoints, $hex, 0x032E);
        $hex = $this->writeInt($this->RankAdjustmentApplied, $hex, 0x0332);
        $hex = $this->writeInt($this->PercentToNextRank, $hex, 0x0336);
        $hex = $this->writeObject($this->totalCategoryScore, $hex, 0x033A);
        $hex = $this->writeObject($this->numFlownNonSeries, $hex, 0x0346);
        $hex = $this->writeObject($this->numFlownSeries, $hex, 0x0352);
        $hex = $this->writeObject($this->totalKillCount, $hex, 0x035E);
        $hex = $this->writeObject($this->numVanillaFriendlyKills, $hex, 0x036A);
        $offset = 0x0376;
        for ($i = 0; $i < 88; $i++) {
            $t = $this->totalCraftFullKillsExercise[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $offset = 0x04D6;
        for ($i = 0; $i < 88; $i++) {
            $t = $this->totalCraftFullKillsMelee[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $offset = 0x0636;
        for ($i = 0; $i < 88; $i++) {
            $t = $this->totalCraftFullKillsCombat[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $offset = 0x0796;
        for ($i = 0; $i < 88; $i++) {
            $t = $this->totalCraftSharedKillsExercise[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $offset = 0x08F6;
        for ($i = 0; $i < 88; $i++) {
            $t = $this->totalCraftSharedKillsMelee[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $offset = 0x0A56;
        for ($i = 0; $i < 88; $i++) {
            $t = $this->totalCraftSharedKillsCombat[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $offset = 0x0BB6;
        for ($i = 0; $i < 88; $i++) {
            $t = $this->totalCraftAssistKillsExercise[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $offset = 0x0D16;
        for ($i = 0; $i < 88; $i++) {
            $t = $this->totalCraftAssistKillsMelee[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $offset = 0x0E76;
        for ($i = 0; $i < 88; $i++) {
            $t = $this->totalCraftAssistKillsCombat[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $hex = $this->writeObject($this->totalFullKillsOnPlayerRank, $hex, 0x0FD6);
        $hex = $this->writeObject($this->totalSharedKillsOnPlayerRank, $hex, 0x1102);
        $hex = $this->writeObject($this->totalAssistKillsOnPlayerRank, $hex, 0x122E);
        $hex = $this->writeObject($this->totalFullKillsOnAIRank, $hex, 0x135A);
        $hex = $this->writeObject($this->totalSharedKillsOnAIRank, $hex, 0x13A2);
        $hex = $this->writeObject($this->totalAssistKillsOnAIRank, $hex, 0x13EA);
        $hex = $this->writeObject($this->totalHiddenCargoFound, $hex, 0x1432);
        $hex = $this->writeObject($this->totalLaserHit, $hex, 0x143E);
        $hex = $this->writeObject($this->totalLaserFired, $hex, 0x144A);
        $hex = $this->writeObject($this->totalWarheadHit, $hex, 0x1456);
        $hex = $this->writeObject($this->totalWarheadFired, $hex, 0x1462);
        $hex = $this->writeObject($this->totalCraftLosses, $hex, 0x146E);
        $hex = $this->writeObject($this->totalLossesFromCollision, $hex, 0x147A);
        $hex = $this->writeObject($this->totalLossesFromStarships, $hex, 0x1486);
        $hex = $this->writeObject($this->totalLossesFromMines, $hex, 0x1492);
        $hex = $this->writeObject($this->totalLossesFromPlayerRank, $hex, 0x149E);
        $hex = $this->writeObject($this->totalLossesFromAIRank, $hex, 0x15CA);
        $offset = 0x1612;
        for ($i = 0; $i < 40; $i++) {
            $t = $this->unknown0x1612[$i];
            $hex = $this->writeByte($t, $hex, $offset);
            $offset += 1;
        }
        $hex = $this->writeInt($this->unknownPlaqueWon, $hex, 0x163A);
        $offset = 0x163E;
        for ($i = 0; $i < 10; $i++) {
            $t = $this->TournTeamRecords[$i];
            $hex = $this->writeObject($t, $hex, $offset);
            $offset += $t->getLength();
        }
        $hex = $this->writeInt($this->numHumanPlayersUNK, $hex, 0x1706);
        $hex = $this->writeInt($this->numTeamsUNK, $hex, 0x170A);
        $hex = $this->writeInt($this->unknown0x170E, $hex, 0x170E);
        $hex = $this->writeInt($this->unknown0x1712, $hex, 0x1712);
        $hex = $this->writeInt($this->numCombatFlownInLastBattle, $hex, 0x1716);
        $offset = 0x171A;
        for ($i = 0; $i < 2052; $i++) {
            $t = $this->unknown0x171A[$i];
            $hex = $this->writeByte($t, $hex, $offset);
            $offset += 1;
        }
        $offset = 0x1F1E;
        for ($i = 0; $i < 4; $i++) {
            $t = $this->battleCombatMissionID[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $offset = 0x1F2E;
        for ($i = 0; $i < 1012; $i++) {
            $t = $this->unknown0x1F2E[$i];
            $hex = $this->writeByte($t, $hex, $offset);
            $offset += 1;
        }
        $hex = $this->writeInt($this->totalScoreForCurrentBattleUNK, $hex, 0x2322);
        $hex = $this->writeInt($this->CurrentRank, $hex, 0x2326);
        $hex = $this->writeInt($this->totalCountMissionsFlown, $hex, 0x232A);
        $offset = 0x232E;
        for ($i = 0; $i < 25; $i++) {
            $t = $this->RankAchievedOnMissionCount[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $hex = $this->writeChar($this->RankString, $hex, 0x2392);
        $hex = $this->writeInt($this->debriefMissionScore, $hex, 0x23B2);
        $offset = 0x23B6;
        for ($i = 0; $i < 8; $i++) {
            $t = $this->debriefFullKillsOnPlayer[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $offset = 0x23D6;
        for ($i = 0; $i < 8; $i++) {
            $t = $this->debriefSharedKillsOnPlayer[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $offset = 0x23F6;
        for ($i = 0; $i < 48; $i++) {
            $t = $this->debriefFullKillsOnFG[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $offset = 0x24B6;
        for ($i = 0; $i < 48; $i++) {
            $t = $this->debriefSharedKillsOnFG[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $offset = 0x2576;
        for ($i = 0; $i < 8; $i++) {
            $t = $this->debriefFullKillsByPlayer[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $offset = 0x2596;
        for ($i = 0; $i < 8; $i++) {
            $t = $this->debriefSharedKillsByPlayer[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $offset = 0x25B6;
        for ($i = 0; $i < 48; $i++) {
            $t = $this->debriefFullKillsByFG[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $offset = 0x2676;
        for ($i = 0; $i < 48; $i++) {
            $t = $this->debriefSharedKillsByFG[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $offset = 0x2736;
        for ($i = 0; $i < 48; $i++) {
            $t = $this->debriefMeleeAIRankFG[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $hex = $this->writeObject($this->UnknownRecord1, $hex, 0x27F6);
        $hex = $this->writeObject($this->UnknownRecord2, $hex, 0x2802);
        $hex = $this->writeObject($this->UnknownRecord3, $hex, 0x280E);
        $hex = $this->writeObject($this->debriefEnemyKills, $hex, 0x281A);
        $hex = $this->writeObject($this->debriefFriendlyKills, $hex, 0x2826);
        $offset = 0x2832;
        for ($i = 0; $i < 88; $i++) {
            $t = $this->debriefFullKillsByShipTypeA[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $offset = 0x2992;
        for ($i = 0; $i < 88; $i++) {
            $t = $this->debriefFullKillsByShipTypeB[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $offset = 0x2AF2;
        for ($i = 0; $i < 88; $i++) {
            $t = $this->debriefFullKillsByShipTypeC[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $offset = 0x2C52;
        for ($i = 0; $i < 88; $i++) {
            $t = $this->debriefSharedKillsByShipTypeA[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $offset = 0x2DB2;
        for ($i = 0; $i < 88; $i++) {
            $t = $this->debriefSharedKillsByShipTypeB[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $offset = 0x2F12;
        for ($i = 0; $i < 88; $i++) {
            $t = $this->debriefSharedKillsByShipTypeC[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $offset = 0x3072;
        for ($i = 0; $i < 88; $i++) {
            $t = $this->debriefAssistKillsByShipTypeA[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $offset = 0x31D2;
        for ($i = 0; $i < 88; $i++) {
            $t = $this->debriefAssistKillsByShipTypeB[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $offset = 0x3332;
        for ($i = 0; $i < 88; $i++) {
            $t = $this->debriefAssistKillsByShipTypeC[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $hex = $this->writeObject($this->debriefFullKillsOnPlayerRank, $hex, 0x3492);
        $hex = $this->writeObject($this->debriefSharedKillsOnPlayerRank, $hex, 0x35BE);
        $hex = $this->writeObject($this->debriefAssistKillsOnPlayerRank, $hex, 0x36EA);
        $hex = $this->writeObject($this->debriefFullKillsOnAIRank, $hex, 0x3816);
        $hex = $this->writeObject($this->debriefSharedKillsOnAIRank, $hex, 0x385E);
        $hex = $this->writeObject($this->debriefAssistKillsOnAIRank, $hex, 0x38A6);
        $hex = $this->writeObject($this->debriefNumHiddenCargoFound, $hex, 0x38EE);
        $hex = $this->writeObject($this->debriefNumCannonHits, $hex, 0x38FA);
        $hex = $this->writeObject($this->debriefNumCannonFired, $hex, 0x3906);
        $hex = $this->writeObject($this->debriefNumWarheadHits, $hex, 0x3912);
        $hex = $this->writeObject($this->debriefNumWarheadFired, $hex, 0x391E);
        $hex = $this->writeObject($this->debriefNumCraftLosses, $hex, 0x392A);
        $hex = $this->writeObject($this->debriefCraftLossesFromCollision, $hex, 0x3936);
        $hex = $this->writeObject($this->debriefCraftLossesFromStarship, $hex, 0x3942);
        $hex = $this->writeObject($this->debriefCraftLossesFromMine, $hex, 0x394E);
        $hex = $this->writeObject($this->debriefLossesFromPlayerRank, $hex, 0x395A);
        $hex = $this->writeObject($this->debriefLossesFromAIRank, $hex, 0x3A86);
        $offset = 0x3ACE;
        for ($i = 0; $i < 8; $i++) {
            $t = $this->connectedPlayerData[$i];
            $hex = $this->writeObject($t, $hex, $offset);
            $offset += $t->getLength();
        }
        $offset = 0x3D8E;
        for ($i = 0; $i < 10; $i++) {
            $t = $this->debriefTeamResult[$i];
            $hex = $this->writeObject($t, $hex, $offset);
            $offset += $t->getLength();
        }
        $hex = $this->writeInt($this->lastSelectedFaction, $hex, 0x3EA6);
        $hex = $this->writeObject($this->rebelSingleplayerData, $hex, 0x3EAA);
        $hex = $this->writeObject($this->imperialSingleplayerData, $hex, 0x126CE);
        $hex = $this->writeObject($this->rebelMultiplayerData, $hex, 0x20EF2);
        $hex = $this->writeObject($this->imperialMultiplayerData, $hex, 0x2F716);

        return $hex;
    }
    
    
    public function getLength(): int
    {
        return self::PLTFILERECORDLENGTH;
    }
}