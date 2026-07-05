import { Component, Prop, Host, h, JSX, Element } from "@stencil/core";
import { TriggerPair } from "../../../../old-assets/model/XWA";
import { XWATriggerPairController } from "../../../controllers/XWA";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-xwa-trigger-pair",
  styleUrl: "trigger-pair.scss",
  shadow: false,
})
export class XWATriggerPairComponent {
  @Element() public el: HTMLElement;
  @Prop() public triggerpair: TriggerPair;

  private controller: XWATriggerPairController;

  public componentWillLoad(): void {
    this.controller = new XWATriggerPairController(this.triggerpair);
  }

  public render(): JSX.Element {
    return (
      <Host>
        <Field {...this.controller.getProps("Trigger1")} />
        <Field {...this.controller.getProps("Trigger2")} />
        <Field {...this.controller.getProps("(Unused)")} />
        <Field {...this.controller.getProps("T1OrT2")} />
        <Field {...this.controller.getProps("(IOReserved)")} />
      </Host>
    );
  }
}
