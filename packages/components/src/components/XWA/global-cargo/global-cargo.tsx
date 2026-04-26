import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { GlobalCargo } from "../../../model/XWA";
import { XWAGlobalCargoController } from "../../../controllers/XWA";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-xwa-global-cargo",
  styleUrl: "global-cargo.scss",
  shadow: false
})
export class XWAGlobalCargoComponent {
  @Element() public el: HTMLElement;
  @Prop() public globalcargo: GlobalCargo;

  private controller: XWAGlobalCargoController;

  public componentWillLoad(): void {
    this.controller = new XWAGlobalCargoController(this.globalcargo);
  }

  public render(): JSX.Element {
    return (
      <Host>
        <Field {...this.controller.getProps('Cargo')} />
        <Field {...this.controller.getProps('Unknown1')} />
        <Field {...this.controller.getProps('Unknown2')} />
        <Field {...this.controller.getProps('Unknown3')} />
        <Field {...this.controller.getProps('Unknown4')} />
        <Field {...this.controller.getProps('Unknown5')} />
      </Host>
    )
  }
}
  