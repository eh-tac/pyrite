import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { Team } from "../../../model/XWA";
import { XWATeamController } from "../../../controllers/XWA";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-xwa-team",
  styleUrl: "team.scss",
  shadow: false
})
export class XWATeamComponent {
  @Element() public el: HTMLElement;
  @Prop() public team: Team;

  private controller: XWATeamController;

  public componentWillLoad(): void {
    this.controller = new XWATeamController(this.team);
  }

  public render(): JSX.Element {
    return (
      <Host>
        <Field {...this.controller.getProps('Reserved')} />
        <Field {...this.controller.getProps('Name')} />
        <Field {...this.controller.getProps('Allegiances')} />
        <Field {...this.controller.getProps('EndOfMissionMessages')} />
        <Field {...this.controller.getProps('Unknowns')} />
        <Field {...this.controller.getProps('EomVoiceIDs')} />
      </Host>
    )
  }
}
  