import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { LengthString } from "../../../model/XWA";
import { XWALengthStringController } from "../../../controllers/XWA";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-xwa-length-string",
  styleUrl: "length-string.scss",
  shadow: false
})
export class XWALengthStringComponent {
  @Element() public el: HTMLElement;
  @Prop() public lengthstring: LengthString;

  private controller: XWALengthStringController;

  public componentWillLoad(): void {
    this.controller = new XWALengthStringController(this.lengthstring);
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
  