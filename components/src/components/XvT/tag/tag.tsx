import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { Tag } from "../../../model/XvT";
import { XvTTagController } from "../../../controllers/XvT";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-xvt-tag",
  styleUrl: "tag.scss",
  shadow: false
})
export class XvTTagComponent {
  @Element() public el: HTMLElement;
  @Prop() public tag: Tag;

  private controller: XvTTagController;

  public componentWillLoad(): void {
    this.controller = new XvTTagController(this.tag);
  }

  public render(): JSX.Element {
    return (
      <Host>
        <Field {...this.controller.getProps('Length')} />
        <Field {...this.controller.getProps('Text')} />
      </Host>
    )
  }
}
  