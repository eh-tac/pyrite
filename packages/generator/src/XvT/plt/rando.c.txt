#pragma once
#ifndef FRONT_PILOT_H
#define FRONT_PILOT_H

#define WIN32_LEAN_AND_MEAN
#include <windows.h>
#include <dplay.h>
#include <stdio.h>

enum PlayerRanks
{
	RANK_TARGETDRONE = 0x0,
	RANK_GROUNDCREW = 0x1,
	RANK_TRAINEE = 0x2,
	RANK_FLIGHTCADET = 0x3,
	RANK_OFFICER4 = 0x4,
	RANK_OFFICER3 = 0x5,
	RANK_OFFICER2 = 0x6,
	RANK_OFFICER1 = 0x7,
	RANK_VETERAN4 = 0x8,
	RANK_VETERAN3 = 0x9,
	RANK_VETERAN2 = 0xA,
	RANK_VETERAN1 = 0xB,
	RANK_ACE4 = 0xC,
	RANK_ACE3 = 0xD,
	RANK_ACE2 = 0xE,
	RANK_ACE1 = 0xF,
	RANK_TOPACE4 = 0x10,
	RANK_TOPACE3 = 0x11,
	RANK_TOPACE2 = 0x12,
	RANK_TOPACE1 = 0x13,
	RANK_JEDI4 = 0x14,
	RANK_JEDI3 = 0x15,
	RANK_JEDI2 = 0x16,
	RANK_JEDI1 = 0x17,
	RANK_JEDIMASTER = 0x18,
};


enum MissionPerformance
{
	AWARD_PERFORMANCE_NONE = 0x0,
	AWARD_PERFORMANCE_TOP = 0x1,
	AWARD_PERFORMANCE_EXCELLENT = 0x2,
	AWARD_PERFORMANCE_GOOD = 0x3,
	AWARD_PERFORMANCE_FAIR = 0x4,
	AWARD_PERFORMANCE_ADEQUATE = 0x5,
	AWARD_PERFORMANCE_REPRIMAND = 0x6,
	AWARD_MEDAL_NONE = 0x0,
	AWARD_MEDAL_GOLD = 0x1,
	AWARD_MEDAL_SILVER = 0x2,
	AWARD_MEDAL_BRONZE = 0x3,
	AWARD_MEDAL_NICKEL = 0x4,
	AWARD_MEDAL_COPPER = 0x5,
	AWARD_MEDAL_LEAD = 0x6,
};

enum BattleOutcome
{
	BATTLE_IMPERIAL_VICTORY = 0x0,
	BATTLE_REBEL_VICTORY = 0x1,
	BATTLE_DRAW = 0x2,
};

enum PilotSelectedFaction
{
	PILOTFACTION_REBEL = 0x0,
	PILOTFACTION_IMPERIAL = 0x1,
	PILOTFACTION_MULTIPLAYER = 0x2,
};


struct PLTTournTeamRecord
{
	int teamParticipationState;
	int totalTeamScore;
	int numberOfMeleeRankingsFirst;
	int numberOfMeleeRankingsSecond;
	int numberOfMeleeRankingsThird;
};

#pragma pack(push, 1)
struct PLTConnectedPlayerData
{
	char pilotLongNameUnused[14];
	char pilotShortName[14];
	int fgIndex;
	DPID DPPlayerID;
	int pilotRank;
	int playerScore;
	int fullKills;
	int sharedKills;
	int unusedInspections;
	int assistKills;
	int losses;
	int craftType;
	int optionalCraftIndex;
	int optionalWarhead;
	int optionalBeam;
	int optionalCountermeasure;
	int hasDisconnectedFromHostUNK;
};
#pragma pack(pop)

#pragma pack(push, 1)
struct PLTTeamResultRecord
{
	int totalMissionScore;
	int isMissionComplete;
	int unknown0x8;
	int timeMissionComplete;
	int fullKills;
	int sharedKills;
	int losses;
};
#pragma pack(pop)


#pragma pack(push, 1)
struct PLTMissionSPRecord
{
	int unknown0x0;
	int totalCountFlown;
	int totalCountVictory;
	int totalCountFailure;
	int bestScore;
	int bestTimeAsSeconds;
	int bestFinishRank;
	int bestEvaluationBadge;
	int bestWinningMargin;
};
#pragma pack(pop)


#pragma pack(push, 1)
struct PLTMissionMPRecord
{
	int unknown0x0;
	int totalCountFlown;
	int totalCountFinishedFirst;
	int totalCountFinishedSecond;
	int totalCountFinishedThird;
	int totalCountVictory;
	int totalCountFailure;
	int bestScore;
	int bestTimeAsSeconds;
	int bestFinishPlace;
	int bestEvaluationBadge;
	int bestWinningMargin;
};
#pragma pack(pop)


#pragma pack(push, 1)
struct PLTTournSPRecord
{
	int unknown0x0;
	int totalCountFlown;
	int numberOfFinishesAnyUNK;
	int numberOfFinishesFirst;
	int numberOfFinishesSecond;
	int numberOfFinishesThird;
	int bestScore;
	int bestFinish;
	int bestEvaluationMedal;
	int bestFinishPointMargin;
};
#pragma pack(pop)


#pragma pack(push, 1)
struct PLTTournMPRecord
{
	int unknown0x0;
	int totalCountFlown;
	int numberOfFinishesAnyUNK;
	int numberOfFinishesFirst;
	int numberOfFinishesSecond;
	int numberOfFinishesThird;
	int bestScore;
	int bestFinish;
	int unknown0x20;
	int bestEvaluationMedal;
	int bestFinishPointMargin;
};
#pragma pack(pop)


#pragma pack(push, 1)
struct PLTBattleSPRecord
{
	int unknown0x0;
	int totalCountFlown;
	int totalCountVictory;
	int totalCountFailure;
	int totalCount10MissionMarathonUNK;
	int bestScore;
	int unknown0x18;
	int bestEvaluationMedal;
	int bestVictoryMargin;
};
#pragma pack(pop)


#pragma pack(push, 1)
struct PLTBattleMPRecord
{
	int unknown0x0;
	int totalCountFlown;
	int totalCountVictory;
	int totalCountFailure;
	int totalCount10MissionMarathonUNK;
	int bestScore;
	int unknown0x18;
	int unknown0x1C;
	int bestEvaluationMedal;
	int bestVictoryMargin;
};
#pragma pack(pop)


#pragma pack(push, 1)
struct PLTEarnedMedalRecord
{
	int meleePlaqueCount[6];
	int tournamentPlaqueCount[6];
	int exerciseBadgeCount[6];
	int battleMedalCount[6];
};
#pragma pack(pop)


#pragma pack(push, 1)
struct PLTCategoryTypeRecord
{
	int exercise;
	int melee;
	int combat;
};
#pragma pack(pop)


#pragma pack(push, 1)
struct PLTPlayerRankCountRecord
{
	int exercise[25];
	int melee[25];
	int combat[25];
};
#pragma pack(pop)


#pragma pack(push, 1)
struct PLTAIRankCountRecord
{
	int exercise[6];
	int melee[6];
	int combat[6];
};
#pragma pack(pop)


struct PLTFactionRecord
{
	int totalMissionsFlown;
	int lastMissionTeam;
	int lastMissionType;
	int lastMissionTrainingSelected;
	int lastMissionMeleeSelected;
	int lastMissionTournamentSelected;
	int lastMissionCombatSelected;
	int lastMissionBattleSelected;
	int unknown0x20[10];
	PLTEarnedMedalRecord earnedMedalCount;
	int debriefMeleePlaqueType;
	int debriefTournamentTrophyType;
	int debriefMissionBadgeType;
	int debriefBattleMedalType;
	int UnknownRecord4[4];
	int totalFactionScore;
	PLTCategoryTypeRecord totalCategoryScore;
	PLTCategoryTypeRecord totalCategoryFlown;
	int totalCampaignExerciseFlown;
	int totalTournamentMeleeFlown;
	int totalBattleCombatFlown;
	PLTCategoryTypeRecord totalFullKills;
	PLTCategoryTypeRecord totalFriendlyFullKills;
	int totalFullKillsByShipExercise[88];
	int totalFullKillsByShipMelee[88];
	int totalFullKillsByShipCombat[88];
	int totalSharedKillsOfShipExercise[88];
	int totalSharedKillsOfShipMelee[88];
	int totalSharedKillsOfShipCombat[88];
	int totalAssistKillsOfShipExercise[88];
	int totalAssistKillsOfShipMelee[88];
	int totalAssistKillsOfShipCombat[88];
	PLTPlayerRankCountRecord totalFullKillsOfPlayerRank;
	PLTPlayerRankCountRecord totalSharedKillsOfPlayerRank;
	PLTPlayerRankCountRecord totalAssistKillsOfPlayerRank;
	PLTAIRankCountRecord totalFullKillsOfAIRank;
	PLTAIRankCountRecord totalSharedKillsOfAIRank;
	PLTAIRankCountRecord totalAssistKillsOfAIRank;
	PLTCategoryTypeRecord totalHiddenCargoFound;
	PLTCategoryTypeRecord totalCannonHit;
	PLTCategoryTypeRecord totalCannonFired;
	PLTCategoryTypeRecord totalWarheadHit;
	PLTCategoryTypeRecord totalWarheadFired;
	PLTCategoryTypeRecord totalLosses;
	PLTCategoryTypeRecord totalLossesByCollision;
	PLTCategoryTypeRecord totalLossesByStarship;
	PLTCategoryTypeRecord totalLossesByMines;
	PLTPlayerRankCountRecord totalLossesByPlayerRank;
	PLTAIRankCountRecord totalLossesByAIRank;
	PLTMissionSPRecord missionSPExercise[100];
	PLTMissionSPRecord missionSPMelee[250];
	PLTMissionSPRecord missionSPCombat[250];
	PLTMissionMPRecord missionMPExercise[100];
	PLTMissionMPRecord missionMPMelee[250];
	PLTMissionMPRecord missionMPCombat[250];
	PLTTournSPRecord missionSPTourn[25];
	PLTTournMPRecord missionMPTourn[25];
	PLTBattleSPRecord missionSPBattle[25];
	PLTBattleMPRecord missionMPBattle[25];
};


#pragma pack(push, 1)
struct PLTFileRecord
{
	char PilotName[14];
	int TotalScore;
	DPID PlayerID;
	int continuedOrReflownMission;
	int isHosting;
	int numHumanPlayersInMission;
	int frontFlyMode;
	int unknown0x26[80];
	int unknown0x166[8];
	int unknown0x186[80];
	int lastTeamNumber;
	int lastSelectedMissionType;
	int lastSelectedTraining;
	int lastSelectedMelee;
	int lastSelectedTournament;
	int lastSelectedCombat;
	int lastSelectedBattle;
	char GameNameString[22];
	BYTE unknown0x2F8[10];
	char GameNameString2[22];
	BYTE unknown0x318[10];
	int lastMissionWasNonSpecific;
	int unknown0x326;
	int PromoPoints;
	int WorsePromoPoints;
	int RankAdjustmentApplied;
	int PercentToNextRank;
	PLTCategoryTypeRecord totalCategoryScore;
	PLTCategoryTypeRecord numFlownNonSeries;
	PLTCategoryTypeRecord numFlownSeries;
	PLTCategoryTypeRecord totalKillCount;
	PLTCategoryTypeRecord numVanillaFriendlyKills;
	int totalCraftFullKillsExercise[88];
	int totalCraftFullKillsMelee[88];
	int totalCraftFullKillsCombat[88];
	int totalCraftSharedKillsExercise[88];
	int totalCraftSharedKillsMelee[88];
	int totalCraftSharedKillsCombat[88];
	int totalCraftAssistKillsExercise[88];
	int totalCraftAssistKillsMelee[88];
	int totalCraftAssistKillsCombat[88];
	PLTPlayerRankCountRecord TotalFullKillsOnPlayerRank;
	PLTPlayerRankCountRecord TotalSharedKillsOnPlayerRank;
	PLTPlayerRankCountRecord TotalAssistKillsOnPlayerRank;
	PLTAIRankCountRecord TotalFullKillsOnAIRank;
	PLTAIRankCountRecord TotalSharedKillsOnAIRank;
	PLTAIRankCountRecord TotalAssistKillsOnAIRank;
	PLTCategoryTypeRecord totalHiddenCargoFound;
	PLTCategoryTypeRecord totalLaserHit;
	int totalLaserFiredExercise;
	int totalLaserFiredMelee;
	int totalLaserFiredCombat;
	int totalWarheadHitExercise;
	int totalWarheadHitMelee;
	int totalWarheadHitCombat;
	int totalWarheadFiredExercise;
	int totalWarheadFiredMelee;
	int totalWarheadFiredCombat;
	int totalCraftLossesExercise;
	int totalCraftLossesMelee;
	int totalCraftLossesCombat;
	int totalLossesFromCollisionExercise;
	int totalLossesFromCollisionMelee;
	int totalLossesFromCollisionCombat;
	int totalLossesFromStarshipsExercise;
	int totalLossesFromStarshipsMelee;
	int totalLossesFromStarshipsCombat;
	int totalLossesFromMinesExercise;
	int totalLossesFromMinesMelee;
	int totalLossesFromMinesCombat;
	PLTPlayerRankCountRecord TotalLossesFromPlayerRank;
	PLTAIRankCountRecord TotalLossesFromAIRank;
	BYTE unknown0x1612[40];
	int unknownPlaqueWon;
	PLTTournTeamRecord TournTeamRecords[10];
	int numHumanPlayersUNK;
	int numTeamsUNK;
	int unknown0x170E;
	int unknown0x1712;
	int numCombatFlownInLastBattle;
	BYTE unknown0x171A[2052];
	int battleCombatMissionID[4];
	BYTE unknown0x1F2E[1012];
	int totalScoreForCurrentBattleUNK;
	unsigned int CurrentRank;
	int TotalCountMissionsFlown;
	int RankAchievedOnMissionCount[25];
	char RankString[32];
	int debriefMissionScore;
	int debriefFullKillsOnPlayer[8];
	int debriefSharedKillsOnPlayer[8];
	int debriefFullKillsOnFG[48];
	int debriefSharedKillsOnFG[48];
	int debriefFullKillsByPlayer[8];
	int debriefSharedKillsByPlayer[8];
	int debriefFullKillsByFG[48];
	int debriefSharedKillsByFG[48];
	int debriefMeleeAIRankFG[48];
	PLTCategoryTypeRecord UnknownRecord1;
	PLTCategoryTypeRecord UnknownRecord2;
	PLTCategoryTypeRecord UnknownRecord3;
	PLTCategoryTypeRecord debriefEnemyKills;
	PLTCategoryTypeRecord debriefFriendlyKills;
	int debriefFullKillsByShipTypeA[88];
	int debriefFullKillsByShipTypeB[88];
	int debriefFullKillsByShipTypeC[88];
	int debriefSharedKillsByShipTypeA[88];
	int debriefSharedKillsByShipTypeB[88];
	int debriefSharedKillsByShipTypeC[88];
	int debriefAssistKillsByShipTypeA[88];
	int debriefAssistKillsByShipTypeB[88];
	int debriefAssistKillsByShipTypeC[88];
	PLTPlayerRankCountRecord debriefFullKillsOnPlayerRank;
	PLTPlayerRankCountRecord debriefSharedKillsOnPlayerRank;
	PLTPlayerRankCountRecord debriefAssistKillsOnPlayerRank;
	PLTAIRankCountRecord debriefFullKillsOnAIRank;
	PLTAIRankCountRecord debriefSharedKillsOnAIRank;
	PLTAIRankCountRecord debriefAssistKillsOnAIRank;
	PLTCategoryTypeRecord debriefNumHiddenCargoFound;
	PLTCategoryTypeRecord debriefNumCannonHits;
	PLTCategoryTypeRecord debriefNumCannonFired;
	PLTCategoryTypeRecord debriefNumWarheadHits;
	PLTCategoryTypeRecord debriefNumWarheadFired;
	PLTCategoryTypeRecord debriefNumCraftLosses;
	PLTCategoryTypeRecord debriefCraftLossesFromCollision;
	PLTCategoryTypeRecord debriefCraftLossesFromStarship;
	PLTCategoryTypeRecord debriefCraftLossesFromMine;
	PLTPlayerRankCountRecord debriefLossesFromPlayerRank;
	PLTAIRankCountRecord debriefLossesFromAIRank;
	PLTConnectedPlayerData connectedPlayerData[8];
	PLTTeamResultRecord debriefTeamResult[10];
	int lastSelectedFaction;
	PLTFactionRecord rebelSingleplayerData;
	PLTFactionRecord imperialSingleplayerData;
	PLTFactionRecord rebelMultiplayerData;
	PLTFactionRecord imperialMultiplayerData;
};
#pragma pack(pop)


#pragma pack(push, 1)
struct PL2CampaignStatusSPRecord
{
	int unknown0x0;
	int isStartedUNK;
	int missionNumber;
	int isFinished;
	int bestScore;
	int unknown0x14;
	int unknown0x18;
	int unknown0x1C;
	int unknown0x20;
};
#pragma pack(pop)


#pragma pack(push, 1)
struct PL2CampaignRecord
{
	int IDNumber;
	int totalCountFlown;
	int isMissionCompleteWithoutCheat;
	int bestScore;
	int bestEvaluationBadge;
	int bestTimeAsSeconds;
	int isMissionComplete;
	int UIFrameTimerHelper;
};
#pragma pack(pop)


struct PL2FactionRecord
{
	int totalMissionsFlown;
	int lastKnownTeam;
	int lastKnownFolderIndex;
	int selectedMissionIDNum[6];
	int unknown0x24[8];
	int isMissionCategorySeries;
	int activeMissionIDNum;
	PLTEarnedMedalRecord earnedMedalCount;
	int debriefMedalTypeMTEB[4];
	int UnknownRecord4[4];
	int totalFactionScore;
	int totalScoreEMC[3];
	int totalFlownNonSeriesEMC[3];
	int totalFlownSeriesEMC[3];
	int totalFullKillsEMC[3];
	int totalFriendlyFullKillsEMC[3];
	int totalFullKillsOnCraftEMC[300];
	int totalSharedKillsOnCraftEMC[300];
	int totalAssistKillsOnCraftEMC[300];
	PLTPlayerRankCountRecord totalFullKillsOfPlayerRank;
	PLTPlayerRankCountRecord totalSharedKillsOfPlayerRank;
	PLTPlayerRankCountRecord totalAssistKillsOfPlayerRank;
	PLTAIRankCountRecord totalFullKillsOfAIRank;
	PLTAIRankCountRecord totalSharedKillsOfAIRank;
	PLTAIRankCountRecord totalAssistKillsOfAIRank;
	int totalHiddenCargoFoundEMC[3];
	int totalCannonHitEMC[3];
	int totalCannonFiredEMC[3];
	int totalWarheadHitEMC[3];
	int totalWarheadFiredEMC[3];
	int totalLossesEMC[3];
	int totalLossesByCollisionEMC[3];
	int totalLossesByStarshipEMC[3];
	int totalLossesByMinesEMC[3];
	PLTPlayerRankCountRecord totalLossesByPlayerRank;
	PLTAIRankCountRecord totalLossesByAIRank;
	PLTMissionSPRecord missionSPExercise[100];
	PLTMissionSPRecord missionSPMelee[250];
	PLTMissionSPRecord missionSPCombat[250];
	PLTMissionMPRecord missionMPExercise[100];
	PLTMissionMPRecord missionMPMelee[250];
	PLTMissionMPRecord missionMPCombat[250];
	PLTTournSPRecord missionSPTourn[25];
	PLTTournMPRecord missionMPTourn[25];
	PLTBattleSPRecord missionSPBattle[25];
	PLTBattleMPRecord missionMPBattle[25];
	PL2CampaignStatusSPRecord statusSPCampaign[25];
	PL2CampaignStatusSPRecord statusMPCampaignUNK[25];
	PL2CampaignRecord missionSPCampaign[100];
	PL2CampaignRecord missionMPCampaign[100];
};


struct PLTTournamentProgressState
{
	char unknown1[36];
	int completedMissionCount;
	int totalMissionCount;
	PLTTournTeamRecord teamRecord[10];
	int playersActive;
	int teamsActive;
	int unknown2;
};


struct PLTBattleProgressState
{
	int MissionsFlown;
	int CombatMissionID;
	int TotalMissionCount;
	int Outcome[10];
	int BattleListIndex[10];
	int CombatMissionListIndex[10];
	int NumPlayers;
	int TotalScore;
};


#pragma pack(push, 1)
struct PL2DebriefRecord
{
	PLTCategoryTypeRecord UnknownRecord1;
	PLTCategoryTypeRecord UnknownRecord2;
	PLTCategoryTypeRecord UnknownRecord3;
	int enemyKillsEXX[3];
	int friendlyKillsEXX[3];
	int TotalKillCountByCraftType[900];
	PLTPlayerRankCountRecord FullKillsOnPlayerRank;
	PLTPlayerRankCountRecord SharedKillsOnPlayerRank;
	PLTPlayerRankCountRecord AssistKillsOnPlayerRank;
	PLTAIRankCountRecord FullKillsOnAIRank;
	PLTAIRankCountRecord SharedKillsOnAIRank;
	PLTAIRankCountRecord AssistKillsOnAIRank;
	int NumHiddenCargoFoundEXX[3];
	int NumCannonHitsEXX[3];
	int NumCannonFiredEXX[3];
	int NumWarheadHitsEXX[3];
	int NumWarheadFiredEXX[3];
	int NumCraftLossesEXX[3];
	int CraftLossesFromCollisionEXX[3];
	int CraftLossesFromStarshipEXX[3];
	int CraftLossesFromMineEXX[3];
	PLTPlayerRankCountRecord LossesFromPlayerRank;
	PLTAIRankCountRecord LossesFromAIRank;
};
#pragma pack(pop)


struct PL2CampaignProgressState
{
	int unknown1;
	int CurrentMissionNumber;
	int TotalMissionCount;
	int CurrentMissionComplete;
	int PlayerCount;
	int TotalScore;
};


struct PLTBattleState
{
	int ConfigRandomSeed;
	int IsInProgressUNK;
	int ConfigBattleLength;
	int ConfigGameRandomizeLevel;
	PLTBattleProgressState saveState;
	int unknown2;
};


#pragma pack(push, 1)
struct PL2CampaignState
{
	int ConfigRandomSeed;
	int IsInProgressUNK;
	int ConfigGameRandomizeLevel;
	PL2CampaignProgressState saveState;
	int unknown2;
};
#pragma pack(pop)

#pragma pack(push, 1)
struct PL2FileRecord
{
	char PilotName[14];
	int TotalScore;
	DPID PlayerID;
	int continuedOrReflownMission;
	int isHosting;
	int numHumanPlayersInMission;
	int frontFlyMode;
	int unknown0x26[80];
	int unknown0x166[8];
	int unknown0x186[80];
	int activeMissionTeam;
	int MissionFolderIndex;
	int SelectedIDNumOfMissionCategory[6];
	char GameName[32];
	char LastGameName[32];
	int isMissionCategorySeries;
	int activeMissionIDNum;
	int PromoPoints;
	int WorsePromoPoints;
	int RankAdjustmentApplied;
	int PercentToNextRank;
	int totalScoreEMC[3];
	int numFlownNonSeriesEMC[3];
	int numFlownSeriesEMC[3];
	int totalKillCountEMC[3];
	int totalFriendlyKillCountEMC[3];
	int TotalKillCountByCraftType[900];
	PLTPlayerRankCountRecord TotalFullKillsOnPlayerRank;
	PLTPlayerRankCountRecord TotalSharedKillsOnPlayerRank;
	PLTPlayerRankCountRecord TotalAssistKillsOnPlayerRank;
	PLTAIRankCountRecord TotalFullKillsOnAIRank;
	PLTAIRankCountRecord TotalSharedKillsOnAIRank;
	PLTAIRankCountRecord TotalAssistKillsOnAIRank;
	int TotalHiddenCargoFoundEMC[3];
	int TotalLaserHitEMC[3];
	int TotalLaserFiredEMC[3];
	int TotalWarheadHitEMC[3];
	int TotalWarheadFiredEMC[3];
	int TotalCraftLossesEMC[3];
	int TotalLossesFromCollisionEMC[3];
	int TotalLossesFromStarshipsEMC[3];
	int TotalLossesFromMinesEMC[3];
	PLTPlayerRankCountRecord TotalLossesFromPlayerRank;
	PLTAIRankCountRecord TotalLossesFromAIRank;
	PLTTournamentProgressState activeTournament;
	PLTBattleProgressState activeBattle;
	unsigned int CurrentRank;
	int TotalCountMissionsFlown;
	int RankAchievedOnMissionCount[25];
	char RankString[32];
	int debriefMissionScore;
	int debriefFullKillsOnPlayer[8];
	int debriefSharedKillsOnPlayer[8];
	int debriefFullKillsOnFG[48];
	int debriefSharedKillsOnFG[48];
	int debriefFullKillsByPlayer[8];
	int debriefSharedKillsByPlayer[8];
	int debriefFullKillsByFG[48];
	int debriefSharedKillsByFG[48];
	int debriefMeleeAIRankFG[48];
	PL2DebriefRecord debrief;
	PLTConnectedPlayerData connectedPlayerData[8];
	PLTTeamResultRecord debriefTeamResult[10];
	DWORD SelectedFaction;
	PL2FactionRecord faction[4];
	PL2CampaignProgressState activeCampaign;
	__int8 gap45E1E[4];
	PLTBattleState spBattleState[25];
	PLTBattleState mpBattleState[25];
	PL2CampaignState spCampaignState[25];
	PL2CampaignState mpCampaignHostState[12];
	PL2CampaignState mpCampaignClientState[12];
	int anonymous_259[8];
	WORD anonymous_260;
	WORD anonymous_261;
};
#pragma pack(pop)


enum MissionPerformanceCount
{
	AWARDCOUNT_PERFORMANCE_TOP = 0x0,
	AWARDCOUNT_PERFORMANCE_EXCELLENT = 0x1,
	AWARDCOUNT_PERFORMANCE_GOOD = 0x2,
	AWARDCOUNT_PERFORMANCE_FAIR = 0x3,
	AWARDCOUNT_PERFORMANCE_ADEQUATE = 0x4,
	AWARDCOUNT_PERFORMANCE_REPRIMAND = 0x5,
	AWARDCOUNT_MEDAL_GOLD = 0x0,
	AWARDCOUNT_MEDAL_SILVER = 0x1,
	AWARDCOUNT_MEDAL_BRONZE = 0x2,
	AWARDCOUNT_MEDAL_NICKEL = 0x3,
	AWARDCOUNT_MEDAL_COPPER = 0x4,
	AWARDCOUNT_MEDAL_LEAD = 0x5,
};

extern PL2FileRecord g_PilotData;

int __cdecl SavePilotFiles(int bUseTempFile); // idb
int __cdecl SavePilotPLT(char *fileName); // idb
int __cdecl UpgradePLTIntoPL2(FILE *pltFileHandle); // idb
signed int DeletePilot();
signed int __cdecl CreateNewPilot(const char *pilotName); // idb
signed int __cdecl LoadPLTList(int *out_loadedPltIndex); // idb
signed int CondenseConnectedPilotInfoTable();
signed int SavePilotAndConfig();

extern char STR_TRIPLE_DASH[];

extern int PromoPointRankTable[32];
extern PlayerRanks MapAIRankToPlayerRank[7];
extern int CombatMPRewardPointThresholdTable[6];
extern int ExerciseRewardPointThresholdTable[3];
extern unsigned __int8 MultiplayerMeleeMedalRewardTable[32];

#endif //FRONT_PILOT_H