import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { String } from "../../../model/XWA";
import { XWAStringController } from "../../../controllers/XWA";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-xwa-string",
  styleUrl: "string.scss",
  shadow: false
})
export class XWAStringComponent {
  @Element() public el: HTMLElement;
  @Prop() public string: String;

  private controller: XWAStringController;

  public componentWillLoad(): void {
    this.controller = new XWAStringController(this.string);
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
  