import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { XvTString } from "../../../model/XvT";
import { XvTStringController } from "../../../controllers/XvT";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-xvt-xv-t-string",
  styleUrl: "xv-t-string.scss",
  shadow: false
})
export class XvTStringComponent {
  @Element() public el: HTMLElement;
  @Prop() public xvtstring: XvTString;

  private controller: XvTStringController;

  public componentWillLoad(): void {
    this.controller = new XvTStringController(this.xvtstring);
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
  