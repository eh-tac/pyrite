import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { Team } from "../../../model/XvT";
import { XvTTeamController } from "../../../controllers/XvT";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-xvt-team",
  styleUrl: "team.scss",
  shadow: false
})
export class XvTTeamComponent {
  @Element() public el: HTMLElement;
  @Prop() public team: Team;

  private controller: XvTTeamController;

  public componentWillLoad(): void {
    this.controller = new XvTTeamController(this.team);
  }

  public render(): JSX.Element {
    return (
      <Host>
        <Field {...this.controller.getProps('Reserved')} />
        <Field {...this.controller.getProps('Name')} />
        <Field {...this.controller.getProps('Allegiances')} />
        <Field {...this.controller.getProps('EndOfMissionMessages')} />
      </Host>
    )
  }
}
  