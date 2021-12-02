import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { GoalFG } from "../../../model/XWA";
import { XWAGoalFGController } from "../../../controllers/XWA";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-xwa-goal-fg",
  styleUrl: "goal-fg.scss",
  shadow: false
})
export class XWAGoalFGComponent {
  @Element() public el: HTMLElement;
  @Prop() public goalfg: GoalFG;

  private controller: XWAGoalFGController;

  public componentWillLoad(): void {
    this.controller = new XWAGoalFGController(this.goalfg);
  }

  public render(): JSX.Element {
    return (
      <Host>
        <Field {...this.controller.getProps('Argument')} />
        <Field {...this.controller.getProps('Condition')} />
        <Field {...this.controller.getProps('Amount')} />
        <Field {...this.controller.getProps('Points')} />
        <Field {...this.controller.getProps('Enabled')} />
        <Field {...this.controller.getProps('Team')} />
        <Field {...this.controller.getProps('Unknown42')} />
        <Field {...this.controller.getProps('Parameter')} />
        <Field {...this.controller.getProps('ActiveSequence')} />
        <Field {...this.controller.getProps('Unknown15')} />
      </Host>
    )
  }
}
  