import { Component, Prop, Host, h, JSX, Element } from "@stencil/core";
import { GlobalUnit } from "../../../model/XWA";
import { XWAGlobalUnitController } from "../../../controllers/XWA";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-xwa-global-unit",
  styleUrl: "global-unit.scss",
  shadow: false,
})
export class XWAGlobalUnitComponent {
  @Element() public el: HTMLElement;
  @Prop() public globalunit: GlobalUnit;

  private controller: XWAGlobalUnitController;

  public componentWillLoad(): void {
    this.controller = new XWAGlobalUnitController(this.globalunit);
  }

  public render(): JSX.Element {
    return (
      <Host>
        <Field {...this.controller.getProps("Name")} />
        <Field {...this.controller.getProps("Leader")} />
        <Field {...this.controller.getProps("SpecialCargoCraft")} />
        <Field {...this.controller.getProps("SpecialCargo")} />
        <Field {...this.controller.getProps("RandSpecCraft")} />
      </Host>
    );
  }
}
