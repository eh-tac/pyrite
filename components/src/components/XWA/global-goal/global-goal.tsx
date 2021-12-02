import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { GlobalGoal } from "../../../model/XWA";
import { XWAGlobalGoalController } from "../../../controllers/XWA";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-xwa-global-goal",
  styleUrl: "global-goal.scss",
  shadow: false
})
export class XWAGlobalGoalComponent {
  @Element() public el: HTMLElement;
  @Prop() public globalgoal: GlobalGoal;

  private controller: XWAGlobalGoalController;

  public componentWillLoad(): void {
    this.controller = new XWAGlobalGoalController(this.globalgoal);
  }

  public render(): JSX.Element {
    return (
      <Host>
        <Field {...this.controller.getProps('Reserved')} />
        <Field {...this.controller.getProps('Unnamed')} />
      </Host>
    )
  }
}
  