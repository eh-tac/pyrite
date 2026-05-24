import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { BrfStr } from "../../../model/XWA";
import { XWABrfStrController } from "../../../controllers/XWA";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-xwa-brf-str",
  styleUrl: "brf-str.scss",
  shadow: false
})
export class XWABrfStrComponent {
  @Element() public el: HTMLElement;
  @Prop() public brfstr: BrfStr;

  private controller: XWABrfStrController;

  public componentWillLoad(): void {
    this.controller = new XWABrfStrController(this.brfstr);
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
  