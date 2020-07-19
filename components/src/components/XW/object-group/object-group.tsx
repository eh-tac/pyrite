import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { ObjectGroup } from "../../../model/XW";
import { XWObjectGroupController } from "../../../controllers/XW";
import { Field } from "../../fields/field";

@Component({
  tag: "xpyrite-xw-object-group",
  styleUrl: "object-group.scss",
  shadow: false
})
export class XWObjectGroupComponent {
  @Element() public el: HTMLElement;
  @Prop() public objectgroup: ObjectGroup;

  private controller: XWObjectGroupController;

  public componentWillLoad(): void {
    this.controller = new XWObjectGroupController(this.objectgroup);
  }

  public render(): JSX.Element {
    return (
      <Host>
        <Field {...this.controller.getProps('Name')} />
        <Field {...this.controller.getProps('Cargo')} />
        <Field {...this.controller.getProps('SpecialCargo')} />
        <Field {...this.controller.getProps('Reserved')} />
        <Field {...this.controller.getProps('ObjectType')} />
        <Field {...this.controller.getProps('IFF')} />
        <Field {...this.controller.getProps('Objective')} />
        <Field {...this.controller.getProps('NumberOfObjects')} />
        <Field {...this.controller.getProps('PositionX')} />
        <Field {...this.controller.getProps('PositionY')} />
        <Field {...this.controller.getProps('PositionZ')} />
        <Field {...this.controller.getProps('Unknown1')} />
        <Field {...this.controller.getProps('Unknown2')} />
        <Field {...this.controller.getProps('Unknown3')} />
      </Host>
    )
  }
}
  