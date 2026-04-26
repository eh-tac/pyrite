import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { Tag } from "../../../model/XW";
import { XWTagController } from "../../../controllers/XW";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-xw-tag",
  styleUrl: "tag.scss",
  shadow: false
})
export class XWTagComponent {
  @Element() public el: HTMLElement;
  @Prop() public tag: Tag;

  private controller: XWTagController;

  public componentWillLoad(): void {
    this.controller = new XWTagController(this.tag);
  }

  public render(): JSX.Element {
    return (
      <Host>
        <Field {...this.controller.getProps('Length')} />
        <Field {...this.controller.getProps('Unnamed')} />
      </Host>
    )
  }
}
  