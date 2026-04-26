import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { PLTBattleProgressState } from "../../../model/XvT";
import { XvTPLTBattleProgressStateController } from "../../../controllers/XvT";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-xvt-plt-battle-progress-state",
  styleUrl: "plt-battle-progress-state.scss",
  shadow: false
})
export class XvTPLTBattleProgressStateComponent {
  @Element() public el: HTMLElement;
  @Prop() public pltbattleprogressstate: PLTBattleProgressState;

  private controller: XvTPLTBattleProgressStateController;

  public componentWillLoad(): void {
    this.controller = new XvTPLTBattleProgressStateController(this.pltbattleprogressstate);
  }

  public render(): JSX.Element {
    return (
      <Host>
        <Field {...this.controller.getProps('MissionsFlown')} />
        <Field {...this.controller.getProps('CombatMissionID')} />
        <Field {...this.controller.getProps('totalMissionCount')} />
        <Field {...this.controller.getProps('Outcome')} />
        <Field {...this.controller.getProps('BattleListIndex')} />
        <Field {...this.controller.getProps('CombatMissionListIndex')} />
        <Field {...this.controller.getProps('NumPlayers')} />
        <Field {...this.controller.getProps('totalScore')} />
      </Host>
    )
  }
}
  