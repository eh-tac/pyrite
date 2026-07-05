import { Component, Prop, Host, h, JSX, Element } from "@stencil/core";
import { Icon } from "../../../model/XWA";
import { XWAIconController } from "../../../controllers/XWA";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-xwa-icon",
  styleUrl: "icon.scss",
  shadow: false,
})
export class XWAIconComponent {
  @Element() public el: HTMLElement;
  @Prop() public icon: Icon;

  private controller: XWAIconController;

  public componentWillLoad(): void {
    this.controller = new XWAIconController(this.icon);
  }

  public render(): JSX.Element {
    return (
      <Host>
        <Field {...this.controller.getProps("Species")} />
        <Field {...this.controller.getProps("IFF")} />
        <Field {...this.controller.getProps("X")} />
        <Field {...this.controller.getProps("Y")} />
        <Field {...this.controller.getProps("Orientation")} />
      </Host>
    );
  }
}
