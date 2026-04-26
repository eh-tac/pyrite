import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { GlobalGoal } from "../../../model/XvT";
import { XvTGlobalGoalController } from "../../../controllers/XvT";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-xvt-global-goal",
  styleUrl: "global-goal.scss",
  shadow: false
})
export class XvTGlobalGoalComponent {
  @Element() public el: HTMLElement;
  @Prop() public globalgoal: GlobalGoal;

  private controller: XvTGlobalGoalController;

  public componentWillLoad(): void {
    this.controller = new XvTGlobalGoalController(this.globalgoal);
  }

  public render(): JSX.Element {
    return (
      <Host>
        <Field {...this.controller.getProps('Reserved')} />
        <Field {...this.controller.getProps('Goal')} />
      </Host>
    )
  }
}
  