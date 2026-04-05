import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { PLTTournamentProgressState } from "../../../model/XvT";
import { XvTPLTTournamentProgressStateController } from "../../../controllers/XvT";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-xvt-plt-tournament-progress-state",
  styleUrl: "plt-tournament-progress-state.scss",
  shadow: false
})
export class XvTPLTTournamentProgressStateComponent {
  @Element() public el: HTMLElement;
  @Prop() public plttournamentprogressstate: PLTTournamentProgressState;

  private controller: XvTPLTTournamentProgressStateController;

  public componentWillLoad(): void {
    this.controller = new XvTPLTTournamentProgressStateController(this.plttournamentprogressstate);
  }

  public render(): JSX.Element {
    return (
      <Host>
        <Field {...this.controller.getProps('unknown1')} />
        <Field {...this.controller.getProps('completedMissionCount')} />
        <Field {...this.controller.getProps('totalMissionCount')} />
        <Field {...this.controller.getProps('teamRecord')} />
        <Field {...this.controller.getProps('playersActive')} />
        <Field {...this.controller.getProps('teamsActive')} />
        <Field {...this.controller.getProps('unknown2')} />
      </Host>
    )
  }
}
  