import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { Order } from "../../../model/XvT";
import { XvTOrderController } from "../../../controllers/XvT";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-xvt-order",
  styleUrl: "order.scss",
  shadow: false
})
export class XvTOrderComponent {
  @Element() public el: HTMLElement;
  @Prop() public order: Order;

  private controller: XvTOrderController;

  public componentWillLoad(): void {
    this.controller = new XvTOrderController(this.order);
  }

  public render(): JSX.Element {
    return (
      <Host>
        <Field {...this.controller.getProps('Order')} />
        <Field {...this.controller.getProps('Throttle')} />
        <Field {...this.controller.getProps('Variable1')} />
        <Field {...this.controller.getProps('Variable2')} />
        <Field {...this.controller.getProps('Unknown6')} />
        <Field {...this.controller.getProps('Unknown7')} />
        <Field {...this.controller.getProps('Target3Type')} />
        <Field {...this.controller.getProps('Target4Type')} />
        <Field {...this.controller.getProps('Target3')} />
        <Field {...this.controller.getProps('Target4')} />
        <Field {...this.controller.getProps('Target3OrTarget4')} />
        <Field {...this.controller.getProps('Unknown8')} />
        <Field {...this.controller.getProps('Target1Type')} />
        <Field {...this.controller.getProps('Target1')} />
        <Field {...this.controller.getProps('Target2Type')} />
        <Field {...this.controller.getProps('Target2')} />
        <Field {...this.controller.getProps('Target1OrTarget2')} />
        <Field {...this.controller.getProps('Unknown9')} />
        <Field {...this.controller.getProps('Speed')} />
        <Field {...this.controller.getProps('Designation')} />
      </Host>
    )
  }
}
  