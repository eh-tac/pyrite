import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { XWAString } from "../../../model/XWA";
import { XWAStringController } from "../../../controllers/XWA";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-xwa-xwa-string",
  styleUrl: "xwa-string.scss",
  shadow: false
})
export class XWAStringComponent {
  @Element() public el: HTMLElement;
  @Prop() public xwastring: XWAString;

  private controller: XWAStringController;

  public componentWillLoad(): void {
    this.controller = new XWAStringController(this.xwastring);
  }

  public render(): JSX.Element {
    return (
      <Host>
        <Field {...this.controller.getProps('Magic')} />
      </Host>
    )
  }
}
  