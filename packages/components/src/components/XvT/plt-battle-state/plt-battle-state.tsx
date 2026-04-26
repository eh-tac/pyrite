import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { PLTBattleState } from "../../../model/XvT";
import { XvTPLTBattleStateController } from "../../../controllers/XvT";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-xvt-plt-battle-state",
  styleUrl: "plt-battle-state.scss",
  shadow: false
})
export class XvTPLTBattleStateComponent {
  @Element() public el: HTMLElement;
  @Prop() public pltbattlestate: PLTBattleState;

  private controller: XvTPLTBattleStateController;

  public componentWillLoad(): void {
    this.controller = new XvTPLTBattleStateController(this.pltbattlestate);
  }

  public render(): JSX.Element {
    return (
      <Host>
        <Field {...this.controller.getProps('ConfigRandomSeed')} />
        <Field {...this.controller.getProps('IsInProgressUNK')} />
        <Field {...this.controller.getProps('ConfigBattleLength')} />
        <Field {...this.controller.getProps('ConfigGameRandomizeLevel')} />
        <Field {...this.controller.getProps('saveState')} />
        <Field {...this.controller.getProps('unknown2')} />
      </Host>
    )
  }
}
  