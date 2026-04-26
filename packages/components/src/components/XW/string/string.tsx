import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { String } from "../../../model/XW";
import { XWStringController } from "../../../controllers/XW";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-xw-string",
  styleUrl: "string.scss",
  shadow: false
})
export class XWStringComponent {
  @Element() public el: HTMLElement;
  @Prop() public string: String;

  private controller: XWStringController;

  public componentWillLoad(): void {
    this.controller = new XWStringController(this.string);
  }

  public render(): JSX.Element {
    return (
      <Host>
        <Field {...this.controller.getProps('Length')} />
        <Field {...this.controller.getProps('String')} />
        <Field {...this.controller.getProps('Unnamed')} />
      </Host>
    )
  }
}
  