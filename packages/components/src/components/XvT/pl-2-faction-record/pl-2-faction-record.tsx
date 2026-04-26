import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { PL2FactionRecord } from "../../../model/XvT";
import { XvTPL2FactionRecordController } from "../../../controllers/XvT";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-xvt-pl-2-faction-record",
  styleUrl: "pl-2-faction-record.scss",
  shadow: false
})
export class XvTPL2FactionRecordComponent {
  @Element() public el: HTMLElement;
  @Prop() public pl2factionrecord: PL2FactionRecord;

  private controller: XvTPL2FactionRecordController;

  public componentWillLoad(): void {
    this.controller = new XvTPL2FactionRecordController(this.pl2factionrecord);
  }

  public render(): JSX.Element {
    return (
      <Host>
        <Field {...this.controller.getProps('totalMissionsFlown')} />
        <Field {...this.controller.getProps('lastKnownTeam')} />
        <Field {...this.controller.getProps('lastKnownFolderIndex')} />
        <Field {...this.controller.getProps('selectedMissionIDNum')} />
        <Field {...this.controller.getProps('unknown0x24')} />
        <Field {...this.controller.getProps('isMissionCategorySeries')} />
        <Field {...this.controller.getProps('activeMissionIDNum')} />
        <Field {...this.controller.getProps('earnedMedalCount')} />
        <Field {...this.controller.getProps('debriefMedalTypeMTEB')} />
        <Field {...this.controller.getProps('UnknownRecord4')} />
        <Field {...this.controller.getProps('totalFactionScore')} />
        <Field {...this.controller.getProps('totalScore')} />
        <Field {...this.controller.getProps('totalFlownNonSeries')} />
        <Field {...this.controller.getProps('totalFlownSeries')} />
        <Field {...this.controller.getProps('totalFullKills')} />
        <Field {...this.controller.getProps('totalFriendlyFullKills')} />
        <Field {...this.controller.getProps('totalFullKillsOnCraftEMC')} />
        <Field {...this.controller.getProps('totalSharedKillsOnCraftEMC')} />
        <Field {...this.controller.getProps('totalAssistKillsOnCraftEMC')} />
        <Field {...this.controller.getProps('totalFullKillsOfPlayerRank')} />
        <Field {...this.controller.getProps('totalSharedKillsOfPlayerRank')} />
        <Field {...this.controller.getProps('totalAssistKillsOfPlayerRank')} />
        <Field {...this.controller.getProps('totalFullKillsOfAIRank')} />
        <Field {...this.controller.getProps('totalSharedKillsOfAIRank')} />
        <Field {...this.controller.getProps('totalAssistKillsOfAIRank')} />
        <Field {...this.controller.getProps('totalHiddenCargoFound')} />
        <Field {...this.controller.getProps('totalLaserHit')} />
        <Field {...this.controller.getProps('totalLaserFired')} />
        <Field {...this.controller.getProps('totalWarheadHit')} />
        <Field {...this.controller.getProps('totalWarheadFired')} />
        <Field {...this.controller.getProps('totalLosses')} />
        <Field {...this.controller.getProps('totalLossesByCollision')} />
        <Field {...this.controller.getProps('totalLossesByStarship')} />
        <Field {...this.controller.getProps('totalLossesByMines')} />
        <Field {...this.controller.getProps('totalLossesByPlayerRank')} />
        <Field {...this.controller.getProps('totalLossesByAIRank')} />
        <Field {...this.controller.getProps('missionSPExercise')} />
        <Field {...this.controller.getProps('missionSPMelee')} />
        <Field {...this.controller.getProps('missionSPCombat')} />
        <Field {...this.controller.getProps('missionMPExercise')} />
        <Field {...this.controller.getProps('missionMPMelee')} />
        <Field {...this.controller.getProps('missionMPCombat')} />
        <Field {...this.controller.getProps('missionSPTourn')} />
        <Field {...this.controller.getProps('missionMPTourn')} />
        <Field {...this.controller.getProps('missionSPBattle')} />
        <Field {...this.controller.getProps('missionMPBattle')} />
        <Field {...this.controller.getProps('statusSPCampaign')} />
        <Field {...this.controller.getProps('statusMPCampaignUNK')} />
        <Field {...this.controller.getProps('missionSPCampaign')} />
        <Field {...this.controller.getProps('missionMPCampaign')} />
      </Host>
    )
  }
}
  