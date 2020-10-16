import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { TeamStats } from "../../../model/XvT";
import { XvTTeamStatsController } from "../../../controllers/XvT";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-xvt-team-stats",
  styleUrl: "team-stats.scss",
  shadow: false
})
export class XvTTeamStatsComponent {
  @Element() public el: HTMLElement;
  @Prop() public teamstats: TeamStats;

  private controller: XvTTeamStatsController;

  public componentWillLoad(): void {
    this.controller = new XvTTeamStatsController(this.teamstats);
  }

  public render(): JSX.Element {
    return (
      <Host>
        <Field {...this.controller.getProps('MeleeMedals')} />
        <Field {...this.controller.getProps('TournamentMedals')} />
        <Field {...this.controller.getProps('MissionTopRatings')} />
        <Field {...this.controller.getProps('MissionMedals')} />
        <Field {...this.controller.getProps('PlayCounts')} />
        <Field {...this.controller.getProps('TotalKills')} />
        <Field {...this.controller.getProps('ExerciseKillsByType')} />
        <Field {...this.controller.getProps('MeleeKillsByType')} />
        <Field {...this.controller.getProps('CombatKillsByType')} />
        <Field {...this.controller.getProps('ExercisePartialsByType')} />
        <Field {...this.controller.getProps('MeleePartialsByType')} />
        <Field {...this.controller.getProps('CombatPartialsByType')} />
        <Field {...this.controller.getProps('ExerciseAssistsByType')} />
        <Field {...this.controller.getProps('MeleeAssistsByType')} />
        <Field {...this.controller.getProps('CombatAssistsByType')} />
        <Field {...this.controller.getProps('HiddenCargoFound')} />
        <Field {...this.controller.getProps('LasersHit')} />
        <Field {...this.controller.getProps('LasersFired')} />
        <Field {...this.controller.getProps('WarheadsHit')} />
        <Field {...this.controller.getProps('WarheadsFired')} />
        <Field {...this.controller.getProps('CraftLosses')} />
        <Field {...this.controller.getProps('CollisionLosses')} />
        <Field {...this.controller.getProps('StarshipLosses')} />
        <Field {...this.controller.getProps('MineLosses')} />
        <Field {...this.controller.getProps('TrainingMissionData')} />
        <Field {...this.controller.getProps('MeleeMissionData')} />
        <Field {...this.controller.getProps('CombatMissionData')} />
      </Host>
    )
  }
}
  