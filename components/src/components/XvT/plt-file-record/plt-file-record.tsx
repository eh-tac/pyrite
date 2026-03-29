import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { PLTFileRecord } from "../../../model/XvT";
import { XvTPLTFileRecordController } from "../../../controllers/XvT";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-xvt-plt-file-record",
  styleUrl: "plt-file-record.scss",
  shadow: false
})
export class XvTPLTFileRecordComponent {
  @Element() public el: HTMLElement;
  @Prop() public pltfilerecord: PLTFileRecord;

  private controller: XvTPLTFileRecordController;

  public componentWillLoad(): void {
    this.controller = new XvTPLTFileRecordController(this.pltfilerecord);
  }

  public render(): JSX.Element {
    return (
      <Host>
        <Field {...this.controller.getProps('PilotName')} />
        <Field {...this.controller.getProps('totalScore')} />
        <Field {...this.controller.getProps('PlayerID')} />
        <Field {...this.controller.getProps('continuedOrReflownMission')} />
        <Field {...this.controller.getProps('isHosting')} />
        <Field {...this.controller.getProps('numHumanPlayersInMission')} />
        <Field {...this.controller.getProps('frontFlyMode')} />
        <Field {...this.controller.getProps('unknown0x26')} />
        <Field {...this.controller.getProps('unknown0x166')} />
        <Field {...this.controller.getProps('unknown0x186')} />
        <Field {...this.controller.getProps('lastTeamNumber')} />
        <Field {...this.controller.getProps('lastSelectedMissionType')} />
        <Field {...this.controller.getProps('lastSelectedTraining')} />
        <Field {...this.controller.getProps('lastSelectedMelee')} />
        <Field {...this.controller.getProps('lastSelectedTournament')} />
        <Field {...this.controller.getProps('lastSelectedCombat')} />
        <Field {...this.controller.getProps('lastSelectedBattle')} />
        <Field {...this.controller.getProps('GameNameString')} />
        <Field {...this.controller.getProps('unknown0x2F8')} />
        <Field {...this.controller.getProps('GameNameString2')} />
        <Field {...this.controller.getProps('unknown0x318')} />
        <Field {...this.controller.getProps('lastMissionWasNonSpecific')} />
        <Field {...this.controller.getProps('unknown0x326')} />
        <Field {...this.controller.getProps('PromoPoints')} />
        <Field {...this.controller.getProps('WorsePromoPoints')} />
        <Field {...this.controller.getProps('RankAdjustmentApplied')} />
        <Field {...this.controller.getProps('PercentToNextRank')} />
        <Field {...this.controller.getProps('totalCategoryScore')} />
        <Field {...this.controller.getProps('numFlownNonSeries')} />
        <Field {...this.controller.getProps('numFlownSeries')} />
        <Field {...this.controller.getProps('totalKillCount')} />
        <Field {...this.controller.getProps('numVanillaFriendlyKills')} />
        <Field {...this.controller.getProps('totalCraftFullKillsExercise')} />
        <Field {...this.controller.getProps('totalCraftFullKillsMelee')} />
        <Field {...this.controller.getProps('totalCraftFullKillsCombat')} />
        <Field {...this.controller.getProps('totalCraftSharedKillsExercise')} />
        <Field {...this.controller.getProps('totalCraftSharedKillsMelee')} />
        <Field {...this.controller.getProps('totalCraftSharedKillsCombat')} />
        <Field {...this.controller.getProps('totalCraftAssistKillsExercise')} />
        <Field {...this.controller.getProps('totalCraftAssistKillsMelee')} />
        <Field {...this.controller.getProps('totalCraftAssistKillsCombat')} />
        <Field {...this.controller.getProps('totalFullKillsOnPlayerRank')} />
        <Field {...this.controller.getProps('totalSharedKillsOnPlayerRank')} />
        <Field {...this.controller.getProps('totalAssistKillsOnPlayerRank')} />
        <Field {...this.controller.getProps('totalFullKillsOnAIRank')} />
        <Field {...this.controller.getProps('totalSharedKillsOnAIRank')} />
        <Field {...this.controller.getProps('totalAssistKillsOnAIRank')} />
        <Field {...this.controller.getProps('totalHiddenCargoFound')} />
        <Field {...this.controller.getProps('totalLaserHit')} />
        <Field {...this.controller.getProps('totalLaserFired')} />
        <Field {...this.controller.getProps('totalWarheadHit')} />
        <Field {...this.controller.getProps('totalWarheadFired')} />
        <Field {...this.controller.getProps('totalCraftLosses')} />
        <Field {...this.controller.getProps('totalLossesFromCollision')} />
        <Field {...this.controller.getProps('totalLossesFromStarships')} />
        <Field {...this.controller.getProps('totalLossesFromMines')} />
        <Field {...this.controller.getProps('totalLossesFromPlayerRank')} />
        <Field {...this.controller.getProps('totalLossesFromAIRank')} />
        <Field {...this.controller.getProps('unknown0x1612')} />
        <Field {...this.controller.getProps('unknownPlaqueWon')} />
        <Field {...this.controller.getProps('TournTeamRecords')} />
        <Field {...this.controller.getProps('numHumanPlayersUNK')} />
        <Field {...this.controller.getProps('numTeamsUNK')} />
        <Field {...this.controller.getProps('unknown0x170E')} />
        <Field {...this.controller.getProps('unknown0x1712')} />
        <Field {...this.controller.getProps('numCombatFlownInLastBattle')} />
        <Field {...this.controller.getProps('unknown0x171A')} />
        <Field {...this.controller.getProps('battleCombatMissionID')} />
        <Field {...this.controller.getProps('unknown0x1F2E')} />
        <Field {...this.controller.getProps('totalScoreForCurrentBattleUNK')} />
        <Field {...this.controller.getProps('CurrentRank')} />
        <Field {...this.controller.getProps('totalCountMissionsFlown')} />
        <Field {...this.controller.getProps('RankAchievedOnMissionCount')} />
        <Field {...this.controller.getProps('RankString')} />
        <Field {...this.controller.getProps('debriefMissionScore')} />
        <Field {...this.controller.getProps('debriefFullKillsOnPlayer')} />
        <Field {...this.controller.getProps('debriefSharedKillsOnPlayer')} />
        <Field {...this.controller.getProps('debriefFullKillsOnFG')} />
        <Field {...this.controller.getProps('debriefSharedKillsOnFG')} />
        <Field {...this.controller.getProps('debriefFullKillsByPlayer')} />
        <Field {...this.controller.getProps('debriefSharedKillsByPlayer')} />
        <Field {...this.controller.getProps('debriefFullKillsByFG')} />
        <Field {...this.controller.getProps('debriefSharedKillsByFG')} />
        <Field {...this.controller.getProps('debriefMeleeAIRankFG')} />
        <Field {...this.controller.getProps('UnknownRecord1')} />
        <Field {...this.controller.getProps('UnknownRecord2')} />
        <Field {...this.controller.getProps('UnknownRecord3')} />
        <Field {...this.controller.getProps('debriefEnemyKills')} />
        <Field {...this.controller.getProps('debriefFriendlyKills')} />
        <Field {...this.controller.getProps('debriefFullKillsByShipTypeA')} />
        <Field {...this.controller.getProps('debriefFullKillsByShipTypeB')} />
        <Field {...this.controller.getProps('debriefFullKillsByShipTypeC')} />
        <Field {...this.controller.getProps('debriefSharedKillsByShipTypeA')} />
        <Field {...this.controller.getProps('debriefSharedKillsByShipTypeB')} />
        <Field {...this.controller.getProps('debriefSharedKillsByShipTypeC')} />
        <Field {...this.controller.getProps('debriefAssistKillsByShipTypeA')} />
        <Field {...this.controller.getProps('debriefAssistKillsByShipTypeB')} />
        <Field {...this.controller.getProps('debriefAssistKillsByShipTypeC')} />
        <Field {...this.controller.getProps('debriefFullKillsOnPlayerRank')} />
        <Field {...this.controller.getProps('debriefSharedKillsOnPlayerRank')} />
        <Field {...this.controller.getProps('debriefAssistKillsOnPlayerRank')} />
        <Field {...this.controller.getProps('debriefFullKillsOnAIRank')} />
        <Field {...this.controller.getProps('debriefSharedKillsOnAIRank')} />
        <Field {...this.controller.getProps('debriefAssistKillsOnAIRank')} />
        <Field {...this.controller.getProps('debriefNumHiddenCargoFound')} />
        <Field {...this.controller.getProps('debriefNumCannonHits')} />
        <Field {...this.controller.getProps('debriefNumCannonFired')} />
        <Field {...this.controller.getProps('debriefNumWarheadHits')} />
        <Field {...this.controller.getProps('debriefNumWarheadFired')} />
        <Field {...this.controller.getProps('debriefNumCraftLosses')} />
        <Field {...this.controller.getProps('debriefCraftLossesFromCollision')} />
        <Field {...this.controller.getProps('debriefCraftLossesFromStarship')} />
        <Field {...this.controller.getProps('debriefCraftLossesFromMine')} />
        <Field {...this.controller.getProps('debriefLossesFromPlayerRank')} />
        <Field {...this.controller.getProps('debriefLossesFromAIRank')} />
        <Field {...this.controller.getProps('connectedPlayerData')} />
        <Field {...this.controller.getProps('debriefTeamResult')} />
        <Field {...this.controller.getProps('lastSelectedFaction')} />
        <Field {...this.controller.getProps('rebelSingleplayerData')} />
        <Field {...this.controller.getProps('imperialSingleplayerData')} />
        <Field {...this.controller.getProps('rebelMultiplayerData')} />
        <Field {...this.controller.getProps('imperialMultiplayerData')} />
      </Host>
    )
  }
}
  