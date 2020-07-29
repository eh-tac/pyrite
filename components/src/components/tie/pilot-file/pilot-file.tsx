import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { PilotFile } from "../../../model/TIE";
import { TIEPilotFileController } from "../../../controllers/TIE";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-tie-pilot-file",
  styleUrl: "pilot-file.scss",
  shadow: false
})
export class TIEPilotFileComponent {
  @Element() public el: HTMLElement;
  @Prop() public pilotfile: PilotFile;

  private controller: TIEPilotFileController;

  public componentWillLoad(): void {
    this.controller = new TIEPilotFileController(this.pilotfile);
  }

  public render(): JSX.Element {
    return (
      <Host>
        <Field {...this.controller.getProps('Start')} />
        <Field {...this.controller.getProps('PilotStatus')} />
        <Field {...this.controller.getProps('PilotRank')} />
        <Field {...this.controller.getProps('Difficulty')} />
        <Field {...this.controller.getProps('Score')} />
        <Field {...this.controller.getProps('SkillScore')} />
        <Field {...this.controller.getProps('SecretOrder')} />
        <Field {...this.controller.getProps('TrainingScores')} />
        <Field {...this.controller.getProps('TrainingLevels')} />
        <Field {...this.controller.getProps('CombatScores')} />
        <Field {...this.controller.getProps('CombatCompletes')} />
        <Field {...this.controller.getProps('BattleStatuses')} />
        <Field {...this.controller.getProps('BattleLastMissions')} />
        <Field {...this.controller.getProps('Persistence')} />
        <Field {...this.controller.getProps('SecretObjectives')} />
        <Field {...this.controller.getProps('BonusObjectives')} />
        <Field {...this.controller.getProps('BattleScores')} />
        <Field {...this.controller.getProps('TotalKills')} />
        <Field {...this.controller.getProps('TotalCaptures')} />
        <Field {...this.controller.getProps('KillsByType')} />
        <Field {...this.controller.getProps('LasersFired')} />
        <Field {...this.controller.getProps('LasersHit')} />
        <Field {...this.controller.getProps('WarheadsFired')} />
        <Field {...this.controller.getProps('WarheadsHit')} />
        <Field {...this.controller.getProps('CraftLost')} />
      </Host>
    )
  }
}
  