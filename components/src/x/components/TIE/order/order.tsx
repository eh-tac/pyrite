import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { Order } from "../../../model/TIE";
import { TIEOrderController } from "../../../controllers/TIE";

@Component({
  tag: "pyrite-TIE-order",
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
      {this.controller.render("Order")}
      {this.controller.render("Throttle")}
      {this.controller.render("Variable1")}
      {this.controller.render("Variable2")}
      {this.controller.render("Unknown18")}
      {this.controller.render("Target3Type")}
      {this.controller.render("Target4Type")}
      {this.controller.render("Target3")}
      {this.controller.render("Target4")}
      {this.controller.render("Target3OrTarget4")}
      {this.controller.render("Target1Type")}
      {this.controller.render("Target1")}
      {this.controller.render("Target2Type")}
      {this.controller.render("Target2")}
      {this.controller.render("Target1OrTarget2")}        
      </Host>
    )
  }
}
  