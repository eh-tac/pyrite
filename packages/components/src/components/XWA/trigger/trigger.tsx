import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { Trigger } from "../../../model/XWA";
import { XWATriggerController } from "../../../controllers/XWA";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-xwa-trigger",
  styleUrl: "trigger.scss",
  shadow: false
})
export class XWATriggerComponent {
  @Element() public el: HTMLElement;
  @Prop() public trigger: Trigger;

  private controller: XWATriggerController;

  public componentWillLoad(): void {
    this.controller = new XWATriggerController(this.trigger);
  }

  public render(): JSX.Element {
    return (
      <Host>
        <Field {...this.controller.getProps('Condition')} />
        <Field {...this.controller.getProps('VariableType')} />
        <Field {...this.controller.getProps('Variable')} />
        <Field {...this.controller.getProps('Amount')} />
        <Field {...this.controller.getProps('Parameter')} />
        <Field {...this.controller.getProps('Parameter2')} />
      </Host>
    )
  }
}
  