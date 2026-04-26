import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { PLTFactionRecord } from "../../../model/XvT";
import { XvTPLTFactionRecordController } from "../../../controllers/XvT";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-xvt-plt-faction-record",
  styleUrl: "plt-faction-record.scss",
  shadow: false
})
export class XvTPLTFactionRecordComponent {
  @Element() public el: HTMLElement;
  @Prop() public pltfactionrecord: PLTFactionRecord;

  private controller: XvTPLTFactionRecordController;

  public componentWillLoad(): void {
    this.controller = new XvTPLTFactionRecordController(this.pltfactionrecord);
  }

  public render(): JSX.Element {
    return (
      <Host>
        <Field {...this.controller.getProps('totalMissionsFlown')} />
        <Field {...this.controller.getProps('lastMissionTeam')} />
        <Field {...this.controller.getProps('lastMissionType')} />
        <Field {...this.controller.getProps('lastMissionTrainingSelected')} />
        <Field {...this.controller.getProps('lastMissionMeleeSelected')} />
        <Field {...this.controller.getProps('lastMissionTournamentSelected')} />
        <Field {...this.controller.getProps('lastMissionCombatSelected')} />
        <Field {...this.controller.getProps('lastMissionBattleSelected')} />
        <Field {...this.controller.getProps('unknown0x20')} />
        <Field {...this.controller.getProps('earnedMedalCount')} />
        <Field {...this.controller.getProps('debriefMeleePlaqueType')} />
        <Field {...this.controller.getProps('debriefTournamentTrophyType')} />
        <Field {...this.controller.getProps('debriefMissionBadgeType')} />
        <Field {...this.controller.getProps('debriefBattleMedalType')} />
        <Field {...this.controller.getProps('UnknownRecord4')} />
        <Field {...this.controller.getProps('totalFactionScore')} />
        <Field {...this.controller.getProps('totalCategoryScore')} />
        <Field {...this.controller.getProps('totalCategoryFlown')} />
        <Field {...this.controller.getProps('totalCampaignExerciseFlown')} />
        <Field {...this.controller.getProps('totalTournamentMeleeFlown')} />
        <Field {...this.controller.getProps('totalBattleCombatFlown')} />
        <Field {...this.controller.getProps('totalFullKills')} />
        <Field {...this.controller.getProps('totalFriendlyFullKills')} />
        <Field {...this.controller.getProps('totalFullKillsByShipExercise')} />
        <Field {...this.controller.getProps('totalFullKillsByShipMelee')} />
        <Field {...this.controller.getProps('totalFullKillsByShipCombat')} />
        <Field {...this.controller.getProps('totalSharedKillsOfShipExercise')} />
        <Field {...this.controller.getProps('totalSharedKillsOfShipMelee')} />
        <Field {...this.controller.getProps('totalSharedKillsOfShipCombat')} />
        <Field {...this.controller.getProps('totalAssistKillsOfShipExercise')} />
        <Field {...this.controller.getProps('totalAssistKillsOfShipMelee')} />
        <Field {...this.controller.getProps('totalAssistKillsOfShipCombat')} />
        <Field {...this.controller.getProps('totalFullKillsOfPlayerRank')} />
        <Field {...this.controller.getProps('totalSharedKillsOfPlayerRank')} />
        <Field {...this.controller.getProps('totalAssistKillsOfPlayerRank')} />
        <Field {...this.controller.getProps('totalFullKillsOfAIRank')} />
        <Field {...this.controller.getProps('totalSharedKillsOfAIRank')} />
        <Field {...this.controller.getProps('totalAssistKillsOfAIRank')} />
        <Field {...this.controller.getProps('totalHiddenCargoFound')} />
        <Field {...this.controller.getProps('totalCannonHit')} />
        <Field {...this.controller.getProps('totalCannonFired')} />
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
      </Host>
    )
  }
}
  