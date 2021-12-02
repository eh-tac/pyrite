import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { Waypt } from "../../../model/XWA";
import { XWAWayptController } from "../../../controllers/XWA";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-xwa-waypt",
  styleUrl: "waypt.scss",
  shadow: false
})
export class XWAWayptComponent {
  @Element() public el: HTMLElement;
  @Prop() public waypt: Waypt;

  private controller: XWAWayptController;

  public componentWillLoad(): void {
    this.controller = new XWAWayptController(this.waypt);
  }

  public render(): JSX.Element {
    return (
      <Host>
        <Field {...this.controller.getProps('X')} />
        <Field {...this.controller.getProps('Y')} />
        <Field {...this.controller.getProps('Z')} />
        <Field {...this.controller.getProps('Enabled')} />
      </Host>
    )
  }
}
  