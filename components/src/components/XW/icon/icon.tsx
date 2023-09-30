import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { Icon } from "../../../model/XW";
import { XWIconController } from "../../../controllers/XW";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-xw-icon",
  styleUrl: "icon.scss",
  shadow: false
})
export class XWIconComponent {
  @Element() public el: HTMLElement;
  @Prop() public icon: Icon;

  private controller: XWIconController;

  public componentWillLoad(): void {
    this.controller = new XWIconController(this.icon);
  }

  public render(): JSX.Element {
    return (
      <Host>
        <Field {...this.controller.getProps('CraftType')} />
        <Field {...this.controller.getProps('IFF')} />
        <Field {...this.controller.getProps('NumberOfCraft')} />
        <Field {...this.controller.getProps('NumberOfWaves')} />
        <Field {...this.controller.getProps('Name')} />
        <Field {...this.controller.getProps('Cargo')} />
        <Field {...this.controller.getProps('SpecialCargo')} />
        <Field {...this.controller.getProps('SpecialCargoCraft')} />
        <Field {...this.controller.getProps('Yaw')} />
        <Field {...this.controller.getProps('Pitch')} />
        <Field {...this.controller.getProps('Roll')} />
      </Host>
    )
  }
}
  