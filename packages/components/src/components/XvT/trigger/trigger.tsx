import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { Trigger } from "../../../model/XvT";
import { XvTTriggerController } from "../../../controllers/XvT";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-xvt-trigger",
  styleUrl: "trigger.scss",
  shadow: false
})
export class XvTTriggerComponent {
  @Element() public el: HTMLElement;
  @Prop() public trigger: Trigger;

  private controller: XvTTriggerController;

  public componentWillLoad(): void {
    this.controller = new XvTTriggerController(this.trigger);
  }

  public render(): JSX.Element {
    return (
      <Host>
        <Field {...this.controller.getProps('Condition')} />
        <Field {...this.controller.getProps('VariableType')} />
        <Field {...this.controller.getProps('Variable')} />
        <Field {...this.controller.getProps('Amount')} />
      </Host>
    )
  }
}
  