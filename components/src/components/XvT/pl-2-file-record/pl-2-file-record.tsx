import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { PL2FileRecord } from "../../../model/XvT";
import { XvTPL2FileRecordController } from "../../../controllers/XvT";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-xvt-pl-2-file-record",
  styleUrl: "pl-2-file-record.scss",
  shadow: false
})
export class XvTPL2FileRecordComponent {
  @Element() public el: HTMLElement;
  @Prop() public pl2filerecord: PL2FileRecord;

  private controller: XvTPL2FileRecordController;

  public componentWillLoad(): void {
    this.controller = new XvTPL2FileRecordController(this.pl2filerecord);
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
        <Field {...this.controller.getProps('activeMissionTeam')} />
        <Field {...this.controller.getProps('MissionFolderIndex')} />
        <Field {...this.controller.getProps('SelectedIDNumOfMissionCategory')} />
        <Field {...this.controller.getProps('GameName')} />
        <Field {...this.controller.getProps('LastGameName')} />
        <Field {...this.controller.getProps('isMissionCategorySeries')} />
        <Field {...this.controller.getProps('activeMissionIDNum')} />
        <Field {...this.controller.getProps('PromoPoints')} />
        <Field {...this.controller.getProps('WorsePromoPoints')} />
        <Field {...this.controller.getProps('RankAdjustmentApplied')} />
        <Field {...this.controller.getProps('PercentToNextRank')} />
        <Field {...this.controller.getProps('numFlownNonSeries')} />
        <Field {...this.controller.getProps('numFlownSeries')} />
        <Field {...this.controller.getProps('totalKillCount')} />
        <Field {...this.controller.getProps('totalFriendlyKillCount')} />
        <Field {...this.controller.getProps('totalKillCountByCraftType')} />
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
        <Field {...this.controller.getProps('activeTournament')} />
        <Field {...this.controller.getProps('activeBattle')} />
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
        <Field {...this.controller.getProps('debrief')} />
        <Field {...this.controller.getProps('connectedPlayerData')} />
        <Field {...this.controller.getProps('debriefTeamResult')} />
        <Field {...this.controller.getProps('SelectedFaction')} />
        <Field {...this.controller.getProps('faction')} />
        <Field {...this.controller.getProps('activeCampaign')} />
        <Field {...this.controller.getProps('gap45E1E')} />
        <Field {...this.controller.getProps('spBattleState')} />
        <Field {...this.controller.getProps('mpBattleState')} />
        <Field {...this.controller.getProps('spCampaignState')} />
        <Field {...this.controller.getProps('mpCampaignHostState')} />
        <Field {...this.controller.getProps('mpCampaignClientState')} />
        <Field {...this.controller.getProps('anonymous_259')} />
        <Field {...this.controller.getProps('anonymous_260')} />
        <Field {...this.controller.getProps('anonymous_261')} />
      </Host>
    )
  }
}
  