import { Component, Prop, Host, h, JSX, Element } from "@stencil/core";
import { Trigger } from "../../../model/TIE";
import { TIETriggerController } from "../../../controllers/TIE";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-tie-trigger",
  styleUrl: "trigger.scss",
  shadow: false
})
export class TIETriggerComponent {
  @Element() public el: HTMLElement;
  @Prop() public trigger: Trigger;

  private controller: TIETriggerController;

  public componentWillLoad(): void {
    this.controller = new TIETriggerController(this.trigger);
  }

  public render(): JSX.Element {
    return (
      <Host>
        <Field {...this.controller.getProps("Condition")} />
        <Field {...this.controller.getProps("VariableType")} />
        <Field {...this.controller.getProps("Variable")} />
        <Field {...this.controller.getProps("TriggerAmount")} />
      </Host>
    );
  }
}
