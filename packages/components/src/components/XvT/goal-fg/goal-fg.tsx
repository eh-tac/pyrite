import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { GoalFG } from "../../../model/XvT";
import { XvTGoalFGController } from "../../../controllers/XvT";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-xvt-goal-fg",
  styleUrl: "goal-fg.scss",
  shadow: false
})
export class XvTGoalFGComponent {
  @Element() public el: HTMLElement;
  @Prop() public goalfg: GoalFG;

  private controller: XvTGoalFGController;

  public componentWillLoad(): void {
    this.controller = new XvTGoalFGController(this.goalfg);
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
        <Field {...this.controller.getProps('Unknown10')} />
        <Field {...this.controller.getProps('Unknown11')} />
        <Field {...this.controller.getProps('Unknown12')} />
        <Field {...this.controller.getProps('Unknown13')} />
        <Field {...this.controller.getProps('Unknown14')} />
        <Field {...this.controller.getProps('Reserved')} />
        <Field {...this.controller.getProps('Unknown16')} />
      </Host>
    )
  }
}
  