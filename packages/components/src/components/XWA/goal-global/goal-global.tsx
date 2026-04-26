import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { GoalGlobal } from "../../../model/XWA";
import { XWAGoalGlobalController } from "../../../controllers/XWA";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-xwa-goal-global",
  styleUrl: "goal-global.scss",
  shadow: false
})
export class XWAGoalGlobalComponent {
  @Element() public el: HTMLElement;
  @Prop() public goalglobal: GoalGlobal;

  private controller: XWAGoalGlobalController;

  public componentWillLoad(): void {
    this.controller = new XWAGoalGlobalController(this.goalglobal);
  }

  public render(): JSX.Element {
    return (
      <Host>
        <Field {...this.controller.getProps('Trigger1')} />
        <Field {...this.controller.getProps('Trigger2')} />
        <Field {...this.controller.getProps('Trigger1OrTrigger2')} />
        <Field {...this.controller.getProps('Unknown1')} />
        <Field {...this.controller.getProps('Trigger3')} />
        <Field {...this.controller.getProps('Trigger4')} />
        <Field {...this.controller.getProps('Trigger3OrTrigger4')} />
        <Field {...this.controller.getProps('Unknown2')} />
        <Field {...this.controller.getProps('Triggers12OrTriggers34')} />
        <Field {...this.controller.getProps('Unknown3')} />
        <Field {...this.controller.getProps('Points')} />
        <Field {...this.controller.getProps('Unknown4')} />
        <Field {...this.controller.getProps('Unknown5')} />
        <Field {...this.controller.getProps('Unknown6')} />
        <Field {...this.controller.getProps('ActiveSquence')} />
      </Host>
    )
  }
}
  