import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { Tag } from "../../../model/XWA";
import { XWATagController } from "../../../controllers/XWA";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-xwa-tag",
  styleUrl: "tag.scss",
  shadow: false
})
export class XWATagComponent {
  @Element() public el: HTMLElement;
  @Prop() public tag: Tag;

  private controller: XWATagController;

  public componentWillLoad(): void {
    this.controller = new XWATagController(this.tag);
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
  