import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { Skip } from "../../../model/XWA";
import { XWASkipController } from "../../../controllers/XWA";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-xwa-skip",
  styleUrl: "skip.scss",
  shadow: false
})
export class XWASkipComponent {
  @Element() public el: HTMLElement;
  @Prop() public skip: Skip;

  private controller: XWASkipController;

  public componentWillLoad(): void {
    this.controller = new XWASkipController(this.skip);
  }

  public render(): JSX.Element {
    return (
      <Host>
        <Field {...this.controller.getProps('Trigger1')} />
        <Field {...this.controller.getProps('Trigger2')} />
        <Field {...this.controller.getProps('Trigger1OrTrigger2')} />
      </Host>
    )
  }
}
  