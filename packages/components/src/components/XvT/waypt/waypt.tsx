import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { Waypt } from "../../../model/XvT";
import { XvTWayptController } from "../../../controllers/XvT";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-xvt-waypt",
  styleUrl: "waypt.scss",
  shadow: false
})
export class XvTWayptComponent {
  @Element() public el: HTMLElement;
  @Prop() public waypt: Waypt;

  private controller: XvTWayptController;

  public componentWillLoad(): void {
    this.controller = new XvTWayptController(this.waypt);
  }

  public render(): JSX.Element {
    return (
      <Host>
        <Field {...this.controller.getProps('StartPoints')} />
        <Field {...this.controller.getProps('Waypoints')} />
        <Field {...this.controller.getProps('Rendezvous')} />
        <Field {...this.controller.getProps('Hyperspace')} />
        <Field {...this.controller.getProps('Briefings')} />
      </Host>
    )
  }
}
  