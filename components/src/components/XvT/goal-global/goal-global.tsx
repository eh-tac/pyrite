import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { GoalGlobal } from "../../../model/XvT";
import { XvTGoalGlobalController } from "../../../controllers/XvT";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-xvt-goal-global",
  styleUrl: "goal-global.scss",
  shadow: false
})
export class XvTGoalGlobalComponent {
  @Element() public el: HTMLElement;
  @Prop() public goalglobal: GoalGlobal;

  private controller: XvTGoalGlobalController;

  public componentWillLoad(): void {
    this.controller = new XvTGoalGlobalController(this.goalglobal);
  }

  public render(): JSX.Element {
    return (
      <Host>
        <Field {...this.controller.getProps('TriggerA')} />
        <Field {...this.controller.getProps('Trigger1OrTrigger2')} />
        <Field {...this.controller.getProps('TriggerB')} />
        <Field {...this.controller.getProps('Trigger2OrTrigger3')} />
        <Field {...this.controller.getProps('Trigger12OrTrigger34')} />
        <Field {...this.controller.getProps('Points')} />
      </Host>
    )
  }
}
  