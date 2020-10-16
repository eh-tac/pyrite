import { Component, Prop, Host, h, JSX, Element } from "@stencil/core";
import { Order } from "../../../model/TIE";
import { TIEOrderController } from "../../../controllers/TIE";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-tie-order",
  styleUrl: "order.scss",
  shadow: false
})
export class TIEOrderComponent {
  @Element() public el: HTMLElement;
  @Prop() public order: Order;

  private controller: TIEOrderController;

  public componentWillLoad(): void {
    this.controller = new TIEOrderController(this.order);
  }

  public render(): JSX.Element {
    return (
      <Host>
        <Field {...this.controller.getProps("Order")} />
        <Field {...this.controller.getProps("Throttle")} />
        <Field {...this.controller.getProps("Variable1")} />
        <Field {...this.controller.getProps("Variable2")} />
        <Field {...this.controller.getProps("Unknown18")} />
        <Field {...this.controller.getProps("Target3Type")} />
        <Field {...this.controller.getProps("Target4Type")} />
        <Field {...this.controller.getProps("Target3")} />
        <Field {...this.controller.getProps("Target4")} />
        <Field {...this.controller.getProps("Target3OrTarget4")} />
        <Field {...this.controller.getProps("Target1Type")} />
        <Field {...this.controller.getProps("Target1")} />
        <Field {...this.controller.getProps("Target2Type")} />
        <Field {...this.controller.getProps("Target2")} />
        <Field {...this.controller.getProps("Target1OrTarget2")} />
      </Host>
    );
  }
}
